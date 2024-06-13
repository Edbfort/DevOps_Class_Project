<?php

namespace App\Http\Services\Profile;

use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetProfileService
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

    public function getProfileAdmin($id)
    {
        $userId = Auth::id();
//
//        if ($id != $userId) {
//            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
//        }

        $idPengguna = $this->penggunaRepository->findByUserId($userId)->id;
        $userDrofileCompany = $this->profileCompanyRepository->findOneById($idPengguna);

        return $userDrofileCompany;
    }
}

