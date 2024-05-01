<?php

namespace App\Interactors\Comunity;

use App\Repositories\DataPribadiRepository;
use App\Repositories\KomunitasRepository;
use Illuminate\Support\Facades\Auth;

class GetKomunitasInteractor
{
    protected $komunitasRepository;
    public function __construct
    (
        KomunitasRepository $komunitasRepository
    )
    {
        $this->komunitasRepository = $komunitasRepository;
    }

    public function getComunity()
    {
        $data = $this->komunitasRepository->getAllWithKomunitasOwner();

        return $data;
    }
}
