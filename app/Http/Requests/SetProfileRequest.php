<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SetProfileRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama' => 'string|max:30',
            'email' => 'string|max:60',
            'nama_instagram' => 'string|max:30',
            'nama_linkedin' => 'string|max:30',
            'nama_facebook' => 'string|max:30',
            'nama_github' => 'string|max:30',
            'nama_link' => 'string',
            'tanggal_lahir' => 'date_format:Y-m-d H:i:s',
            'tempat_lahir'=> 'required|string|max:30'
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
