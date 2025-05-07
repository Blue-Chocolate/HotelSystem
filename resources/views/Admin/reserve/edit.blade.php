@extends('layouts.admin')

@section('title', 'Edit Reservation')

@section('content')
    <h1>Edit Reservation</h1>

    <form action="{{ route('admin.reserve.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">Guest</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $reservation->user_id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $room->id == $reservation->room_id ? 'selected' : '' }}>
                        {{ $room->room_number }} ({{ $room->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="check_in">Check-in</label>
            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ $reservation->check_in->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="check_out">Check-out</label>
            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ $reservation->check_out->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Reservation</button>
        </div>
    </form>
    
    <form action="{{ route('admin.reserve.destroy', $reservation->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Reservation</button>
    </form>
@endsection
