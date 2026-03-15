<?php

namespace Modules\Accounts\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'website', 'industry',
        'employees_count', 'annual_revenue', 'address',
        'city', 'state', 'country', 'description', 'created_by',
    ];

    protected $casts = [
        'annual_revenue' => 'decimal:2',
        'employees_count' => 'integer',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contacts()
    {
        return $this->hasMany(\Modules\Contacts\Models\Contact::class);
    }

    public function deals()
    {
        return $this->hasMany(\Modules\Deals\Models\Deal::class);
    }

    public function getLocationAttribute(): string
    {
        return collect([$this->city, $this->state, $this->country])->filter()->implode(', ');
    }

    const INDUSTRIES = [
        'technology', 'finance', 'healthcare', 'retail', 'manufacturing',
        'education', 'real_estate', 'consulting', 'media', 'other'
    ];
}
