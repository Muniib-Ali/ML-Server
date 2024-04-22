<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guests_can_access_login_page()
    {

        $response = $this->get('/login');


        $response->assertStatus(200);


        
    }

    public function test_guests_can_access_registration_page()
    {

        $response = $this->get('/signup');


        $response->assertStatus(200);


        
    }

    public function test_guests_can_access_password_reset_page()
    {

        $response = $this->get('/password-reset');


        $response->assertStatus(200);


        
    }

    public function test_guests_cant_see_the_page_to_update_details()
    {
    
        $response = $this->get('/update-account');
        $response->assertStatus(302);


        
    }

    public function test_guests_cant_see_the_page_to_create_bookings()
    {

        $response = $this->get('/');


        $response->assertStatus(302);


        
    }

    public function test_guests_cant_see_the_bookings_page()
    {

        $response = $this->get('/list-bookings');


        $response->assertStatus(302);



    }

    public function test_guests_cant_see_the_page_to_create_requests()
    {


        $response = $this->get('/credits');


        $response->assertStatus(302);



    }

    
    
}