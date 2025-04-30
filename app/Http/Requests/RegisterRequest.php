<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'required|between:3,30',
            "email" => 'required|email|unique:users,email',
            "mobile" => 'required|unique:users,mobile',
            "password" => 'required|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المستخدم إجباري',
            'name.between' => 'من 3 إلى 30 حرف',
        ];
    }
}
