<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create regular users with guest role
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole('guest');
            });
    }
}
