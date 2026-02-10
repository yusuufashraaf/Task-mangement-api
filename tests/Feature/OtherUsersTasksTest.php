<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\Task;
use App\Models\User;

class OtherUsersTasksTest extends TestCase
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
    
public function test_member_cannot_see_other_users_tasks()
{
    $tenant = Tenant::factory()->create();
    app()->instance('tenant', $tenant); 

    $tenant = Tenant::factory()->create();

    $member = User::factory()->create(['tenant_id' => $tenant->id]);

    $otherUser = User::factory()->create(['tenant_id' => $tenant->id]);

    Task::factory()->create([
        'created_by' => $otherUser->id,
        'tenant_id' => $tenant->id
    ]);

    $this->actingAs($member)
        ->getJson('/api/tasks')
        ->assertJsonMissing(['created_by' => $otherUser->id]);
}
}