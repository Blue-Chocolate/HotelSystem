<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminGuestController extends Controller
{
    public function index()
    {
        $guests = User::whereHas('reservations')->with('reservations')->get();
        return view('admin.guests.index', compact('guests'));
    }
    
}
