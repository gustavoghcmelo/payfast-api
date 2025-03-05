<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;

test('should redirect to dashboard if user verified email', function () {
    $user = User::factory()->create();
    $urlDashaboard = route('dashboard', absolute: false);

    $response = $this->actingAs($user)
        ->post('/email/verification-notification', []);

    $response
        ->assertRedirect($urlDashaboard)
        ->assertStatus(302);
});

test('should redirect to back if user unverified email', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)
        ->post('/email/verification-notification', []);

    $response->assertRedirect()->assertStatus(302);

    $this->assertTrue(Session::has('status'));
});
