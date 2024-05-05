<?php

namespace App\Repositories;

use App\Models\Project;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class BeritaRepository.
 */
class ProjectRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return Project::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }

}
