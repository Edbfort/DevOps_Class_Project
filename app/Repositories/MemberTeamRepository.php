<?php

namespace App\Repositories;

use App\Models\MemberTeam;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class MemberTeamRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return MemberTeam::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
