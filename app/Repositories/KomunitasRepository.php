<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use App\Models\Komunitas;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class KomunitasRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return Komunitas::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithKomunitasOwner()
    {
        $query = Komunitas::select('komunitas.*','pengguna.username as Pembuat')
            ->join('users','users.id', '=', 'komunitas.pembuat')
            ->join('pengguna', 'pengguna.id_user', '=', 'users.id')
            ->get();

        return $query;
    }
}
