<?php

namespace Tests\Unit\User;

use Domain\User\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    protected array $structure = [
        "id",
        "name",
        "email",
    ];

    public function test_login()
    {
        User::factory()
            ->create([
                'password' => bcrypt('1234567*Aa'),
                'email' => 'test@test.com'
            ]);

        $this
            ->postJson(route('auth.login'), [
                'email' => 'test@test.com',
                'password' => '1234567*Aa',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user' => $this->structure,
                    'token',
                ],
            ]);
    }

    public function test_register()
    {
        $pass = Str::random() . '}aA';
        $user = User::factory()->raw([
            'password' => $pass,
            'password_confirmation' => $pass,
        ]);

        $this
            ->postJson(route('auth.register'), $user)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'user' => $this->structure,
                    'token',
                ],
            ]);
    }

    public function test_logout()
    {
        $this
            ->login()
            ->deleteJson(
                route('auth.logout')
            )
            ->assertStatus(204);
    }
}
