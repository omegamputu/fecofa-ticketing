<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    //
    protected $fillable = [
        'ticket_id',
        'commented_by',
        'comment',
        // Add other fields as necessary
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function commenter()
    {
        return $this->belongsTo(User::class, 'commented_by');
    }
}
