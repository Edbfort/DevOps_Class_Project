<?php

namespace App\Http\Services\Account;


use App\Models\Pengguna;
use App\Models\TransaksiPembuatanAkun;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertAccountService
{
    protected $penggunaRepository;

    public function __construct
    (
        PenggunaRepository $penggunaRepository
    )
    {
        $this->penggunaRepository = $penggunaRepository;
    }

    public function createNewUserTeam($request,$id)
    {
        $authId = Auth::id();

        if ($id != $authId) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }
        try {
            DB::beginTransaction();
            $penggunaId = $this->penggunaRepository->findByUserId($authId)->id;
            $newTransaksiCreateUser = new TransaksiPembuatanAkun();
            $newTransaksiCreateUser->id_creative_hub = $penggunaId;
            $newTransaksiCreateUser->nama_team = $request->nama_team;
            $newTransaksiCreateUser->temp_password = $request->temp_password;
            $newTransaksiCreateUser->status_aktif = 0;
            $newTransaksiCreateUser->save();

            $user = new User;
            $user->nama = $request->nama_team;
            $user->email = $request->email;
            $user->tanggal_lahir = new \DateTime();
            $user->jenis_kelamin = 3;
            $user->password = bcrypt($request->temp_password);
            $user->save();

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

            DB::commit();
            return response()->json(['message' => 'Akun Berhasil Di Buat'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
//            return $e;
        }


        return 'hai';
    }

}

