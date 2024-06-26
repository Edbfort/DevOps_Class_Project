<?php

namespace App\Http\Requests;

use App\Repositories\UserRolesRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ActivationUserTeamRequest extends FormRequest
{
    public function authorize()
    {
        return $this->checkAuth(['creative-hub-team']);
    }

    private function checkAuth(array $roles)
    {
        $userId = Auth::id();
        if (!$userId) {
            return false;
        }

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findUserRolesByUserId($userId);

        foreach ($userRoles as $role) {
            if (in_array($role['nama_role'], $roles)) {
                return true;
            }
        }

        return false;
    }

    public function rules()
    {
        return [
            'password' => 'required|string',
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
