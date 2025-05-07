@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')
    <h1>Reservations</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Guest</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr class="{{ !$reservation->room->is_available ? 'bg-success' : '' }}">
                    <td>{{ $reservation->room->room_number }}</td>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->check_in->format('d-m-Y') }}</td>
                    <td>{{ $reservation->check_out->format('d-m-Y') }}</td>
                    <td>${{ number_format($reservation->total_price, 2) }}</td>
                    <td>
                        <span class="badge {{ !$reservation->room->is_available ? 'badge-success' : 'badge-warning' }}">
                            {{ !$reservation->room->is_available ? 'Reserved' : 'Available' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.reserve.edit', $reservation->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <form action="{{ route('admin.reserve.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
