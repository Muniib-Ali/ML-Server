<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_users_can_see_the_page_to_update_their_details()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/update-account');


        $response->assertStatus(200);


        
    }

    public function test_users_can_see_the_page_to_create_bookings()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/');


        $response->assertStatus(200);


        
    }

    public function test_users_can_see_their_bookings_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/list-bookings');


        $response->assertStatus(200);



    }

    public function test_users_can_see_the_page_to_create_requests()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/credits');


        $response->assertStatus(200);



    }

    public function test_users_cant_access_login_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/login');


        $response->assertStatus(302);


        
    }

    public function test_users_cant_access_registration_page()
    {

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/signup');


        $response->assertStatus(302);


        
    }

    public function test_users_cant_access_password_reset_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/password-reset');


        $response->assertStatus(302);


        
    }

    public function test_users_cant_see_all_users_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/users');


        $response->assertStatus(302);



    }

    public function test_users_cant_see_requests_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/requests');


        $response->assertStatus(302);



    }

    public function test_users_cant_see_all_bookings_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/all-bookings');


        $response->assertStatus(302);



    }
    
}
