<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(2),
            'status_id' => Status::inRandomOrder()->first()->id, // Randomly assign a status
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'user_id' => User::inRandomOrder()->first()->id, // Assign random user as creator
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
