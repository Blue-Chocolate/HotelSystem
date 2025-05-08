@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
    <h1>Welcome to Our Hotel</h1>
    <p>Book your stay with us easily.</p>
    <a href="{{ route('rooms.index') }}">Browse Rooms</a>
@endsection
