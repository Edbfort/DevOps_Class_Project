<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use App\Models\UserRoles;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class DataPribadiRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return DataPribadi::class;
    }

    public function findDataPribadiById($id)
    {
        $query = DataPribadi::select('data_pribadi.*')
        ->join('users', 'users.id', '=', 'data_pribadi.id_user')
        ->where('users.id', $id)
        ->get();

        return $query;
    }

    public function findByUserId($idUser)
    {
        return DataPribadi::where('id_user', $idUser)->first();
    }
}
