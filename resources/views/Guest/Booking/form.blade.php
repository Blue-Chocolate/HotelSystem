@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-body border-0 shadow-sm p-4">
        <h2 class="mb-4">Book Room {{ $room->room_number }}</h2>

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
    </div>
</div>
@endsection
