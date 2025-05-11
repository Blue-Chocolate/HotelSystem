<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiRoomController extends Controller
{
    /**
     * Check room availability for given dates
     */
    public function checkAvailability(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        $isAvailable = $room->isAvailableForDates($checkIn, $checkOut);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Room is available for these dates' : 'Room is not available for these dates'
        ]);
    }
}
