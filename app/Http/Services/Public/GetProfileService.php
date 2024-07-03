<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Models\User;
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
            'tag_line'
        ];
        if ($id == Auth::id()) {
            $select = array_merge($select, [
                ''
            ]) $select

        }
        $pengguna = Pengguna::where('id_user', $id)->first();

        if (!$pengguna || !$user) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($user->id);

        $data = array_merge($pengguna->toArray(), $user->toArray());
        $result = [];

        $result['data_client'] = $data;

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
