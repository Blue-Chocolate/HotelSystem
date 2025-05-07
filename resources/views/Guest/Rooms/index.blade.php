@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Available Rooms</h2>
    <div class="row">
        @foreach($rooms as $room)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm bg-body">
                @if($room->image_url)
                    <img src="{{ $room->image_url }}" class="card-img-top" alt="Room {{ $room->room_number }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">Room {{ $room->room_number }}</h5>
                    <p>Type: {{ $room->type }}</p>
                    <p>Capacity: {{ $room->capacity }} guests</p>
                    <p>Price: ${{ $room->price_per_night }} / night</p>
                    <a href="{{ route('rooms.show', $room) }}" class="btn btn-primary w-100 mt-3">View Room</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
