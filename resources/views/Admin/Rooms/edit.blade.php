@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
    <h1>Edit Room Details</h1>

    <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" name="room_number" id="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Room Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $room->type) }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $room->capacity) }}" required>
        </div>

     <div class="mb-3">
    <label for="price_per_night" class="form-label">Price per Night</label>
    <input type="number" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night', $room->price_per_night) }}" required step="0.01">
</div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="url" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $room->image_url) }}">
        </div>

        <div class="mb-3">
            <label for="is_available" class="form-label">Available</label>
            <select name="is_available" id="is_available" class="form-control">
                <option value="1" {{ $room->is_available ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$room->is_available ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
@endsection
