<?php

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class ClaimValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user('api')->user_type == UserTypes::OWNER || auth()->user('api')->user_type == UserTypes::TENANT;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'property_id' => 'required|int',
            'description' => 'required|string',
            'amount_to_claim' => 'required|string',
            //'evidence' => 'mimes:jpeg,jpg,png,pdf|sometimes|nullable|max:10000',
            'evidence' => 'required',
            'evidence.*' => ['image', 'max:10000'],
        ];
    }
}
