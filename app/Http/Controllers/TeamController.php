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

    public function getDaftarTeam()
    {
        $data = $this->getTeamInteractor->getTeam();
        return $data;
    }

    public function insertTeam(InsertTeamRequest $request)
    {
        $data = $this->insertTeamInteractor->insertTeam($request);
        return $data;
    }

    public function joinTeam(JoinTeamRequest $request, $id)
    {
        $data = $this->insertTeamInteractor->joinTeam($id);
        return $data;
    }
}

