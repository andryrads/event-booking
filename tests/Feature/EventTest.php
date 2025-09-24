<?php

use App\Models\User;

it('organizer can create an event', function () {
    $organizer = User::factory()->create(['role' => 'organizer']);
    $token = $organizer->createToken('test')->plainTextToken;

    $response = $this->postJson('/api/events', [
        'title' => 'Sample Event',
        'description' => 'Description',
        'date' => now()->addDays(5)->toDateTimeString(),
        'location' => 'Bandung',
    ], [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment(['title' => 'Sample Event']);
});
