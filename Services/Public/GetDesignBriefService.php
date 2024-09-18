<?php

namespace App\Http\Services\Public;

use App\Models\DesignBreif;
use Illuminate\Support\Facades\Auth;

class GetDesignBriefService
{
    public function handle($request)
    {
        $query = DesignBreif::query();

        $query->select(['design_breif.link_meeting', 'design_breif.lokasi_dokumen', 'design_breif.status'])
            ->join('proyek as p', 'p.id', '=', 'design_breif.id_proyek')
            ->whereRaw('id_proyek = ' . $request->id_proyek .
                ' AND (p.id_client = ' . Auth::id() .
                ' OR p.id_controller = ' . Auth::id() .
                ' OR p.id_team = ' . Auth::id() . ')');

        $designBrief = $query->get()->first()->toArray();
        $designBrief['lokasi_dokumen'] = 'upload/dokumen/designBrief/' . $designBrief['lokasi_dokumen'];

        return response()->json(['data' => $designBrief, 'message' => 'Design Brief berhasil di ambil'], 200);
    }
}
