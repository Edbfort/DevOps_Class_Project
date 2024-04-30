<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetProfileRequest;
use App\Interactors\Profile\GetProfileInteractor;
use App\Interactors\Profile\InsertProfileInteractor;

class ProfilController extends Controller
{
    protected $getProfileInteractor;
    protected $insertProfileInteractor;

    public function __construct
    (
        GetProfileInteractor $getProfileInteractor,
        InsertProfileInteractor $insertProfileInteractor
    )
    {
        $this->getProfileInteractor = $getProfileInteractor;
        $this->insertProfileInteractor = $insertProfileInteractor;
    }

    public function getDataPribadi($id)
    {
        $profil = $this->getProfileInteractor->getProfil($id);
        return $profil;
    }

        public function setDataPribadi(SetProfileRequest $request, $id)
    {

        $data = $this->insertProfileInteractor->setProfile($request, $id);
        return $data;
    }
}

