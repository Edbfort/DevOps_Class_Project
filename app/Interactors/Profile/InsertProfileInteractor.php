<?php

namespace App\Interactors\Profile;

use App\Models\DataPribadi;
use App\Repositories\DataPribadiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertProfileInteractor
{
    protected $dataPribadiRepository;

    public function __construct
    (
        DataPribadiRepository $dataPribadiRepository
    )
    {
        $this->dataPribadiRepository = $dataPribadiRepository;
    }

    public function setProfile($request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $dataPribadi = $this->dataPribadiRepository->findByUserId($id);
        if ($dataPribadi) {
            try {
                DB::beginTransaction();
                $dataPribadi->nama_ig = 'halo';
                $dataPribadi->save();
                DB::commit();
                return response()->json(['message' => 'Data pribadi berhasil ditambahkan'], 201);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Gagal menambahkan data pribadi'], 500);
            }
        }  else {
            return response()->json(['error' => 'Data Pribadi Tidak DiTemukan'], 404);
        }

    }
}

