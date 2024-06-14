<?php

namespace App\Http\Controllers;


use App\Http\Services\Account\InsertAccountService;
use App\Http\Requests\InsertAccountRequest;

class AccountController extends Controller
{
    protected $insertAccountService;
    public function __construct
    (
        InsertAccountService $insertAccountService
    )
    {
        $this->insertAccountService = $insertAccountService;
    }

    public function insertUserTeam(InsertAccountRequest $request, $id)
    {
        return $this->insertAccountService->createNewUserTeam($request,$id);
    }
}
