<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|',
            'last_name' => 'required|string|',
            'email'=>'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed|'
        ];
    }
}
