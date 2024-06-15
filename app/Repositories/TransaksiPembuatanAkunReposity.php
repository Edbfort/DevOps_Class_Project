<?php

namespace App\Repositories;

use App\Models\TransaksiPembuatanAkun;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class TransaksiPembuatanAkunRepository.
 */
class TransaksiPembuatanAkunReposity extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return TransaksiPembuatanAkun::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findManyBy(
        array $columns = ['*'],
        array $parameters = [],
        array $orderBy = [],
        array $groupBy = [],
        array $specialParameters = []
    ) {
        if (empty($columns) || !is_array($columns)) {
            $columns = ['*'];
        }

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
}
