<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['room', 'user'])->latest()->get();
        return view('admin.reserve.index', compact('reservations'));
    }

    public function create()
    {
        $rooms = Room::all();
        $guests = User::all();
        return view('admin.reserve.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);

        $room = Room::findOrFail($request->room_id);
        $totalPrice = $room->price_per_night * $nights;

        $reservation = Reservation::create([
            'room_id' => $room->id,
            'user_id' => $request->user_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => $totalPrice,
            'status' => 'pending', 
        ]);

        $room->update(['is_available' => false]);

        return redirect()->route('admin.reserve.index')->with('success', 'Reservation created successfully.');
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $rooms = Room::all();
        $users = User::all();
        return view('admin.reserve.edit', compact('reservation', 'rooms', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $reservation = Reservation::findOrFail($id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);

        $room = Room::findOrFail($request->room_id);
        $totalPrice = $room->price_per_night * $nights;

        $reservation->update([
            'room_id' => $room->id,
            'user_id' => $request->user_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('admin.reserve.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->room->update(['is_available' => true]);
        $reservation->delete();

        return redirect()->route('admin.reserve.index')->with('success', 'Reservation deleted successfully.');
    }
}
