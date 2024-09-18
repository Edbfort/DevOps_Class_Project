<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertPostinganRequest;
use App\Interactors\DesinBref\Des;
use Illuminate\Http\Request;


class DesignBreifController extends Controller
{
    public function __construct
    (
    )
    {

    }


    public function insertFileDesignBreif(Request $request)
    {
        return 'halo';
    }
}

