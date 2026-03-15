<?php

namespace Modules\Activities\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type', 'title', 'description', 'due_date', 'due_time',
        'status', 'priority', 'actable_type', 'actable_id',
        'assigned_to', 'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function actable()
    {
        return $this->morphTo();
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('assigned_to', $userId)->orWhere('created_by', $userId);
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getTypeIconAttribute(): string
    {
        $icons = [
            'call' => '📞',
            'meeting' => '👥',
            'task' => '✅',
            'email' => '📧',
        ];
        return $icons[$this->type] ?? '📋';
    }

    const TYPES = ['call', 'meeting', 'task', 'email'];
    const STATUSES = ['pending', 'in_progress', 'completed', 'cancelled'];
    const PRIORITIES = ['low', 'medium', 'high'];
}
