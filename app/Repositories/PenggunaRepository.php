<?php

namespace App\Repositories;

use App\Models\Pengguna;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class PenggunaRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return Pengguna::class;
    }

    public function findByUserId($idUser)
    {
        return Pengguna::where('id_user', $idUser)->first();
    }
}
