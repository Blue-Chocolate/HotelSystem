@extends('layouts.admin')

@section('title', 'Create Reservation')

@section('content')
    <h1>Make Reservation for Guest</h1>

    <div class="card p-4">
        <form action="{{ route('admin.reserve.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="user_id">Select Guest</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option disabled selected>Choose a guest</option>
                    @foreach($guests as $guest)
                        <option value="{{ $guest->id }}">{{ $guest->name }} ({{ $guest->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="room_id">Select Room</label>
                <select name="room_id" id="room_id" class="form-control" required>
                    <option disabled selected>Choose a room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">Room {{ $room->room_number }} - {{ $room->type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="check_in">Check-In Date</label>
                <input type="date" name="check_in" id="check_in" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="check_out">Check-Out Date</label>
                <input type="date" name="check_out" id="check_out" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Reservation</button>
        </form>
    </div>
@endsection
