<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Example: Only authenticated users can make this request
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|exists:user_status,id',
            'role' => 'sometimes|required|exists:user_roles,id',
            'data' => 'nullable|json',
            'created_by' => 'nullable|exists:users,id',
            'invited_by' => 'nullable|exists:users,id',
        ];
    }
}
