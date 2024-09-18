<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPostinganRequest;
use App\Interactors\Postingan\GetPostinganInteractor;
use App\Interactors\Postingan\InsertPostinganInteractor;

class PostinganController extends Controller
{
    protected $getPostinganIntetactor;
    protected $insertPostinganInteractor;

    public function __construct
    (
        GetPostinganInteractor $getPostinganIntetactor,
        InsertPostinganInteractor $insertPostinganInteractor,
    )
    {
        $this->getPostinganIntetactor = $getPostinganIntetactor;
        $this->insertPostinganInteractor = $insertPostinganInteractor;
    }

    public function getAllPostinganProject()
    {
        $data = $this->getPostinganIntetactor->getAllPostinganProject();

        return $data;
    }

    public function insertPostinganProject(InsertPostinganRequest $request)
    {
        $data = $this->insertPostinganInteractor->insertPostinganProject($request);

        return $data;
    }


}

