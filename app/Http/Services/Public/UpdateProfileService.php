<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Models\TransaksiPembuatanTeam;
use App\Models\User;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;
use Validator;

class UpdateProfileService
{
    public function handle($request)
    {
        $id = Auth::id();
        $parameter = $request->all();
        $user = User::where('id', $id)->first();
        $pengguna = Pengguna::where('id_user', $id)->first();
        if (isset($parameter['password'])) {
            $parameter['password'] = bcrypt($parameter['password']);
        }

        if ($user->email) {
            unset($parameter['email']);
        }

        if ($pengguna->nomor_telepon) {
            unset($parameter['nomor_telepon']);
        }

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if ($userRoles) {
            $transaksiPembuatanTeam = TransaksiPembuatanTeam::where('id_user', $id)->first();
            if ($transaksiPembuatanTeam->status_ganti_password) {
                unset($parameter['password']);
            }
        } else {
            unset($parameter['password']);
        }

        $statusPengguna = $pengguna->id_status_pengguna;
        if ($statusPengguna == 1 || $statusPengguna == 4) {
            $statusPengguna = (int)$statusPengguna + 1;
        }

        $user->update($parameter);
        $pengguna->update(array_merge($parameter, ['id_status_pengguna' => $statusPengguna]));

        $user = User::where('id', $id)->first();
        $pengguna = Pengguna::where('id_user', $id)->first();
        $transaksiPembuatanTeam = TransaksiPembuatanTeam::where('id_user', $id)->first();


        $validator = Validator::make([], [
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'lokasi' => 'required',
        ]);

        return response()->json(['message' => 'Profile berhasil di update'], 200);
    }
}
