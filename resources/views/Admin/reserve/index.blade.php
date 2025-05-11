@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')
<style>
    .reservation-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .reservation-table th {
        background-color: #2c3e50;
        color: white;
        padding: 1rem;
        text-align: left;
    }

    .reservation-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .reservation-table tr:last-child td {
        border-bottom: none;
    }

    .reservation-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        padding: 0.5em 1em;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .btn-edit {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.875rem;
        transition: background-color 0.3s;
    }

    .btn-edit:hover {
        background-color: #2c3e50;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: background-color 0.3s;
    }

    .btn-delete:hover {
        background-color: #bd2130;
    }

    .page-title {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }

    @media (prefers-color-scheme: dark) {
        .reservation-table {
            background-color: rgb(31 41 55);
            color: rgb(243 244 246);
        }

        .reservation-table th {
            background-color: #2c3e50;
        }

        .reservation-table tbody tr:hover {
            background-color: rgb(55 65 81);
        }

        .reservation-table td {
            border-bottom-color: rgb(75 85 99);
        }

        .page-title {
            color: #3498db;
        }
    }
</style>

<h1 class="page-title">Reservations</h1>

<div class="table-responsive">
    <table class="reservation-table">
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
                <tr>
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
                        <a href="{{ route('admin.reserve.edit', $reservation->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.reserve.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
