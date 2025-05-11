<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_available', true)->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number'    => 'required|string|max:255',
            'type'           => 'required|string|max:255',
            'capacity'       => 'required|integer',
            'price_per_night'=> 'required|numeric',
            'image_url'      => 'nullable|url',
            'is_available'   => 'required|boolean',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number'    => 'required|string|max:255',
            'type'           => 'required|string|max:255',
            'capacity'       => 'required|integer',
            'price_per_night'=> 'required|numeric',
            'image_url'      => 'nullable|url',
            'is_available'   => 'required|boolean',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }

    public function calendarData(Room $room)
    {
        $reservations = $room->reservations()->where('status', '!=', 'cancelled')->get();

        $events = $reservations->map(function ($reservation) {
            return [
                'title' => 'Booked',
                'start' => $reservation->check_in->format('Y-m-d'),
                'end'   => $reservation->check_out->copy()->addDay()->format('Y-m-d'), // FullCalendar needs exclusive end
                'color' => 'red',
            ];
        });

        return response()->json($events);
    }
}
