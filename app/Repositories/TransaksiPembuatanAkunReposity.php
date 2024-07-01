<?php

namespace App\Repositories;

use App\Models\TransaksiPembuatanTeam;
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
        return TransaksiPembuatanTeam::class;
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

    /**
     * Get a record by user ID.
     *
     * @param int $userId
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getOneByIdUser(int $userId, array $columns = ['*'])
    {
        return $this->model->select($columns)->where('id_user', $userId)->first();
    }
}
