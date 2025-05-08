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
        $rooms = Room::where('is_available', true)->get();
        $guests = User::all();
        return view('admin.reserve.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'user_id'   => 'required|exists:users,id',
            'check_in'  => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $today = Carbon::today();

        if ($checkIn->lt($today) || $checkOut->lt($today)) {
            return back()->withErrors(['check_in' => 'Dates cannot be in the past.']);
        }

        $room = Room::findOrFail($request->room_id);

        if ($this->hasDateConflict($room->id, $checkIn->copy(), $checkOut->copy())) {
            return back()->withErrors(['room_id' => 'Room is already booked for the selected dates.']);
        }

        $nights = $checkOut->diffInDays($checkIn);
        $totalPrice = $room->price_per_night * $nights;

        Reservation::create([
            'room_id'     => $room->id,
            'user_id'     => $request->user_id,
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
            'status'      => 'pending',
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
            'room_id'   => 'required|exists:rooms,id',
            'user_id'   => 'required|exists:users,id',
            'check_in'  => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $today = Carbon::today();

        if ($checkIn->lt($today) || $checkOut->lt($today)) {
            return back()->withErrors(['check_in' => 'Reservation dates cannot be in the past.']);
        }

        $reservation = Reservation::findOrFail($id);
        $oldRoomId = $reservation->room_id;
        $newRoom = Room::findOrFail($request->room_id);

        if ($this->hasDateConflict($newRoom->id, $checkIn->copy(), $checkOut->copy(), $reservation->id)) {
            return back()->withErrors(['room_id' => 'Room is already booked for the selected dates.']);
        }

        $nights = $checkOut->diffInDays($checkIn);
        $totalPrice = $newRoom->price_per_night * $nights;

        $reservation->update([
            'room_id'     => $newRoom->id,
            'user_id'     => $request->user_id,
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'total_price' => $totalPrice,
        ]);

        if ($oldRoomId !== $newRoom->id) {
            Room::find($oldRoomId)?->update(['is_available' => true]);
            $newRoom->update(['is_available' => false]);
        }

        return redirect()->route('admin.reserve.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->room->update(['is_available' => true]);
        $reservation->delete();

        return redirect()->route('admin.reserve.index')->with('success', 'Reservation deleted successfully.');
    }

    private function hasDateConflict($roomId, $checkIn, $checkOut, $excludeReservationId = null)
    {
        $query = Reservation::where('room_id', $roomId)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut->copy()->subDay()])
                  ->orWhereBetween('check_out', [$checkIn->copy()->addDay(), $checkOut]);
            });

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->exists();
    }
}
