<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Carbon;

class ReservationSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        // Assuming you have a user and rooms already created
        $user = User::factory()->create();  // Create a new user
        $room = Room::factory()->create();  // Create a new room

        Reservation::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in' => Carbon::now()->addDays(2),
            'check_out' => Carbon::now()->addDays(5),
            'status' => 'pending',
        ]);
    }
}
