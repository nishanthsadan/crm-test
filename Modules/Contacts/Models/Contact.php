<?php

namespace Modules\Contacts\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'mobile',
        'account_id', 'title', 'department', 'source', 'description', 'created_by',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function account()
    {
        return $this->belongsTo(\Modules\Accounts\Models\Account::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('created_by', $userId);
    }
}
