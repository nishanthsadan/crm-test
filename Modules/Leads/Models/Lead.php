<?php

namespace Modules\Leads\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'source',
        'status',
        'stage',
        'priority',
        'assigned_to',
        'expected_value',
        'description',
        'created_by',
    ];

    protected $casts = [
        'expected_value' => 'decimal:2',
    ];

    // Relationships
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('assigned_to', $userId)
              ->orWhere('created_by', $userId);
        });
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Constants
    const STATUSES = ['new', 'contacted', 'qualified', 'lost', 'converted'];
    const PRIORITIES = ['low', 'medium', 'high'];
    const SOURCES = ['website', 'referral', 'social_media', 'email', 'phone', 'trade_show', 'other'];
}
