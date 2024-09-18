<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetBuatMilestoneRequest extends FormRequest
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
        ];
    }
}
