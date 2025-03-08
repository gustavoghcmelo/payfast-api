<?php

namespace App\Http\Requests\Api\v1\Admin\Gateway;

use Illuminate\Foundation\Http\FormRequest;

class RemoveTransactionTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_type_id' => 'required|integer|exists:transaction_type,id',
        ];
    }
}
