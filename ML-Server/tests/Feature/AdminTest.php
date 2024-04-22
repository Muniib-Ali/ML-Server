<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_admins_can_access_booking_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admins_can_see_all_users_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/users');


        $response->assertStatus(200);

    }

    public function test_admins_can_see_requests_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/requests');


        $response->assertStatus(200);



    }

    public function test_admins_can_see_all_bookings_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/all-bookings');


        $response->assertStatus(200);



    }


    public function test_admins_can_see_their_bookings_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/list-bookings');


        $response->assertStatus(200);



    }

    public function test_admins_can_see_the_page_to_create_requests()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/credits');


        $response->assertStatus(200);



    }



    public function test_admins_can_see_the_page_to_update_their_details()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/update-account');


        $response->assertStatus(200);



    }



    public function test_admins_cant_access_login_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/login');


        $response->assertStatus(302);


        
    }

    public function test_admins_cant_access_registration_page()
    {

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/signup');


        $response->assertStatus(302);


        
    }

    public function test_admins_cant_access_password_reset_page()
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        $response = $this->get('/password-reset');


        $response->assertStatus(302);


        
    }
   
}
