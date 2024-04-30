<?php

namespace App\Repositories;

use App\Models\UserRoles;
use Illuminate\Database\Eloquent\Model;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class UserRepository.
 */
class UserRolesRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return UserRoles::class;
    }

    public function findUserRolesByUserId($id)
    {
        $query = UserRoles::select("role_name.nama_role")
            ->join('users', 'users.id', '=', 'user_roles.id_user')
            ->join('role_name', 'role_name.id', '=', 'user_roles.id_role_name' )
            ->where('users.id', $id)
            ->get();

        return $query;
    }
}
