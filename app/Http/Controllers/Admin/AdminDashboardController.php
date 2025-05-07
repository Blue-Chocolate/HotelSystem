<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $guestCount = User::count();
        $availableRooms = Room::whereDoesntHave('reservations', function ($q) {
            $q->where('check_in', '<=', now())->where('check_out', '>=', now());
        })->count();

        $reservationCount = Reservation::count();
        $revenue = Reservation::sum('total_price'); // Assuming `total_price` column

        return view('admin.dashboard', compact(
            'guestCount',
            'availableRooms',
            'reservationCount',
            'revenue'
        ));
    }

    public function welcome()
    {
        return redirect()->route('admin.reserve.index');
    }
}

