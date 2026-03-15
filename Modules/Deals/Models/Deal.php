<?php

namespace Modules\Deals\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'account_id', 'contact_id', 'assigned_to',
        'stage', 'value', 'currency', 'probability',
        'expected_close_date', 'description', 'created_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(\Modules\Accounts\Models\Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(\Modules\Contacts\Models\Contact::class);
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

    const STAGES = [
        'prospect' => ['label' => 'Prospect', 'probability' => 10, 'color' => 'blue'],
        'proposal' => ['label' => 'Proposal', 'probability' => 25, 'color' => 'purple'],
        'negotiation' => ['label' => 'Negotiation', 'probability' => 50, 'color' => 'orange'],
        'won' => ['label' => 'Won', 'probability' => 100, 'color' => 'green'],
        'lost' => ['label' => 'Lost', 'probability' => 0, 'color' => 'red'],
    ];
}
