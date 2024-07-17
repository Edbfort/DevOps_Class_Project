<?php

namespace App\Http\Services\Controller;

use App\Models\DesignBreif;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateDesignBriefService
{
    public function handle($request)
    {
        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_controller' => Auth::id()
        ])->first();

        if ($proyek) {
            $designBrief = DesignBreif::where([
                'id_controller' => Auth::id(),
                'id_proyek' => $request->id_proyek
            ])->first();

            if (!$designBrief) {
                DesignBreif::create([
                    'id_controller' => Auth::id(),
                    'id_proyek' => $request->id_proyek,
                    'link_meeting' => $request->link_meeting,
                    'lokasi_dokumen' => $request->lokasi_dokumen,
                    'status' => 0,
                    'waktu_buat' => new DateTime(),
                    'waktu_ubah' => new DateTime(),
                ]);
            } else {
                if ($designBrief->status == 0) {
                    $designBrief->update([
                        'link_meeting' => $request->link_meeting,
                        'lokasi_dokumen' => $request->lokasi_dokumen,
                        'waktu_ubah' => new DateTime(),
                    ]);
                } else {
                    return response()->json(['message' => 'Design Brief tidak dapat di update'], 200);
                }
            }
        } else {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 200);
        }

        return response()->json(['message' => 'Design Brief berhasil di update'], 200);
    }
}
