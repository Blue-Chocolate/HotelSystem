@extends('layouts.admin')

@section('title', 'Create Room')

@section('content')
    <h1>Create Room</h1>

    <form method="POST" action="{{ route('admin.rooms.store') }}">
        @csrf

        <div class="mb-3">
            <label for="room_number" class="form-label">Room Number</label>
            <input type="text" name="room_number" id="room_number" class="form-control" value="{{ old('room_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Room Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}" required>
        </div>

        <div class="mb-3">
            <label for="price_per_night" class="form-label">Price per Night</label>
            <input type="number" name="price_per_night" id="price_per_night" class="form-control" value="{{ old('price_per_night') }}" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="url" name="image_url" id="image_url" class="form-control" value="{{ old('image_url') }}">
        </div>

        <div class="mb-3">
            <label for="is_available" class="form-label">Available</label>
            <select name="is_available" id="is_available" class="form-control">
                <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create Room</button>
    </form>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in').setAttribute('min', today);
            document.getElementById('check_out').setAttribute('min', today);
        });
    </script>