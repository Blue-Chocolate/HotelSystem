@extends('layouts.admin')

@section('title', 'Rooms')

@section('content')
    <h1>Available Rooms</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Price per Night</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
            <tr>
                <td>
                    @if($room->image_url)
                        <img src="{{ $room->image_url }}" alt="Room {{ $room->room_number }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 8px;">
                    @endif
                    {{ $room->room_number }}
                </td>
                <td>{{ $room->type }}</td>
                <td>{{ $room->capacity }}</td>
                <td>${{ number_format($room->price_per_night, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
