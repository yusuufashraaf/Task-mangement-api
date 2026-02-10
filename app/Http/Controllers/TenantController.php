<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTenantRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
public function store(StoreTenantRequest $request)
{
    try {
        $tenant = DB::transaction(function () use ($request) {

            $tenant = Tenant::create($request->only('company_name', 'subdomain'));

            User::create([
                'name'      => 'Admin',
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'tenant_id' => $tenant->id,
                'role'      => 'admin',
            ]);

            return $tenant;
        });

        return response()->json($tenant, 201);

    } catch (QueryException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Subdomain or email already exists',
        ], 409);
    }
}
}