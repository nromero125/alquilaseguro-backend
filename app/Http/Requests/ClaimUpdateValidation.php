<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimUpdateValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $claim = $this->route('claim');

        return auth()->user('api')->insurer->insurance_id == $claim->insurance_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'property_id' => 'required|int',
            'description' => 'required|string',
            //'amount_to_claim' => 'required|string',
            //'evidence' => 'mimes:jpeg,jpg,png,pdf|sometimes|nullable|max:10000',
        ];
    }
}
