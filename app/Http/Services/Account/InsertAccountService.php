<?php

namespace App\Http\Services\Account;


use App\Models\CreditCardInfo;
use App\Models\Pengguna;
use App\Models\ProfileTeam;
use App\Models\TeamMember;
use App\Models\TransaksiPembuatanAkun;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\PenggunaRepository;
use App\Repositories\TransaksiPembuatanAkunReposity;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertAccountService
{
    protected $userRepository;
    protected $penggunaRepository;
    protected $transaksiPembuatanAkunRepository;

    public function __construct
    (
        PenggunaRepository $penggunaRepository,
        UserRepository $userRepository,
        TransaksiPembuatanAkunReposity $transaksiPembuatanAkunRepository,
    )
    {
        $this->penggunaRepository = $penggunaRepository;
        $this->userRepository = $userRepository;
        $this->transaksiPembuatanAkunRepository = $transaksiPembuatanAkunRepository;
    }

    public function createNewUserTeam($request,$id)
    {
        $authId = Auth::id();

        if ($id != $authId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }
        try {
            DB::beginTransaction();

            $user = new User;
            $user->nama = $request->nama_team;
            $user->email = $request->email;
            $user->tanggal_lahir = new \DateTime();
            $user->jenis_kelamin = 3;
            $user->password = bcrypt($request->temp_password);
            $user->save();

            $penggunaId = $this->penggunaRepository->findByUserId($authId)->id;
            $newTransaksiCreateUser = new TransaksiPembuatanAkun();
            $newTransaksiCreateUser->id_creative_hub = $penggunaId;
            $newTransaksiCreateUser->id_user = $user->id;
            $newTransaksiCreateUser->nama_team = $request->nama_team;
            $newTransaksiCreateUser->temp_password = $request->temp_password;
            $newTransaksiCreateUser->status_aktif = 0;
            $newTransaksiCreateUser->save();


            $pengguna = new Pengguna();
            $pengguna->id_user = $user->id;
            $pengguna->id_status_pengguna = 1;
            $pengguna->username = $request->nama_team;
            $pengguna->uid = 800 . $user->id;
            $pengguna->waktu_buat = new \DateTime();
            $pengguna->waktu_ubah = new \DateTime();
            $pengguna->save();

            $userRoles = new UserRoles();
            $userRoles->id_user = $user->id;
            $userRoles->id_role_name = 4;
            $userRoles->save();

            $teamProfile = new ProfileTeam();
            $teamProfile->id_creative_hub = $penggunaId;
            $teamProfile->nama_team = $request->nama_team;
            $teamProfile->save();

            $creditCardInfo = new CreditCardInfo();
            $creditCardInfo->id_pengguna = $pengguna->id;
            $creditCardInfo->save();

            DB::commit();
            return response()->json(['message' => 'Akun Berhasil Di Buat'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }

    public function aktifasiAkunTeam($request, $id)
    {
        $authId = Auth::id();
        $transaksiPembuatanAkun = $this->transaksiPembuatanAkunRepository->getOneByIdUser($id);
        $user = $this->userRepository->getById($id);
        if ($id != $authId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }


        if (!$transaksiPembuatanAkun) {
            return response()->json(['error' => 'Tidak di temukan mohon hubungi developer'], 404);
        }

        try {
            $user->password = bcrypt($request->password);
            $user->save();
            $transaksiPembuatanAkun->status_aktif = 1;
            $transaksiPembuatanAkun->save();

            return response()->json(['message' => 'Akun Berhasil Di Aktifasi'], 201);
        } catch (\Exception $e) {
//            return $e;
            return response()->json(['error' => 'Terjadi Kesalahan mohon huubungi developer'], 500);
        }

    }
}

