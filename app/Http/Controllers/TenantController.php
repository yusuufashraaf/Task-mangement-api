<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'subdomain' => 'required|string|unique:tenants,subdomain',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => [
                'required',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        DB::transaction(function () use ($request, &$tenant) {

            $tenant = Tenant::create($request->only('company_name','subdomain'));

            User::create([
                'name' => 'Admin',
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'tenant_id' => $tenant->id,
                'role' => 'admin'
            ]);
        });

        return response()->json($tenant, 201);
    }
}