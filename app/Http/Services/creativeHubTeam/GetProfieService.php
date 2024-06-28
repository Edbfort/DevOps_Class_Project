<?php

namespace App\Http\Services\creativeHubTeam;

use App\Models\ClientData;
use App\Models\Pengguna;
use App\Models\ProfileTeam;

class GetProfileService
{
    public function handle($request, $id)
    {
        $idPengguna = Pengguna::where('id_user', $id)->first()->id;
        $teamData = ProfileTeam::where('id_pengguna', $idPengguna)->first();

        if (!$teamData) {
            return response()->json(['message' => 'Team tidak di temukan'], 404);
        }
        $teamData->status_boleh_edit = 0;
        if ($id == $idPengguna) {
            $teamData->status_boleh_edit = 1;
        }
        $result = [
            'data_team' => $teamData->toArray()
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
