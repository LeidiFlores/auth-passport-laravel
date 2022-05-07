<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test Login API
     *
     * @return void
     */
    public function test_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->make();

        $response = $this->actingAs($user, 'api')
            ->json('post', '/api/login', [
                'email' => $user->email,
                'password' => 'password'
            ]);

        $this->assertAuthenticated();

        $response->assertStatus(200);
    }

    /**
     * Test Registro APi
     *
     * @return void
     */
    public function test_signIn()
    {
        $data = [
            "email" => "leidi@bdgtech.uy",
            "password" => "123456789*",
            "password_confirmation" => "123456789*",
            "name" => "Leidi",
            "last_name" => "Flores"
        ];

        $response = $this->post('api/signin', $data);

        $response->assertStatus(200);
    }

    public function logout()
    {
        $data = [
            'email' => 'leidi@bdgtech.uy',
            'password' => '123456789*'
        ];

        $response = $this->post('api/login', $data);


    }
}
