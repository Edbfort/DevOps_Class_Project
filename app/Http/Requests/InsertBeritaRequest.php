<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertBeritaRequest extends FormRequest
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
            'idf' => 'string'
        ];
    }
}
