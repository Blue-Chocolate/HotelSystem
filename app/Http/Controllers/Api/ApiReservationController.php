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
        // Only show user's own reservations
        $reservations = $request->user()->reservations()->with('room')->get();
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

        // 2) Parse dates
        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        
        // 3) Lookup room
        $room = Room::findOrFail($data['room_id']);
        
        // 4) Check if room is available for these dates
        if (!$room->isAvailableForDates($checkIn, $checkOut)) {
            return response()->json([
                'message' => 'Room is not available for the selected dates',
                'errors' => ['dates' => ['The room is already booked for these dates']]
            ], 422);
        }

        // 5) Calculate total price
        $nights = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price_per_night * $nights;

        // 6) Create reservation
        $reservation = Reservation::create([
            'room_id'     => $room->id,
            'user_id'     => $request->user()->id,
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
            'status'      => 'confirmed',
        ]);

        // 7) Return the created reservation
        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation->load('room')
        ], 201);
    }

    /**
     * PUT /api/reservations/{id}
     */
    public function update(Request $request, $id)
    {
        // 1) Find reservation and check ownership
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 2) Validate input
        $data = $request->validate([
            'check_in'  => ['required','date','after_or_equal:today'],
            'check_out' => ['required','date','after:check_in'],
        ]);

        // 3) Parse dates
        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);

        // 4) Check if room is available for new dates (excluding current reservation)
        if (!$reservation->room->isAvailableForDates($checkIn, $checkOut, $reservation->id)) {
            return response()->json([
                'message' => 'Room is not available for the selected dates',
                'errors' => ['dates' => ['The room is already booked for these dates']]
            ], 422);
        }

        // 5) Calculate new total price
        $nights = $checkOut->diffInDays($checkIn);
        $totalPrice = $reservation->room->price_per_night * $nights;

        // 6) Update reservation
        $reservation->update([
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'message' => 'Reservation updated successfully',
            'reservation' => $reservation->load('room')
        ]);
    }

    /**
     * DELETE /api/reservations/{id}
     */
    public function destroy($id)
    {
        // Find reservation and check ownership
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== request()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reservation cancelled successfully']);
    }
}
