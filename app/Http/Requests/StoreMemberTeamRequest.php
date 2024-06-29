<?php


namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreMemberTeamRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth([
            'creative-hub-admin',
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
            if (in_array($role['nama_role'], $data)) {
                return true;
            }
        }
        return false;
    }

    public function rules()
    {
        return [
            'id_profile_team' => 'required|integer',
            'nama' => 'required|string|max:50',
            'peran_team' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50'
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
