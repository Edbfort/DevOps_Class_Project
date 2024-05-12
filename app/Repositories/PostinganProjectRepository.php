<?php

namespace App\Repositories;

use App\Models\PostinganProject;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class PostinganProjectRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return PostinganProject::class;
    }

    public function getAll()
    {
        return $this->model->with('idProject')->with('idPengguna')->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
}
