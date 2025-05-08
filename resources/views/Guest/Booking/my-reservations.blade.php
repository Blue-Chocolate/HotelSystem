@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Reservations</h2>

    @foreach($reservations as $reservation)
    <div class="card bg-body border-0 shadow-sm mb-3 p-3">
        <h5>Room: {{ $reservation->room->room_number }}</h5>
        <p>Check-in: {{ $reservation->check_in }}</p>
        <p>Check-out: {{ $reservation->check_out }}</p>
        <p>Status: <span class="badge bg-{{ $reservation->status === 'cancelled' ? 'danger' : 'success' }}">{{ ucfirst($reservation->status) }}</span></p>

        @if($reservation->status === 'pending')
        <form method="POST" action="{{ route('booking.cancel', $reservation->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm mt-2">Cancel Reservation</button>
        </form>
        @endif
    </div>
    @endforeach
</div>
@endsection
