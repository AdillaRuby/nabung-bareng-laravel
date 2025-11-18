<?php

namespace Tests\Feature;

use App\Models\SavedPayment;
use App\Models\Withdraw;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_individual_balances()
    {
        // Create test data
        SavedPayment::create(['user_name' => 'Kasya', 'amount' => 10000, 'note' => 'Test']);
        SavedPayment::create(['user_name' => 'Casa', 'amount' => 15000, 'note' => 'Test']);
        Withdraw::create(['user_name' => 'Kasya', 'amount' => 5000, 'note' => 'Test']);

        // Login as Kasya (note: validation is case-sensitive, so use 'Kasya' not 'kasya')
        $this->post('/login', ['user_name' => 'Kasya'])
             ->assertRedirect('/dashboard');

        // Visit dashboard
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Rp 5.000'); // Kasya balance: 10000 - 5000
        $response->assertSee('Rp 15.000'); // Casa balance: 15000 - 0
        $response->assertSee('Rp 20.000'); // Total balance: 5000 + 15000
    }

    public function test_dashboard_requires_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_shows_zero_balances_when_no_data()
    {
        // Login as Kasya
        $this->post('/login', ['user_name' => 'Kasya'])
             ->assertRedirect('/dashboard');

        // Visit dashboard
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Rp 0'); // All balances should be zero
    }
}
