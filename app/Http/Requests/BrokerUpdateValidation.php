<?php

namespace App\Http\Requests;

use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class BrokerUpdateValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user('api')->user_type !== UserTypes::BROKER_ADMIN) {
            return false;
        }
        $broker = $this->route('broker');

        return auth()->user('api')->broker->real_estate_id == $broker->real_estate_id && auth()->user('api')->user_type == UserTypes::BROKER_ADMIN;
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
