<?php

namespace App\Repositories;

use App\Models\ProfileCompany;
use App\Models\ProfileTeam;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class ProfileTeamRepository extends BaseRepository
{
    public function model()
    {
        return ProfileTeam::class;
    }

    public function findManyBy(
        array $columns = ['*'],
        array $parameters = [],
        array $orderBy = [],
        array $groupBy = [],
        array $specialParameters = []
    ) {
        $query = $this->model->select($columns);

        foreach ($parameters as $key => $value) {
            $query->where($key, $value);
        }

        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findOneByIdPengguna($id)
    {
        return $this->model->where('id_pengguna', $id)->first();
    }

    public function getTeamProfileAndTeamWithIdPengguna($id_pengguna)
    {
        $query = ProfileTeam::select('profile_team.*', 'pengguna.*')
            ->join('pengguna', 'profile_team.id_creative_hub', '=', 'pengguna.id')
            ->where('profile_team.id_creative_hub', $id_pengguna)
            ->get();

        return $query;
    }
}
