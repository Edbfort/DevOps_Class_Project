<?php

namespace App\Http\Controllers;
use App\Http\Requests\InsertComunityRequest;
use App\Http\Requests\JoinComunityRequest;
use App\Interactors\Comunity\GetKomunitasInteractor;
use App\Interactors\Comunity\InsertKomunitasInteractor;

class KomunitasController extends Controller
{
    protected $getComunityInteractor;
    protected $insertComunityInteractor;

    public function __construct
    (
        GetKomunitasInteractor $getComunityInteractor,
        InsertKomunitasInteractor $insertComunityInteractor
    )
    {
        $this->getComunityInteractor  = $getComunityInteractor;
        $this->insertComunityInteractor = $insertComunityInteractor;
    }

    public function getDaftarComunity()
    {
        $data = $this->getComunityInteractor->getComunity();
        return $data;
    }

    public function insertComunity(InsertComunityRequest $request)
    {
        $data = $this->insertComunityInteractor->insertComunity($request);
        return $data;
    }

    public function joinComunity(JoinComunityRequest $request, $id)
    {
        $data = $this->insertComunityInteractor->joinComunity($id);
        return $data;
    }
}

