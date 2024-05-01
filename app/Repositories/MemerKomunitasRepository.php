<?php

namespace App\Repositories;

use App\Models\MemberKomunitas;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class MemerKomunitasRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return MemberKomunitas::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
