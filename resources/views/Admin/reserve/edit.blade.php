@extends('layouts.admin')

@section('title', 'Edit Reservation')

@section('content')
<style>
    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
    }

    .btn-submit {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-right: 1rem;
    }

    .btn-submit:hover {
        background-color: #2c3e50;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-delete:hover {
        background-color: #bd2130;
    }

    @media (prefers-color-scheme: dark) {
        .form-container {
            background-color: rgb(31 41 55);
            color: rgb(243 244 246);
        }

        .page-title, .form-label {
            color: #3498db;
        }

        .form-control {
            background-color: rgb(55 65 81);
            border-color: rgb(75 85 99);
            color: rgb(243 244 246);
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
        }
    }
</style>

<h1 class="page-title">Edit Reservation</h1>

<div class="form-container">
    <form action="{{ route('admin.reserve.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="user_id">Guest</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $reservation->user_id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ $room->id == $reservation->room_id ? 'selected' : '' }}>
                        {{ $room->room_number }} ({{ $room->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="check_in">Check-in</label>
            <input type="date" name="check_in" id="check_in" class="form-control" value="{{ $reservation->check_in->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="check_out">Check-out</label>
            <input type="date" name="check_out" id="check_out" class="form-control" value="{{ $reservation->check_out->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn-submit">Update Reservation</button>
    </form>
    
    <form action="{{ route('admin.reserve.destroy', $reservation->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete Reservation</button>
    </form>
</div>
@endsection
