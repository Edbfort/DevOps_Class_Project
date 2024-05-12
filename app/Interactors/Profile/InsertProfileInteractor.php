<?php

namespace App\Interactors\Profile;

use App\Models\DataPribadi;
use App\Repositories\DataPribadiRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertProfileInteractor
{
    protected $dataPribadiRepository;
    protected $userRepository;

    public function __construct
    (
        DataPribadiRepository $dataPribadiRepository,
        UserRepository $userRepository
    )
    {
        $this->dataPribadiRepository = $dataPribadiRepository;
        $this->userRepository = $userRepository;
    }

    public function setProfile($request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $dataPribadi = $this->dataPribadiRepository->findByUserId($id);
        $user = $this->userRepository->findOneById($id);
        if ($dataPribadi) {
            try {
                DB::beginTransaction();
                $user->nama = $request->nama;
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

