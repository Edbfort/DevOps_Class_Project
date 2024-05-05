<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use App\Models\Team;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class TeamRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return Team::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithTeamOwner()
    {
        $query = Team::select('team.*','pengguna.username as Pembuat')
            ->join('users','users.id', '=', 'team.pembuat')
            ->join('pengguna', 'pengguna.id_user', '=', 'users.id')
            ->get();

        return $query;
    }
}
