<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InsertBuatMilestoneRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth([
            'controller',
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
            if (in_array($role['nama'], $data)) {
                return true;
            }
        }
        return false;
    }

    public function rules()
    {
        return [
            'id_proyek' => 'required|int',
            'topik' => 'required|string',
            'deskripsi' => 'required|string',
            'tautan' => 'required|string',
            'persentase' => 'required|int',
            'tanggal_tegat' => 'required|date',
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
