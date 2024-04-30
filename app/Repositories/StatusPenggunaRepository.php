<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use App\Models\Pengguna;
use App\Models\StatusPengguna;
use App\Models\UserRoles;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class StatusPenggunaRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return StatusPenggunaRepository::class;
    }
}
