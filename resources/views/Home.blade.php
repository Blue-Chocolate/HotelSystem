@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
    <h1>Welcome to Our Motel</h1>
    <p>Book your stay with us easily.</p>
    <a href="{{ route('guest.rooms.index') }}">Browse Rooms</a>
@endsection
