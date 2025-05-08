<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;
    
    /**
     * @var int
     */
    protected static $roomNumberSequence = 100;

    protected $roomImages = [
        'https://images.unsplash.com/photo-1631049307264-da0ec9d70304',
        'https://images.unsplash.com/photo-1618773928121-c32242e63f39',
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a',
        'https://images.unsplash.com/photo-1590490360182-c33d57733427',
        'https://images.unsplash.com/photo-1595576508898-0ad5c879a061'
    ];

    public function definition(): array
    {
        return [
            'room_number' => static::$roomNumberSequence++,
            'type' => $this->faker->randomElement(['Single', 'Double', 'Suite']),
            'capacity' => $this->faker->numberBetween(1, 4),
            'price_per_night' => $this->faker->randomFloat(2, 50, 300),
            'image_url' => $this->faker->randomElement($this->roomImages) . '?auto=format&fit=crop&w=400&h=300&q=80',
            'is_available' => $this->faker->boolean(80),
        ];
    }
}
