<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $rooms = Room::all();
        return view('guest.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        $checkIn = request('check_in') ? Carbon::parse(request('check_in')) : null;
        $checkOut = request('check_out') ? Carbon::parse(request('check_out')) : null;

        $isAvailable = true;
        if ($checkIn && $checkOut) {
            $isAvailable = $room->isAvailableForDates($checkIn, $checkOut);
        }

        return view('guest.rooms.show', [
            'room' => $room,
            'isAvailable' => $isAvailable
        ]);
    }
}