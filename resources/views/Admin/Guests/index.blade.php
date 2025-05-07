@extends('layouts.admin')

@section('title', 'Guests')

@section('content')
    <h1>All Guests</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Reservations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $guest)
                <tr>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->reservations->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
