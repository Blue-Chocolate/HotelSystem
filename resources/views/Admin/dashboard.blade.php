@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dashboard {
        padding: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .card {
        background-color: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(32, 40, 179, 0.1);
        transition: all 0.3s ease;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link:hover .card {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .card h2 {
        margin: 0 0 1rem 0;
        color: #2c3e50;
    }

    .btn-new-reservation {
        display: inline-block;
        margin-top: 2rem;
        background-color: #3498db;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn-new-reservation:hover {
        background-color: #2c3e50;
        color: white;
        text-decoration: none;
    }

    @media (prefers-color-scheme: dark) {
        .card {
            background-color: rgb(31 41 55);
            color: rgb(243 244 246);
        }
        
        .card h2 {
            color: #3498db;
        }
    }
</style>

<div class="dashboard">
    <a href="{{ route('admin.reserve.index') }}" class="card-link">
        <div class="card">
            <h2>Reservations</h2>
            <p>{{ $reservationCount }} total bookings</p>
        </div>
    </a>

    <a href="{{ route('admin.guests.index') }}" class="card-link">
        <div class="card">
            <h2>Guests</h2>
            <p>{{ $guestCount }} total guests</p>
        </div>
    </a>

    <a href="{{ route('admin.rooms.index') }}" class="card-link">
        <div class="card">
            <h2>Rooms Available</h2>
            <p>{{ $availableRooms }} rooms available</p>
        </div>
    </a>

    <a href="{{ route('admin.revenue.index') }}" class="card-link">
        <div class="card">
            <h2>Revenue</h2>
            <p>${{ number_format($revenue, 2) }} revenue</p>
        </div>
    </a>
</div>

<div>
    <a href="{{ route('admin.reserve.create') }}" class="btn-new-reservation">
        + Make Reservation for Guest
    </a>
</div>
@endsection
