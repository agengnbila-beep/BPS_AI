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

    public function test_operator_cannot_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'operator',
        ]);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_admin_can_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_operator_cannot_access_create_user_page(): void
    {
        $user = User::factory()->create([
            'role' => 'operator',
        ]);

        $this->actingAs($user)
            ->get('/admin/users/create')
            ->assertForbidden();
    }

    public function test_operator_cannot_access_edit_user_page(): void
    {
        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $targetUser = User::factory()->create([
            'role' => 'operator',
        ]);

        $this->actingAs($operator)
            ->get("/admin/users/{$targetUser->id}/edit")
            ->assertForbidden();
    }


    public function test_last_admin_is_detected(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isLastAdmin());
    }

    public function test_admin_is_not_last_when_another_admin_exists(): void
    {
        $firstAdmin = User::factory()->create([
            'role' => 'admin',
        ]);

        User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertFalse($firstAdmin->isLastAdmin());
        $this->assertTrue($firstAdmin->hasOtherAdmin());
    }

}
