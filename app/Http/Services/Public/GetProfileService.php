<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetProfileService
{
    public function handle($id)
    {
        $select = [
            'nama',
            'lokasi',
            'profil_detail',
            'website',
            'pengguna.tag_line'
        ];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

//        if ($id == Auth::id()) {
//            $select = array_merge($select, [
//                ''
//            ]);
//        }

        $pengguna = Pengguna::select($select)
            ->join('users', 'users.id', '=', 'pengguna.id_user')
            ->where('id_user', $id)
            ->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

        $data = array_merge($pengguna->toArray(), $user->toArray());
        $result = [];

        $result['data_client'] = $data;

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
