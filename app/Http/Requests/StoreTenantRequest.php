<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public tenant registration
    }

    public function rules(): array
    {
        return [
            'company_name'   => 'required|string|max:255',
            'subdomain'      => 'required|string|unique:tenants,subdomain',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'subdomain.unique'   => 'This subdomain is already in use.',
            'admin_email.unique' => 'This email is already registered.',
        ];
    }
}