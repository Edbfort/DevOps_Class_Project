<?php

namespace App\Http\Controllers;
use App\Http\Requests\InsertTeamRequest;
use App\Http\Requests\JoinTeamRequest;
use App\Interactors\Team\GetTeamInteractor;
use App\Interactors\Team\InsertTeamInteractor;

class TeamController extends Controller
{
    protected $getTeamInteractor;
    protected $insertTeamInteractor;

    public function __construct
    (
        GetTeamInteractor $getTeamInteractor,
        InsertTeamInteractor $insertTeamInteractor
    )
    {
        $this->getTeamInteractor  = $getTeamInteractor;
        $this->insertTeamInteractor = $insertTeamInteractor;
    }

}

