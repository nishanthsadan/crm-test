<?php

namespace Modules\Leads\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'in:website,referral,social_media,email,phone,trade_show,other'],
            'status' => ['required', 'in:new,contacted,qualified,lost,converted'],
            'priority' => ['required', 'in:low,medium,high'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'expected_value' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
        ];
    }
}
