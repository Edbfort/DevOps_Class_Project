<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InsertProyekRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth(['client']);
    }

    protected function checkAuth(array $roles)
    {
        $userId = Auth::id();
        if (!$userId) {
            return false;
        }

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findUserRolesByUserId($userId);

        foreach ($userRoles as $role) {
            if (in_array($role['nama'], $roles)) {
                return true;
            }
        }

        return false;
    }

    public function rules()
    {
        return [
            'judul_proyek' => 'required|string|max:128',
            'deskripsi_proyek' => 'required|string',
            'spesialisasi' => 'required',
            'anggaran' => 'required|integer',
            'tanggal_tegat' => 'required|date',
            'file_dokumen' => 'nullable|max:5000|mimes:jpeg,jpg,png,doc,docx,pdf,xls,xlsx'
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
