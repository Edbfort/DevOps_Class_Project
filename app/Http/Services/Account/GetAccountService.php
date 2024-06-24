<?php

namespace App\Http\Services\Account;


use App\Models\Pengguna;
use App\Models\ProfileTeam;
use App\Models\TeamMember;
use App\Models\TransaksiPembuatanAkun;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use App\Repositories\TransaksiPembuatanAkunReposity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetAccountService
{
    protected $transaksiPembuatanAkunRepository;
    protected $penggunaRepository;

    public function __construct
    (
        TransaksiPembuatanAkunReposity $transaksiPembuatanAkunRepository,
        PenggunaRepository $penggunaRepository,
    )
    {
        $this->transaksiPembuatanAkunRepository = $transaksiPembuatanAkunRepository;
        $this->penggunaRepository = $penggunaRepository;
    }

    public function getCollection($id)
    {
        $authId = Auth::id();

        if ($id != $authId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $penggunaId = $this->penggunaRepository->findByUserId($id)->id;
        return $this->transaksiPembuatanAkunRepository->findManyBy(['nama_team','temp_password','status_aktif'],['id_creative_hub'=> $penggunaId]);
    }

}

