<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        return [
            'name' => 'sometimes|required|string|between:2,100',
            'email' => 'sometimes|required|string|email|max:255|unique:workers,email,'. auth()->guard('worker')->id(),
            'password' => 'nullable|string|min:6',
            'phone' => 'sometimes|required|string|max:17',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'location' => 'sometimes|required|string|min:6',
        ];
    }
}
