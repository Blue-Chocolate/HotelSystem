<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;

class ApiReservationController extends Controller
{
    /**
     * GET /api/reservations
     */
    public function index(Request $request)
    {
        // You can restrict to the user’s own reservations if you like:
        // $reservations = Reservation::where('user_id', $request->user()->id)->get();
        $reservations = Reservation::with(['room', 'user'])->get();
        return response()->json($reservations);
    }

    /**
     * POST /api/reservations
     */
    public function store(Request $request)
    {
        // 1) Validate input
        $data = $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => ['required','date','after_or_equal:today'],
            'check_out' => ['required','date','after:check_in'],
        ]);

        // 2) Parse dates & compute nights
        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights   = $checkOut->diffInDays($checkIn);

        // 3) Lookup room & compute price
        $room       = Room::findOrFail($data['room_id']);
        $totalPrice = $room->price_per_night * $nights;

        // 4) Create reservation tied to the authenticated user
        $reservation = Reservation::create([
            'room_id'     => $room->id,
            'user_id'     => $request->user()->id,
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
            'status'      => 'reserved',
        ]);

        // 5) Mark room unavailable
        $room->update(['is_available' => false]);

        // 6) Return the created model (201 status)
        return response()->json($reservation, 201);
    }

    /**
     * PUT /api/reservations/{id}
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $data = $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => ['required','date','after_or_equal:today'],
            'check_out' => ['required','date','after:check_in'],
        ]);

        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights   = $checkOut->diffInDays($checkIn);

        $room       = Room::findOrFail($data['room_id']);
        $totalPrice = $room->price_per_night * $nights;

        $reservation->update([
            'room_id'     => $room->id,
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
        ]);

        return response()->json($reservation);
    }

    /**
     * DELETE /api/reservations/{id}
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->room->update(['is_available' => true]);
        $reservation->delete();

        return response()->json(null, 204);
    }
}
