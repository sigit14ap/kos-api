<?php

namespace App\Http\Requests\Auth;

use App\Helpers\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name'      =>  ['required','string'],
            'email'     =>  ['required','email','unique:users,email'],
            'user_type' =>  ['required','string','in:owner,regular,premium'],
            'password'  =>  ['required','confirmed', 
                                Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                            ],
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
