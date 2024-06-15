<?php

namespace App\Http\Controllers;


use App\Http\Services\Account\GetAccountService;
use App\Http\Services\Account\InsertAccountService;
use App\Http\Requests\InsertAccountRequest;
use App\Http\Requests\GetAccountTeamRequest;
use App\Http\Services\Profile\GetProfileService;

class AccountController extends Controller
{
    protected $getAccountService;
    protected $insertAccountService;
    public function __construct
    (
        InsertAccountService $insertAccountService,
        GetAccountService $getAccountService
    )
    {
        $this->insertAccountService = $insertAccountService;
        $this->getAccountService = $getAccountService;
    }

    public function insertUserTeam(InsertAccountRequest $request, $id)
    {
        return $this->insertAccountService->createNewUserTeam($request,$id);
    }

    public function getUserTeam(GetAccountTeamRequest $request, $id)
    {
        return $this->getAccountService->getCollection($id);
    }
}
