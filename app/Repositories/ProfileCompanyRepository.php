<?php

namespace App\Repositories;

use App\Models\ProfileCompany;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class ProfileCompanyRepository extends BaseRepository
{
    public function model()
    {
        return ProfileCompany::class;
    }

    public function findManyBy(
        array $columns = ['*'],
        array $parameters = [],
        array $orderBy = [],
        array $groupBy = [],
        array $specialParameters = []
    ) {
        $query = $this->model->select($columns);

        // Apply where conditions
        foreach ($parameters as $key => $value) {
            $query->where($key, $value);
        }

        // Apply order by conditions
        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        // Apply group by conditions
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findOneById($id)
    {
        return $this->model->where('id_pengguna', $id)->first();
    }
}
