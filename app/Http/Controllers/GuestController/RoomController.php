<?php

namespace App\Http\Controllers\GuestController;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::where('is_available', true);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $rooms = $query->get();
        return view('guest.rooms.index', compact('rooms'));
    }

   public function show(Room $room)
{
    $reservations = $room->reservations()->get();

    $events = $reservations->map(function ($reservation) {
        return [
            'title' => 'Reserved',
            'start' => $reservation->check_in->format('Y-m-d'),
            'end'   => $reservation->check_out->copy()->addDay()->format('Y-m-d'), 
            'color' => 'red'
        ];
    });

    return view('guest.rooms.show', [
        'room' => $room,
        'events' => $events
    ]);
}
    
}
