<?php

use App\Models\User;

it('can register a new customer', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test' . Str::random(5) . '@example.com',
        'password' => 'password',
        'phone' => '0812345678',
        'role' => 'customer',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['token']);
});

it('can login with valid credentials', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['token']);
});
