<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_page_is_not_available(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
}
