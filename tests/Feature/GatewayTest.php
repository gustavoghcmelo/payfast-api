<?php

use App\Exceptions\GatewayNotFoundException;
use App\Models\Gateway;

test('can list all gateways from db', function () {
    Gateway::factory()->count(3)->create();
    $response = $this->getJson('/api/v1/gateway');

    assertApiResponseSuccess($response);
});

test('should can filter by slug', function () {
    Gateway::create(['slug' => 'teste-slug', 'description' => 'gateway para teste']);
    $response = $this->getJson('/api/v1/gateway?slug=teste-slug');

    $data = $response->getData(true)['data'][0]['data'];

    expect(count($data))->toBe(1);
    expect($data[0]['slug'])->toEqual('teste-slug');
});

test('should can filter by description', function () {
    Gateway::create(['slug' => 'teste-slug', 'description' => 'testando']);
    $response = $this->getJson('/api/v1/gateway?description=testando');

    $data = $response->getData(true)['data'][0]['data'];

    expect(count($data))->toBe(1);
    expect($data[0]['description'])->toEqual('testando');
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

test('on update should not throw GatewayNotFoundException if not found record', function () {
    $gateway = Gateway::factory()->deleted()->create();

    $response = $this->putJson("/api/v1/gateway/$gateway->id", [
        'slug' => 'bradesco',
    ]);

    $data = $response->getData();
    expect($data->code)->toBe(404);
    expect($data->message)->toEqual("Gateway ID: 1 não foi encontrado.");
});

test('on delete a gateway should return ApiResponse::success structure and status 200 ', function () {
    $gateway = Gateway::factory()->create();
    $response = $this->delete("/api/v1/gateway/$gateway->id");

    assertApiResponseSuccess($response);
});

test('on delete should not throw GatewayNotFoundException if not found record', function () {
    $gateway = Gateway::factory()->deleted()->create();

    $response = $this->deleteJson("/api/v1/gateway/$gateway->id", [
        'slug' => 'bradesco',
    ]);

    $data = $response->getData();
    expect($data->code)->toBe(404);
    expect($data->message)->toEqual("Gateway ID: 1 não foi encontrado.");
});

test('after delete the deleted_at column not be null', function () {
    $gateway = Gateway::factory()->create();
    $this->delete("/api/v1/gateway/$gateway->id");

    $gateway->refresh();
    expect($gateway->deleted_at)->not()->toBeNull();
});





