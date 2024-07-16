<?php

namespace App\Http\Services\client;

use App\Models\BillingClient;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class GetControllerListService
{
    public function handle($request)
    {
        $controllerList = Pengguna::select('pengguna.id as id_pengguna','fee','nomor_telepon','alamat','profil_detail','website','tag_line','spesialisasi')
            ->join('users', 'users.id', '=', 'pengguna.id_user')
            ->join('user_roles', 'users.id', '=', 'user_roles.id_user')
            ->where([
//                ['pengguna.id_status_pengguna', '=', '6'],
                ['user_roles.id_role', '=', '2']
            ])
            ->get();

        $result = [
            'list_controller' => $controllerList->toArray()
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
