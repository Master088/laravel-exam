<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function admin_can_create_user()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    /** @test */
    public function admin_can_update_user()
    {
        $this->actingAs($this->admin);
        $user = User::factory()->create();

        $response = $this->put("/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'user',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $this->actingAs($this->admin);
        $user = User::factory()->create();

        $response = $this->delete("/users/{$user->id}");
        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function non_admin_cannot_access_users_routes()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get('/users');
        $response->assertStatus(403);
    }
}
