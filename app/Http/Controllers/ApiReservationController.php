<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['room', 'user'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $reservations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'status' => 'required|in:pending,approved,cancelled',
        ]);

        $room = Room::findOrFail($request->room_id);
        
        // Check if room is already booked for these dates
        $existingReservation = $room->reservations()
            ->where(function ($query) use ($request) {
                $query->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in)
                    ->where('status', '!=', 'cancelled');
            })->exists();

        if ($existingReservation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room is already booked for these dates'
            ], 422);
        }

        // Calculate total price
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price_per_night * $nights;

        $reservation = Reservation::create([
            'room_id' => $request->room_id,
            'user_id' => $request->user_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $request->status,
            'total_price' => $totalPrice
        ]);

        if ($request->status === 'approved') {
            $room->update(['is_available' => false]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation created successfully',
            'data' => $reservation->load('room', 'user')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'exists:rooms,id',
            'user_id' => 'exists:users,id',
            'check_in' => 'date|after_or_equal:today',
            'check_out' => 'date|after:check_in',
            'status' => 'in:pending,approved,cancelled',
        ]);

        $reservation = Reservation::findOrFail($id);

        if ($request->has(['check_in', 'check_out'])) {
            $checkIn = Carbon::parse($request->check_in);
            $checkOut = Carbon::parse($request->check_out);
            $nights = $checkOut->diffInDays($checkIn);
            $room = $request->has('room_id') 
                ? Room::findOrFail($request->room_id) 
                : $reservation->room;
            
            $request->merge(['total_price' => $room->price_per_night * $nights]);
        }

        $reservation->update($request->all());

        // Handle room availability based on status
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $reservation->room->update(['is_available' => false]);
            } elseif ($request->status === 'cancelled') {
                $reservation->room->update(['is_available' => true]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation updated successfully',
            'data' => $reservation->fresh(['room', 'user'])
        ]);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Make room available if reservation was approved
        if ($reservation->status === 'approved') {
            $reservation->room->update(['is_available' => true]);
        }
        
        $reservation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation deleted successfully'
        ], 204);
    }
}
