<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVideoRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'path' => 'required|min:3',
            'user_id' => 'integer'
        ];
    }
}
