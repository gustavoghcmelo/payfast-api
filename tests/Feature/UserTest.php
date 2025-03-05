<?php

use App\Helpers\ApiResponse;
use App\Models\User;

test('can list all users from db', function () {
    User::factory()->count(3)->create();
    $response = $this->getJson('/api/v1/user');

    assertApiResponseSuccess($response);
});

test('can list only 3 users from db', function () {
    User::factory()->count(10)->create();
    $response = $this->getJson('/api/v1/user?limit=3');

    $data = $response->getData(true)['data'][0]['data'];
    expect(count($data))->toBe(3);
});

test('on update should return ApiResponse::success structure and status 200', function () {
    $user = User::factory()->create();

    $response = $this->put("/api/v1/user/$user->id", [
        'name' => 'Cecília Bezerra'
    ]);

    $user->refresh();
    expect($user->name)->toBe('Cecília Bezerra');
    assertApiResponseSuccess($response);
});

test('on update a user should throw ValidationException if name field not exist', function () {
    $user = User::factory()->create();
    $response = $this->put("/api/v1/user/$user->id", []);

    $response->assertJsonValidationErrors(['name' => 'The name field is required.']);
});

test('on throw ValidationException field name field should return ApiResponse::error structure', function () {
    $user = User::factory()->create();
    $response = $this->put("/api/v1/user/$user->id", []);

    assertApiResponseError($response);
});

test('on delete should return ApiResponse::success structure and status 200', function () {
    $user = User::factory()->create();
    $response = $this->delete("/api/v1/user/$user->id");

    assertApiResponseSuccess($response);
});

test('after delete the deleted_at column not be null', function () {
    $user = User::factory()->create();
    $this->delete("/api/v1/user/$user->id");

    $user->refresh();
    expect($user->deleted_at)->not()->toBeNull();
});
