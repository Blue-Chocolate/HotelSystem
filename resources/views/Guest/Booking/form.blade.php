@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li> {{-- Allow HTML formatting --}}
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-body border-0 shadow-sm p-4">
        <h2 class="mb-4">Book Room {{ $room->room_number }}</h2>

        <form method="POST" action="{{ route('booking.store', $room) }}" id="bookingForm">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="mb-3">
                <label for="check_in" class="form-label">Check-in Date</label>
                <input
                    type="date"
                    name="check_in"
                    id="check_in"
                    class="form-control"
                    value="{{ old('check_in') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="check_out" class="form-label">Check-out Date</label>
                <input
                    type="date"
                    name="check_out"
                    id="check_out"
                    class="form-control"
                    value="{{ old('check_out') }}"
                    required>
            </div>
            
            <div id="availability-status" class="mb-3" style="display: none;">
                <!-- Availability status will be shown here -->
            </div>

            @if ($errors->has('check_in') || $errors->has('check_out'))
                <div class="alert alert-warning">
                    <strong>Warning!</strong> You can't reserve in past dates. Please choose a valid date range.
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-2">Confirm Booking</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const submitBtn = document.querySelector('button[type="submit"]');
    const form = document.getElementById('bookingForm');
    const availabilityStatus = document.getElementById('availability-status');
    
    const validateDates = async () => {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        let isValid = true;
        let errorMessage = '';

        if (checkIn && checkIn < today) {
            isValid = false;
            errorMessage += '<li>Check-in date cannot be in the past.</li>';
        }

        if (checkOut && checkOut < today) {
            isValid = false;
            errorMessage += '<li>Check-out date cannot be in the past.</li>';
        }

        if (checkIn && checkOut && checkIn >= checkOut) {
            isValid = false;
            errorMessage += '<li>Check-out date must be after check-in date.</li>';
        }

        // Check room availability if dates are valid
        if (isValid && checkIn && checkOut) {
            try {
                const response = await fetch(`/api/rooms/${form.room_id.value}/availability?check_in=${checkIn}&check_out=${checkOut}`);
                const data = await response.json();
                
                if (!data.available) {
                    isValid = false;
                    errorMessage += '<li>Room is not available for the selected dates.</li>';
                    availabilityStatus.innerHTML = '<div class="alert alert-danger">Room is not available for these dates</div>';
                } else {
                    availabilityStatus.innerHTML = '<div class="alert alert-success">Room is available! You can proceed with booking.</div>';
                }
                availabilityStatus.style.display = 'block';
            } catch (error) {
                console.error('Error checking availability:', error);
            }
        } else {
            availabilityStatus.style.display = 'none';
        }

        const alertBox = document.querySelector('.client-date-errors');
        if (!isValid) {
            if (!alertBox) {
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('alert', 'alert-danger', 'client-date-errors');
                errorDiv.innerHTML = `<ul>${errorMessage}</ul>`;
                document.querySelector('.card').prepend(errorDiv);
            } else {
                alertBox.innerHTML = `<ul>${errorMessage}</ul>`;
            }
            submitBtn.disabled = true;
        } else {
            if (alertBox) alertBox.remove();
            submitBtn.disabled = false;
        }
    };

    checkInInput.setAttribute('min', today);
    checkOutInput.setAttribute('min', today);

    checkInInput.addEventListener('change', validateDates);
    checkOutInput.addEventListener('change', validateDates);
    checkInInput.addEventListener('input', validateDates);
    checkOutInput.addEventListener('input', validateDates);

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        await validateDates();
        if (!submitBtn.disabled) {
            form.submit();
        }
    });
});
</script>
@endsection
