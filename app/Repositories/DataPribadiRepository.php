<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class DataPribadiRepository
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
        $query = DataPribadi::select('data_pribadi.*', 'users.nama', 'users.jenis_kelamin', 'users.email')
            ->join('users', 'users.id', '=', 'data_pribadi.id_user')
            ->where('users.id', $id)
            ->first();

        return $query;
    }

    public function findByUserId($idUser)
    {
        return DataPribadi::where('id_user', $idUser)->first();
    }
}
