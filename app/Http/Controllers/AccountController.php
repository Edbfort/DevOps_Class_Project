<?php

namespace App\Http\Controllers;


use App\Http\Requests\ActivationUserTeamRequest;
use App\Http\Requests\GetAccountTeamRequest;
use App\Http\Requests\InsertTeamRequest;
use App\Http\Services\Controller\GetAccountService;
use App\Http\Services\CreativeHubAdmin\InsertTeamService;

class AccountController extends Controller
{
    protected $getAccountService;
    protected $insertAccountService;
    public function __construct
    (
        InsertTeamService $insertAccountService,
        GetAccountService $getAccountService
    )
    {
        $this->insertAccountService = $insertAccountService;
        $this->getAccountService = $getAccountService;
    }

    public function insertUserTeam(InsertTeamRequest $request, $id)
    {
        return $this->insertAccountService->createNewUserTeam($request,$id);
    }

    public function activationUserTeam(ActivationUserTeamRequest $request, $id)
    {
        return $this->insertAccountService->aktifasiAkunTeam($request,$id);
    }

    public function getUserTeam(GetAccountTeamRequest $request, $id)
    {
        return $this->getAccountService->getCollection($id);
    }
}
