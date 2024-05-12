<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class InsertTeamRequest extends FormRequest
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
            'nama_team' => 'required|string',
            'deskripsi' => 'required|string',
            'max_team' => 'required|integer',
            'status_collab' => 'required|boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ];

        throw new ValidationException($validator, response()->json($response, 422));
    }

}
