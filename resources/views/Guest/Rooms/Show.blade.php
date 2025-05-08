@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-body border-0 shadow-sm p-4">
        <h2>Room {{ $room->room_number }}</h2>
        <p><strong>Type:</strong> {{ $room->type }}</p>
        <p><strong>Capacity:</strong> {{ $room->capacity }} guests</p>
        <p><strong>Price per night:</strong> ${{ $room->price_per_night }}</p>

        <!-- Availability check -->
        @if($room->reservations()->where('check_out', '>=', now())->exists())
            <p class="text-warning">This room is not available for booking during selected dates.</p>
        @else
            <form method="POST" action="{{ route('booking.store', $room) }}">
                @csrf

                <div class="mb-3">
                    <label for="check_in" class="form-label">Check-in Date</label>
                    <input type="date" name="check_in" id="check_in" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="check_out" class="form-label">Check-out Date</label>
                    <input type="date" name="check_out" id="check_out" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Confirm Booking</button>
            </form>
        @endif
    </div>
</div>
@endsection
