<?php

namespace App\Http\Services\Account;


use App\Models\Pengguna;
use App\Models\ProfileTeam;
use App\Models\TeamMember;
use App\Models\TransaksiPembuatanTeam;
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

    public function handle($request)
    {
        $authId = Auth::id();

        try {
            DB::beginTransaction();

            $user = new User;
            $user->nama = $request->nama_team;
            $user->email = $request->email;
            $user->password = bcrypt($request->temp_password);
            $user->save();

            $penggunaId = $this->penggunaRepository->findByUserId($authId)->id;
            $newTransaksiCreateUser = new TransaksiPembuatanTeam();
            $newTransaksiCreateUser->id_user = $user->id;
            $newTransaksiCreateUser->temp_password = $request->temp_password;
            $newTransaksiCreateUser->id_pengguna_cha = $penggunaId;
            $newTransaksiCreateUser->save();


            $pengguna = new Pengguna();
            $pengguna->id_user = $user->id;
            $pengguna->status = 0;
            $pengguna->waktu_buat = new \DateTime();
            $pengguna->waktu_ubah = new \DateTime();
            $pengguna->save();

            $userRoles = new UserRoles();
            $userRoles->id_user = $user->id;
            $userRoles->id_role = 4;
            $userRoles->save();


            DB::commit();
            return response()->json(['message' => 'Akun Berhasil Di Buat'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
//            return response()->json(['errors' => 'Terjadi Kesalahan'], 500);
            return $e;
        }
    }

    public function aktifasiAkunTeam($request, $id)
    {
        $authId = Auth::id();
        $transaksiPembuatanAkun = $this->transaksiPembuatanAkunRepository->getOneByIdUser($id);
        $user = $this->userRepository->getById($id);
        if ($id != $authId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }


        if (!$transaksiPembuatanAkun) {
            return response()->json(['errors' => 'Tidak di temukan mohon hubungi developer'], 404);
        }

        try {
            $user->password = bcrypt($request->password);
            $user->save();
            $transaksiPembuatanAkun->status_aktif = 1;
            $transaksiPembuatanAkun->save();

            return response()->json(['message' => 'Akun Berhasil Di Aktifasi'], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => 'Terjadi Kesalahan mohon huubungi developer'], 500);
        }

    }
}

