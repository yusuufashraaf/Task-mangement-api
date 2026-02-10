<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $acme = Tenant::where('subdomain', 'acme')->first();
        $globex = Tenant::where('subdomain', 'globex')->first();

        User::create([
            'name' => 'Acme Admin',
            'email' => 'admin@acme.com',
            'password' => Hash::make('password'),
            'tenant_id' => $acme->id,
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Acme Member',
            'email' => 'member@acme.com',
            'password' => Hash::make('password'),
            'tenant_id' => $acme->id,
            'role' => 'member'
        ]);

        User::create([
            'name' => 'Globex Admin',
            'email' => 'admin@globex.com',
            'password' => Hash::make('password'),
            'tenant_id' => $globex->id,
            'role' => 'admin'
        ]);
    }
}