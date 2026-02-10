<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant; 
class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run()
    {
        Tenant::create([
            'company_name' => 'Acme Corp',
            'subdomain' => 'acme'
        ]);

        Tenant::create([
            'company_name' => 'Globex Inc',
            'subdomain' => 'globex'
        ]);
    }
}