<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status_id', 'deadline', 'created_at', 'updated_at'];

    // Define the relationship between Ticket and Status
    public function status()
    {
        return $this->belongsTo(Status::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // In App\Models\Ticket.php

public function assignedUsers()
{
    return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id');
}

}
