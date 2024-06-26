<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SetProfileAdminRequest extends FormRequest
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
            if(in_array($role['nama_role'],$data)) {
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
            'jumlah_working_space' =>'integer',
            'nama' => 'required|string|max:40',
            'tag_line' => 'required|string|max:40',
            'nomor_telepon' => 'string|max:11',
            'alamat' => 'string|max:50',
            'website' => 'string|max:256',
            'deskripsi' => 'string',
            'visi_misi' => 'string',
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
