<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateOrUpdateBillingRekeningRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth([
            'creative-hub-team',
            'controller'
        ]);
    }

    public function checkAuth($data)
    {
        $userId = Auth::id();
        if (!$userId) {
            return false;
        }
        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findUserRolesByUserId($userId);
        $tes = [];

        foreach ($userRoles as $role) {
            if(in_array($role['nama'],$data)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_bank' => 'required|int',
            'nomor_rekening' => 'required|string',
            'nama_pemilik' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ];

        throw new ValidationException($validator, response()->json($response, 422));
    }
}
