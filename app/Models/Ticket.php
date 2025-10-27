<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
        'subject',
        'description',
        'status',
        'priority',
        'category_id',
        'assigned_to',
        'created_by',
        'resolved_at',
        'resolved_by',
        'resolution_note',
        'closed_at',
        // Add other fields as necessary
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function scopeFromRequesters($q)
    {
        return $q->whereHas('requester', fn($qq) => $qq->role('Demandeur'));
    }

    public function scopeUnassigned($q) { return $q->whereNull('assigned_to')->whereIn('status', ['open', 'in_progress']);}
    public function scopeAssigned($q) { return $q->whereNotNull('assigned_to')->whereIn('status', ['open', 'in_progress']);}
    public function scopeResolved($q)  { return $q->where('status', 'resolved'); }
    public function scopeClosed($q)  { return $q->where('status', 'closed'); }
    public function scopeAssignedTo($q, $uid) { return $q->where('assigned_to', $uid); }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function getResolvedInfoAttribute(): ?string
    {
        if (! $this->resolved_at) {
            return null;
        }

        $relative = $this->resolved_at->diffForHumans(); // ex: "il y a 2 minutes"
        $exact    = $this->resolved_at->format('d/m/Y H:i'); // ex: "30/09/2025 14:23"

        $by = $this->resolver?->name ?? '—';

        return "Résolu $relative (le $exact) par $by";
    }

}
