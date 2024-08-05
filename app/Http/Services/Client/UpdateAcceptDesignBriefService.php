<?php

namespace App\Http\Services\Client;

use App\Models\DesignBreif;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateAcceptDesignBriefService
{
    public function handle($request)
    {
        $id = Auth::id();

        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_client' => $id,
            'id_status_proyek' => 2
        ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Gagal accpet design brief'], 422);
        }

        $designBrief = DesignBreif::where([
            'id_controller' => Auth::id(),
            'id_proyek' => $request->id_proyek
        ])->first();

        if (!$designBrief) {
            return response()->json(['message' => 'Gagal accpet design brief'], 422);
        }

        $designBrief->update([
            'status' => 1,
            'waktu_ubah' => new DateTime(),
        ]);

        return response()->json(['message' => 'Accept design brief berhasil dilakukan'], 200);
    }
}
