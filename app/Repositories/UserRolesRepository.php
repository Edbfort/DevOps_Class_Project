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

    public function findOneUserRolesAndNameByUserId($id)
    {
        $query = UserRoles::select('role.nama as nama_role','users.nama','users.id')
            ->join('users', 'users.id', '=', 'user_roles.id_user')
            ->join('role', 'role.id', '=', 'user_roles.id_role' )
            ->where('users.id', $id)
            ->first();

        return $query;
    }

    public function findUserRolesByUserId($id)
    {
        $query = UserRoles::select('role.nama')
            ->join('users', 'users.id', '=', 'user_roles.id_user')
            ->join('role', 'role.id', '=', 'user_roles.id_role' )
            ->where('users.id', $id)
            ->get();

        return $query;
    }
}
