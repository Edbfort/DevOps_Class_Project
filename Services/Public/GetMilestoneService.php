<?php

namespace App\Http\Services\Public;

use App\Models\Milestone;
use App\Models\Proyek;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetMilestoneService
{
    public function handle($request)
    {
        $proyek = Proyek::select([
            'proyek.id as proyek_id',
            'ut.id as team_id',
            'ut.nama as team_nama',
            'proyek.judul_proyek as proyek_judul_proyek',
            'proyek.anggaran as proyek_anggaran',
            'proyek.tanggal_tegat as proyek_tanggal_tegat',
            'proyek.perkembangan as proyek_perkembangan'
        ])
            ->join('users as ut', 'ut.id', '=', 'proyek.id_team')
            ->where([
                'proyek.id' => $request->id_proyek
            ])
            ->whereRaw(Auth::id() . ' IN (proyek.id_client, proyek.id_controller, proyek.id_team)')
            ->whereRaw(
                '(proyek.id_status_proyek = 5 ' .
                'OR proyek.id_status_proyek = 6)'
            )
            ->get()
            ->first();

        $result = [];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles || !$proyek) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama_role == 'creative-hub-admin') {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

        $milestoneArray = Milestone::select([
            'milestone.id as milestone_id',
            'milestone.topik as milestone_topik',
            'milestone.deskripsi as milestone_deskripsi',
            'milestone.persentase as milestone_persentase',
            'milestone.tanggal_tegat as milestone_tanggal_tegat',
            DB::raw('FLOOR(proyek.team_fee * milestone.persentase / 100) as payment'),
            'milestone.status as milestone_status',
            'milestone.info_perkembangan as milestone_info_perkembangan',
            'milestone.tautan as milestone_tautan'
        ])
            ->join('proyek', 'proyek.id', '=', 'milestone.id_proyek')
            ->where([
                'id_proyek' => $request->id_proyek
            ])
            ->orderBy('milestone.tanggal_tegat')
            ->get();

        $proyek['milestone'] = $milestoneArray;

        return response()->json(['data' => $proyek, 'message' => 'Data berhasil di ambil'], 200);
    }
}
