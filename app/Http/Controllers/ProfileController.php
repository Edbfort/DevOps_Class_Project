<?php

namespace App\Http\Controllers;

use App\Http\Services\Profile\GetProfileService;
use App\Http\Services\Profile\InsertProfileService;
use App\Http\Requests\SetProfileAdminRequest;
use App\Http\Requests\GetProfileAdminRequest;

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

    public function getProfileAdmin(GetProfileAdminRequest $request, $id)
    {
        return $this->getProfileService->getProfileAdmin($id);
    }

    public function updateProfileAdmin(SetProfileAdminRequest $request, $id)
    {
        return $this->insertProfileService->updateProfileAdmin($request, $id);
    }
}
