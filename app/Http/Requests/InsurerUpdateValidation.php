<?php

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class InsurerUpdateValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user('api')->user_type !== UserTypes::INSURANCE_ADMIN) {
            return false;
        }
        $insurer = $this->route('insurer');
        return auth()->user('api')->insurer->insurance_id == $insurer->insurance_id && auth()->user('api')->user_type == UserTypes::INSURANCE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
