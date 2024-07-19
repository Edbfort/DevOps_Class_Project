<?php

namespace App\Http\Services\client;

use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\Proyek;
use App\Repositories\UserRolesRepository;
use DateTime;
use Illuminate\Support\Facades\Auth;

class InsertAnggotaKeProyekService
{
    public function handle($request)
    {
        $id = Auth::id();

        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_status_proyek' => 1
        ])
            ->whereRaw($request->id_user . ' IN (proyek.id_client, proyek.id_controller)')
            ->first();

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles || !$proyek) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama_role == 'client') {
            $pengguna = Pengguna::select([
                'id_user',
                'id_status_pengguna'
            ])
                ->where('id_user', $proyek->id_controller)
                ->get()->first()->toArray();

            $proyek->update([
                'id_controller' => $pengguna['id']
            ]);

            $roleUser = 'Controller';
        } elseif ($userRoles->nama_role == 'controller') {
            $pengguna = Pengguna::select([
                'id_user',
                'id_status_pengguna'
            ])
                ->where('id_user', $proyek->id_team)
                ->get()->first()->toArray();

            $proyek->update([
                'id_team' => $pengguna['id']
            ]);

            $roleUser = 'Team';
        }

        return response()->json(['message' => 'Menambah ' . $roleUser . ' berhasil dilakukan'], 200);
    }
}
