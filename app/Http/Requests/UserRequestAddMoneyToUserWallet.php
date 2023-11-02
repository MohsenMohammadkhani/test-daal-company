<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequestAddMoneyToUserWallet extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric|min:0|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'user_id is not exist on body request',
            'user_id.numeric' => 'user id is invalid',
            'amount.required' => 'amount is not exist on body request',
            'amount.numeric' => 'amount id is invalid',
            'amount.min' => 'amount id is slower than 0',
            'amount.not_in' => 'amount id is slower than 0',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(
            [
                'success' => false,
                'message' => $validator->errors(),
            ]
            , 422,  [
            "Content-Type" => "application/json"
        ]));
    }

}
