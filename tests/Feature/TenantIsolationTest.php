<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Task;
use App\Models\User;

class TenantIsolationTest extends TestCase
{
        use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_tenant_cannot_see_other_tasks()
{
    $tenantA = Tenant::factory()->create();
    $tenantB = Tenant::factory()->create();

    $taskB = Task::factory()->create(['tenant_id'=>$tenantB->id]);

    $this->withHeader('X-Tenant-ID', $tenantA->subdomain)
        ->actingAs(User::factory()->create(['tenant_id'=>$tenantA->id]))
        ->getJson('/api/tasks')
        ->assertJsonMissingExact([
            'id' => $taskB->id,
            'title' => $taskB->title,
        ]);
}

}