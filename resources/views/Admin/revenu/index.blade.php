@extends('layouts.admin')

@section('title', 'Revenue')

@section('content')
    <h1>Revenue Report</h1>
    <p>Total Revenue: <strong>${{ number_format($totalRevenue, 2) }}</strong></p>

    <table class="table">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Guest</th>
                <th>Room</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->room->room_number }}</td>
                    <td>${{ number_format($reservation->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
