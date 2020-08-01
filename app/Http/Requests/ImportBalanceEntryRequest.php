<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImportBalanceEntryRequest extends FormRequest
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
            'balance_entry_file'  => 'required|file',
        ];
    }
}
