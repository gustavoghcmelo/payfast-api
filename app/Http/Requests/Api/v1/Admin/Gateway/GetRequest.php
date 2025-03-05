<?php

namespace App\Http\Requests\Api\v1\Admin\Gateway;

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
            'slug' => 'string|nullable',
            'description' => 'string|nullable',
            'limit' => 'integer|nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('slug')) {
            $this->merge(['slug' => '']);
        }

        if (!$this->has('description')) {
            $this->merge(['description' => '']);
        }

        if (!$this->has('limit')) {
            $this->merge(['limit' => 15]);
        }
    }
}
