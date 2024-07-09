<?php

namespace App\Http\Services\client;

use App\Models\User;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetDetailProyekService
{
    public function handle($id)
    {
        $proyek = Proyek::where('id', $id)->first();

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles || !$proyek) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif (1) {
            $select[] = 'email';
        }
        $result = LamaranProyek::where('id', $id)->all()->toArray();

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
