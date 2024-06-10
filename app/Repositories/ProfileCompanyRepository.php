<?php

namespace App\Repositories;

use App\Models\ProfileCompany;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class ProfileCompanyRepository.
 */
class ProfileCompanyRepository extends BaseRepository
{
    /**
     * @return string
     * Return the model
     */
    public function model()
    {
        return ProfileCompany::class;
    }

    /**
     * Find a ProfileCompany by its ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|object|null
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }
}
