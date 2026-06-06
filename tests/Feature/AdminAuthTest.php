<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\DatabaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Force database service initialization to seed users
        DatabaseService::getConnection();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/backend');
        $response->assertRedirect('/backend/login');
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/backend/login');
        $response->assertStatus(200);
        $response->assertSee('Nomad Thread');
        $response->assertSee('Admin Console Login');
    }

    public function test_invalid_login_credentials_fail(): void
    {
        $response = $this->post('/backend/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_normal_user_cannot_access_admin_panel(): void
    {
        $response = $this->post('/backend/login', [
            'email' => 'sophia@nomad.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/backend/login');
        $response->assertSessionHas('error');
    }

    public function test_admin_can_login_successfully(): void
    {
        $response = $this->post('/backend/login', [
            'email' => 'admin@nomadthread.test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/backend');
        $this->assertAuthenticated();
        
        // Follow redirect to backend and check it loads successfully
        $dashboardResponse = $this->get('/backend');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Admin Panel');
        $dashboardResponse->assertSee('Alex Mercer');
    }

    public function test_admin_can_logout_successfully(): void
    {
        // Log in
        $this->post('/backend/login', [
            'email' => 'admin@nomadthread.test',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        // Logout
        $response = $this->post('/backend/logout');
        $response->assertRedirect('/backend/login');
        $this->assertGuest();
    }
}
