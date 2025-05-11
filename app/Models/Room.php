<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'type',
        'capacity',
        'price_per_night',
        'image_url',
        'is_available'
    ];

    /**
     * Get the reservations for the room.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check if the room is available for the given date range.
     */
    public function isAvailableForDates($checkIn, $checkOut, $excludeReservationId = null)
    {
        $query = $this->reservations()
            ->where(function ($q) use ($checkIn, $checkOut) {
                // Search for bookings that overlap the given dates
                $q->whereBetween('check_in', [$checkIn, $checkOut])  // The check-in date is between the range
                    ->orWhereBetween('check_out', [$checkIn, $checkOut]) // The check-out date is between the range
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        // If the reservation is in the range
                        $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            });

        // Exclude the current reservation ID if provided (useful for update)
        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        // If no overlapping reservations exist, room is available
        return $query->count() == 0;
    }
}
