<?php

namespace App\Http\Controllers\GuestController;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

    $existingReservation = $room->reservations()->where(function ($query) use ($checkIn, $checkOut) {
        $query->where('status', '!=', 'cancelled') 
              ->where(function ($query) use ($checkIn, $checkOut) {
                  $query->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
              });
    })->exists();

        if ($existingReservation) {
            return back()->withErrors([
                'error' => "Room is already booked between <strong>{$checkIn}</strong> and <strong>{$checkOut}</strong>. Please choose different dates."
            ])->withInput();
        }

        // Create the reservation
        Reservation::create([
            'user_id'    => Auth::id(),
            'room_id'    => $room->id,
            'check_in'   => $checkIn,
            'check_out'  => $checkOut,
            'status'     => 'pending',
        ]);

        return redirect()->route('booking.my-reservations')->with('success', 'Your booking has been successfully created!');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('booking.my-reservations')->with('success', 'Reservation has been cancelled.');
    }

    public function myReservations()
    {
        $reservations = Auth::user()->reservations()->with('room')->latest()->get();
        return view('guest.booking.my-reservations', compact('reservations'));
    }
public function calendarData($roomId)
{
    $room = Room::findOrFail($roomId);
    
    $reservations = $room->reservations()
        ->where('status', '!=', 'cancelled')
        ->get(['check_in', 'check_out']);

    $events = [];

    foreach ($reservations as $res) {
        $events[] = [
            'title' => 'Booked',
            'start' => $res->check_in->toDateString(),
            'end' => $res->check_out->toDateString(),
            'color' => '#ff0000', 
        ];
    }

    return response()->json($events);
}


}
