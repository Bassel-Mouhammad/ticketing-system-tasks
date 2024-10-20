<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;



class TicketSeeder extends Seeder
{
    public function run()
    {
        // First, create 20 users
        $users = User::factory()->count(20)->create();
        // Then, create 10 tickets
        Ticket::factory()->count(10)->create()->each(function ($ticket) {
            // Assign 2 to 5 random users to each ticket as "assignedUsers"
            $assignedUsers = User::inRandomOrder()->take(rand(2, 5))->pluck('id');
            $ticket->assignedUsers()->sync($assignedUsers);
        });
    }
}
