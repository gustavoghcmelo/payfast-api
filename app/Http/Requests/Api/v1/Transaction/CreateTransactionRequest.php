<?php

namespace App\Http\Requests\Api\v1\Transaction;

use App\Dto\Transaction\CreateTransactionDto;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * @return CreateTransactionDto
     * @throws UnknownProperties
     */
    public function toDTO(): CreateTransactionDto
    {
        return new CreateTransactionDto($this->validated());
    }
}
