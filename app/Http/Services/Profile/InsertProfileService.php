<?php

namespace App\Http\Services\Profile;

use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertProfileService
{
    protected $dataPribadiRepository;
    protected $userRepository;
    protected $profileCompanyRepository;
    protected $penggunaRepository;

    public function __construct
    (
        UserRepository $userRepository,
        ProfileCompanyRepository $profileCompanyRepository,
        PenggunaRepository $penggunaRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->profileCompanyRepository = $profileCompanyRepository;
        $this->penggunaRepository = $penggunaRepository;
    }

    public function updateProfileAdmin($request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $idPengguna = $this->penggunaRepository->findByUserId($userId);

        try {
            DB::beginTransaction();
            $profileCompany = $this->profileCompanyRepository->findOneById($idPengguna->id);
            $profileCompany->nama = $request->nama;
            $profileCompany->tag_line = $request->tag_line;
            $profileCompany->jumlah_working_space = $request->jumlah_working_space;
            $profileCompany->nomor_telepon = $request->nomor_telepon;
            $profileCompany->alamat = $request->alamat;
            $profileCompany->website = $request->website;
            $profileCompany->deskripsi = $request->deskripsi;
            $profileCompany->save();
            DB::commit();
            return response()->json(['message' => 'Profile berhasil update'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
}

