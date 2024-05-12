<?php

namespace App\Interactors\Team;

use App\Repositories\DataPribadiRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\Facades\Auth;

class GetTeamInteractor
{
    protected $teamRepository;
    public function __construct
    (
        TeamRepository $teamRepository
    )
    {
        $this->teamRepository = $teamRepository;
    }

    public function getTeam()
    {
        $data = $this->teamRepository->getAllWithTeamOwner();

        return $data;
    }
}
