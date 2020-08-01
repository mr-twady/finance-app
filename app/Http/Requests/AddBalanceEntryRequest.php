<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddBalanceEntryRequest extends FormRequest
{
    
    /*
     * Override the "failedValidation" function
     */
    protected function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->errorResponse($validator->errors()->all(), 'Request Failed Validation', 422)); 
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label'  => 'required|string|max:100',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ];
    }
}
