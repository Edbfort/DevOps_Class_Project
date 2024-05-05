<?php

namespace App\Repositories;

use App\Models\DataPribadi;
use App\Models\Team;
use App\Models\TeamJoinRequest;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class TeamJoinRequestRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return TeamJoinRequestRepository::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
