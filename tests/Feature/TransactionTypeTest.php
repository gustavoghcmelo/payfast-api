<?php

use App\Models\TransactionType;

test('can list all transaction types from db', function () {
    TransactionType::factory()->count(3)->create();
    $response = $this->getJson('/api/v1/transaction-type');

    assertApiResponseSuccess($response);
});

test('can list only 3 transaction types from db', function () {
    TransactionType::factory()->count(10)->create();
    $response = $this->getJson('/api/v1/transaction-type?limit=3');

    $data = $response->getData(true)['data'][0]['data'];
    expect(count($data))->toBe(3);
});

test('when create a new transaction type should return 201 status', function () {
    $response = $this->post('/api/v1/transaction-type', [
        'description' => 'boleto',
    ]);

    $response->assertStatus(201);
});

test('when create a new transaction_type should return ApiResponse::success structure', function () {
    $response = $this->post('/api/v1/transaction-type', [
        'description' => 'pix',
    ]);

    assertApiResponseSuccess($response, 201);
});

test('on create should throw ValidationException if not description field exist', function () {
    $response = $this->post('/api/v1/transaction-type', []);

    $response->assertJsonValidationErrors(['description' => 'The description field is required.']);
});

test('on field description ValidationError should return ApiResponse::error structure and status 400', function () {
    $response = $this->post('/api/v1/transaction-type', []);

    assertApiResponseError($response);
});

test('when update a transaction_type should return ApiResponse::success structure and status 200', function () {
    $transaction_type = TransactionType::factory()->create();

    $response = $this->put("/api/v1/transaction-type/$transaction_type->id", [
        'description' => 'credit-card',
    ]);

    $transaction_type->refresh();
    expect($transaction_type->description)->toBe('credit-card');
    assertApiResponseSuccess($response);
});

test('on update should throw ValidationException if not description field exist', function () {
    $transaction_type = TransactionType::factory()->create();
    $response = $this->put("/api/v1/transaction-type/$transaction_type->id", []);

    $response->assertJsonValidationErrors(['description' => 'The description field is required.']);
});

test('on delete a transaction_type should return ApiResponse::success structure and status 200 ', function () {
    $transaction_type = TransactionType::factory()->create();
    $response = $this->delete("/api/v1/transaction-type/$transaction_type->id");

    $transaction_type->refresh();
    expect($transaction_type->deleted_at)->not()->toBeNull();
    assertApiResponseSuccess($response);
});
