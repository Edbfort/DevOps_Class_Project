<?php

namespace App\Interactors\Postingan;

use App\Repositories\PostinganProjectRepository;
use Illuminate\Support\Facades\Auth;

class GetPostinganInteractor
{
    protected $postinganProjectRepository;

    public function __construct
    (
        PostinganProjectRepository $postinganProjectRepository
    )
    {
        $this->postinganProjectRepository = $postinganProjectRepository;
    }

    public function getAllPostinganProject()
    {
        $data = $this->postinganProjectRepository->getAll();
        return $data;
    }
}
