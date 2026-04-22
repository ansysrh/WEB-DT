<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_redirects_to_admin_hubungin(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/admin/hubungin');
    }
}
