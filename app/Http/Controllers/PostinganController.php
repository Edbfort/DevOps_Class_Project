<?php

namespace App\Http\Controllers;

use App\Interactors\Postingan\GetPostinganInteractor;


class PostinganController extends Controller
{
    protected $getPostinganIntetactor;

    public function __construct
    (
        GetPostinganInteractor $getPostinganIntetactor,
    )
    {
        $this->getPostinganIntetactor = $getPostinganIntetactor;
    }

    public function getAllPostinganProject()
    {
        $data = $this->getPostinganIntetactor->getAllPostinganProject();

    return $data;
    }


}

