<?php

namespace App\Interactors\Profile;

use App\Repositories\DataPribadiRepository;
use Illuminate\Support\Facades\Auth;

class GetProfileInteractor
{
    protected $dataPribadiRepository;

    public function __construct
    (
        DataPribadiRepository $dataPribadiRepository
    )
    {
        $this->dataPribadiRepository = $dataPribadiRepository;
    }

    public function getProfil($id)
    {
        $userId = Auth::id();
        if ($id != $userId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }
        $dataUser = $this->dataPribadiRepository->findDataPribadiById($id);

        return response()->json($dataUser, 200);
    }
}
