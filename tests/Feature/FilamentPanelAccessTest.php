<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk();
    }

    public function test_operator_can_access_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'operator',
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertOk();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')
            ->assertRedirect('/admin/login');
    }

    public function test_user_with_invalid_role_is_forbidden(): void
    {
        $user = User::factory()->create([
            'role' => 'invalid',
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }
}