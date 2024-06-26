<?php

namespace App\Http\Controllers;

use App\Http\Services\Profile\GetProfileService;
use App\Http\Services\Profile\InsertProfileService;
use App\Http\Requests\SetProfileAdminRequest;
use App\Http\Requests\SetProfileTeamRequest;
use App\Http\Requests\GetProfileRequest;

class ProfileController extends Controller
{
    protected $insertProfileService;
    protected $getProfileService;


    public function __construct
    (
        GetProfileService $getProfileService,
        InsertProfileService $insertProfileService,
    )
    {
        $this->insertProfileService = $insertProfileService;
        $this->getProfileService = $getProfileService;
    }

    public function getProfileAdmin(GetProfileRequest $request, $id)
    {
        return $this->getProfileService->getProfileAdmin($id);
    }

    public function updateProfileAdmin(SetProfileAdminRequest $request, $id)
    {
        return $this->insertProfileService->updateProfileAdmin($request, $id);
    }

    public function getProfileTeam(GetProfileRequest $request, $id)
    {
        return $this->getProfileService->getProfileTeam($request, $id);
    }

    public function updateProfileTeam(SetProfileTeamRequest $request, $id)
    {
        return $this->insertProfileService->updateProfileTeam($request, $id);
    }

    public function getDataProductOwner()
    {
        return $this->getProfileService->getDataProductOwner();
    }

    public function getAllDataProductOwner()
    {
        return $this->getProfileService->getAllDataProductOwner();
    }
}
