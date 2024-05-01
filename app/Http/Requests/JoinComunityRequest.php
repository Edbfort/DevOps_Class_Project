<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class JoinComunityRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth([
            'Admin',
            'Product Owner',
            'Client',
            'Creative Member'
        ]);
    }

    public function rules()
    {
        return [

        ];
    }
}
