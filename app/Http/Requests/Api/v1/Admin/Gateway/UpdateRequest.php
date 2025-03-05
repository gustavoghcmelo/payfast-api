<?php

namespace App\Http\Requests\Api\v1\Admin\Gateway;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
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
            'slug' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Prepara os dados para validação.
     */
    protected function prepareForValidation(): void
    {
        $this->replace(
            array_filter($this->all(), function ($value, $key) {
                return !empty($value) || $value === 0 || $value === false;
            }, ARRAY_FILTER_USE_BOTH)
        );

        if ($this->has('slug')) {
            $this->merge(['slug' => Str::slug($this->get('slug'))]);
        }
    }
}
