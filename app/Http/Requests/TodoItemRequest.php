<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title'       => ['required', 'max:255'],
            'description' => ['nullable', 'max:1000']
        ];

        if ($this->isMethod('POST')) {
            $rules['created_by'] = ['required'];
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->isMethod('POST')) {
            $this->merge([
                'created_by' => auth()->id(),
            ]);
        }
    }
}
