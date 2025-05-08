<?php

namespace App\Http\Controllers\GuestController;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    // Store a new reservation
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        // Check if the room is already reserved for the selected dates
        $existingReservation = $room->reservations()->where(function ($query) use ($request) {
            $query->where('check_in', '<', $request->check_out)
                ->where('check_out', '>', $request->check_in);
        })->exists();

        if ($existingReservation) {
            return back()->withErrors(['error' => 'This room is already booked for the selected dates.']);
        }

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.my-reservations')->with('success', 'Your booking has been successfully created!');
    }
    public function cancel($id)
{
    $reservation = Reservation::findOrFail($id);

    // Ensure that the reservation belongs to the current user
    if ($reservation->user_id !== Auth::id()) {
        return abort(403);
    }

    // Mark the reservation as cancelled
    $reservation->update(['status' => 'cancelled']);

    return redirect()->route('booking.my-reservations')->with('success', 'Reservation has been cancelled.');
}
public function myReservations()
{
    $reservations = Auth::user()->reservations()->with('room')->latest()->get();

    return view('guest.booking.my-reservations', compact('reservations'));
}

}
