<?php

namespace App\Http\Requests\Kost;

use App\Helpers\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      =>  'required|string',
            'location'  =>  'required|string',
            'price'     =>  'required|numeric|min:1',
        ];
    }

    /**
     * Failed validation response
     * @param   Validator $validator
     * @return  ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = Response::validationResponse('Bad Request', $validator->errors()->toArray());

        throw new ValidationException($validator, $response);
    }
}
