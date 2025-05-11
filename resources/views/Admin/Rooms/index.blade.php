@extends('layouts.admin')

@section('title', 'Rooms')

@section('content')
    <h1>Available Rooms</h1>

    <a href="{{ route('admin.rooms.create') }}" class="btn btn-success mb-3">Create Room</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Price per Night</th>
                <th>Actions</th>
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
                <td>
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this room?');">
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
