<?php

namespace App\Http\Services\Profile;

use App\Models\ProfileCompany;
use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use App\Repositories\ProfileTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetProfileService
{
    protected $dataPribadiRepository;
    protected $userRepository;
    protected $profileCompanyRepository;
    protected $penggunaRepository;
    protected $profileTeamRepository;

    public function __construct
    (
        UserRepository $userRepository,
        ProfileCompanyRepository $profileCompanyRepository,
        ProfileTeamRepository $profileTeamRepository,
        PenggunaRepository $penggunaRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->profileCompanyRepository = $profileCompanyRepository;
        $this->profileTeamRepository = $profileTeamRepository;
        $this->penggunaRepository = $penggunaRepository;
    }

    public function getProfileAdmin($id)
    {
        $idPengguna = $this->penggunaRepository->findByUserId($id)->id;
        $userFrofileCompany = $this->profileCompanyRepository->findByIdPeserta($idPengguna);
        return $userFrofileCompany;
    }

    public function getProfileTeam($request, $id)
    {
        $idPengguna = $this->penggunaRepository->findByUserId($id)->id;
        return $this->profileTeamRepository->findManyBy(['*'],['id_pengguna'=> $id]);
    }

    public function getDetailProfileTeam($request, $id)
    {
        $idPengguna = $this->penggunaRepository->findByUserId($id)->id;
        return $this->profileTeamRepository->getTeamProfileAndTeamWithIdPengguna($idPengguna);
    }
}

