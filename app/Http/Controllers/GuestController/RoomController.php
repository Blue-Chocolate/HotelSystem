<?php

namespace App\Http\Controllers\GuestController;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_available', true)->get();
        return view('guest.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('guest.rooms.show', compact('room'));
    }
}
