<?php

namespace App\Repositories;

use App\Models\Project;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class ProjectRepostory.
 */
class ProjectRepositroy extends BaseRepository
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
