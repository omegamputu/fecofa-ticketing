<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    //
    protected $fillable = [
        'ticket_id', 
        'file_path', 
        'file_name', 
        'uploaded_by', 
        'size', 
        'disk'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
