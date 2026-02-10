<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@acme.com')->first();
        $member = User::where('email', 'member@acme.com')->first();

        Task::create([
            'title' => 'Finish report',
            'description' => 'Quarterly report',
            'tenant_id' => $admin->tenant_id,
            'created_by' => $admin->id,
            'assigned_to' => $member->id,
            'status' => 'pending'
        ]);
    }
}