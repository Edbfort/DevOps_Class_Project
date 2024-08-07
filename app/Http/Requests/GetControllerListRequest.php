<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetControllerListRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth([
            'client'
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
            'keyword' => 'string|nullable',
            'fee' => 'nullable',
            'spesialisasi' => 'nullable'
        ];
    }
}
