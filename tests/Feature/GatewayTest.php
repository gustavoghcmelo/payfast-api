<?php

use App\Models\Gateway;

test('can list all gateways from db', function () {
    Gateway::factory()->count(3)->create();
    $response = $this->getJson('/api/v1/gateway');

    assertApiResponseSuccess($response);
});

test('can list only 3 gateways from db', function () {
    Gateway::factory()->count(10)->create();
    $response = $this->getJson('/api/v1/gateway?limit=3');

    $data = $response->getData(true)['data'][0]['data'];
    expect(count($data))->toBe(3);
});

test('when create a new gateway should return 201 status', function () {
    $response = $this->post('/api/v1/gateway', [
        'slug' => 'bradesco',
        'description' => 'novo gateway',
    ]);

    $response->assertStatus(201);
});

test('when create a new gateway should return ApiResponse::success structure', function () {
    $response = $this->post('/api/v1/gateway', [
        'slug' => 'bradesco',
        'description' => 'novo gateway',
    ]);

    assertApiResponseSuccess($response, 201);
});

test('on create should throw ValidationException if not slug field exist', function () {
    $response = $this->post('/api/v1/gateway', [
        'description' => 'novo gateway',
    ]);

    $response->assertJsonValidationErrors(['slug' => 'The slug field is required.']);
});

test('on field slug ValidationError should return ApiResponse::error structure and status 400', function () {
    $response = $this->post('/api/v1/gateway', [
        'description' => 'novo gateway',
    ]);

    assertApiResponseError($response);
});

test('on create should throw ValidationException if not description field exist', function () {
    $response = $this->post('/api/v1/gateway', [
        'slug' => 'bradesco',
    ]);

    $response->assertJsonValidationErrors(['description' => 'The description field is required.']);
});

test('on field description ValidationError should return ApiResponse::error structure and status 400', function () {
    $response = $this->post('/api/v1/gateway', [
        'slug' => 'bradesco',
    ]);

    assertApiResponseError($response);
});

test('when update a gateway should return ApiResponse::success structure and status 200', function () {
    $gateway = Gateway::factory()->create();

    $response = $this->put("/api/v1/gateway/$gateway->id", [
        'slug' => 'bradesco',
        'description' => 'novo gateway',
    ]);

    $gateway->refresh();
    expect($gateway->slug)->toBe('bradesco');
    assertApiResponseSuccess($response);
});

test('on update should not throw ValidationException if not slug field exist', function () {
    $gateway = Gateway::factory()->create();

    $response = $this->put("/api/v1/gateway/$gateway->id", [
        'description' => 'novo gateway',
    ]);
    assertApiResponseSuccess($response);
});

test('on update should not throw ValidationException if not description field exist', function () {
    $gateway = Gateway::factory()->create();

    $response = $this->put("/api/v1/gateway/$gateway->id", [
        'slug' => 'bradesco',
    ]);
    assertApiResponseSuccess($response);
});

test('on delete a gateway should return ApiResponse::success structure and status 200 ', function () {
    $gateway = Gateway::factory()->create();
    $response = $this->delete("/api/v1/gateway/$gateway->id");

    assertApiResponseSuccess($response);
});

test('after delete the deleted_at column not be null', function () {
    $gateway = Gateway::factory()->create();
    $this->delete("/api/v1/gateway/$gateway->id");

    $gateway->refresh();
    expect($gateway->deleted_at)->not()->toBeNull();
});





