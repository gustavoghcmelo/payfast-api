<?php

namespace App\Http\Requests\Api\v1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class GetRequest extends FormRequest
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
            'name' => 'string|nullable',
            'email' => 'string|email|nullable',
            'limit' => 'integer|nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('name')) {
            $this->merge(['name' => '']);
        }

        if (!$this->has('email')) {
            $this->merge(['email' => '']);
        }

        if (!$this->has('limit')) {
            $this->merge(['limit' => 15]);
        }
    }
}
