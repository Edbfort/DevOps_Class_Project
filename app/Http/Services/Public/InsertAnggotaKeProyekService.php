<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Models\Proyek;
use App\Repositories\UserRolesRepository;
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
            ->whereRaw($id . ' IN (proyek.id_client, proyek.id_controller)')
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
                ->where('id_user', $proyek->id_user)
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
                ->where('id_user', $proyek->id_user)
                ->get()->first()->toArray();

            $proyek->update([
                'id_team' => $pengguna['id']
            ]);

            $roleUser = 'Team';
        }

        return response()->json(['message' => 'Menambah ' . $roleUser . ' berhasil dilakukan'], 200);
    }
}
