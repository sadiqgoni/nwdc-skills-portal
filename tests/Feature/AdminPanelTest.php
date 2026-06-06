<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_core_filament_pages(): void
    {
        $this->seed();

        $admin = User::query()->where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/applications')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/application-notifications')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk();

        $this->actingAs($admin)
            ->get('/admin/applications?state=KAN')
            ->assertOk();
    }
}
