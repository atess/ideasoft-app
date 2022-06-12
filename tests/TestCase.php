<?php

namespace Tests;

use Domain\User\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('optimize:clear');
        Artisan::call('passport:install');

        $this->faker = Factory::create();
    }

    public function login(?User $user = null): static
    {
        if (is_null($user)) {
            $user = User::factory()->create();
        }

        Passport::actingAs($user);

        return $this;
    }
}
