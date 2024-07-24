<?php

namespace App\Http\Services\CreativeHubAdmin;

use App\Models\Pengguna;
use App\Models\TransaksiPembuatanTeam;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\PenggunaRepository;
use App\Repositories\TransaksiPembuatanAkunReposity;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertTeamService
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

        $cha = User::where('users.id', $authId)->first();

        try {
            DB::beginTransaction();

            $user = new User;
            $user->nama = $request->nama_team;
            $user->email = $request->email;
            $user->password = bcrypt($request->temp_password);
            $user->lokasi = $cha->lokasi;
            $user->save();

            $transaksiPembuatanTeam = new TransaksiPembuatanTeam();
            $transaksiPembuatanTeam->id_user = $user->id;
            $transaksiPembuatanTeam->temp_password = $request->temp_password;
            $transaksiPembuatanTeam->id_cha = $cha->id;
            $transaksiPembuatanTeam->save();

            $pengguna = new Pengguna();
            $pengguna->id_user = $user->id;
            $pengguna->id_status_pengguna = 1;
            $pengguna->waktu_buat = new \DateTime();
            $pengguna->waktu_ubah = new \DateTime();
            $pengguna->save();

            $userRoles = new UserRoles();
            $userRoles->id_user = $user->id;
            $userRoles->id_role = 4;
            $userRoles->save();

            DB::commit();
            return response()->json(['message' => 'Akun Berhasil Di Buat'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'Terjadi Kesalahan'], 500);
        }
    }
}

