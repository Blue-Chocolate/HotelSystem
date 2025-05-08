<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminRevenueController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'room'])->get();
        $totalRevenue = $reservations->sum('total_price');
        return view('admin.revenu.index', compact('reservations', 'totalRevenue'));
    }
    }
