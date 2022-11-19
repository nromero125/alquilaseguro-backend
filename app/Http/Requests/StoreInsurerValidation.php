<?php

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class StoreInsurerValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user('api')->user_type == UserTypes::INSURER_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone_number' => 'required',
            'identification' => 'required',
            'password' => 'required|string|min:6',
        ];
    }
}
