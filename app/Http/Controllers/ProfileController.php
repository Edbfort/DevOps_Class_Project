<?php

namespace App\Http\Controllers;

use App\Http\Services\Profile\InsertProfileService;
use App\Http\Requests\SetProfileAdminRequest;

class ProfileController extends Controller
{
    protected $insertProfileService;

    public function __construct(InsertProfileService $insertProfileService)
    {
        $this->insertProfileService = $insertProfileService;
    }

    public function updateProfileAdmin(SetProfileAdminRequest $request, $id)
    {
        return $this->insertProfileService->updateProfileAdmin($request, $id);
    }
}
