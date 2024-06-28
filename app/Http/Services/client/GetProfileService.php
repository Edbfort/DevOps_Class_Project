<?php

namespace App\Http\Services\client;

use App\Models\ClientData;
use App\Models\Pengguna;

class GetProfileService
{
    public function handle($request, $id)
    {
        $idPengguna = Pengguna::where('id_user', $id)->first()->id;
        $clientData = ClientData::where('id_pengguna', $idPengguna)->first();

        if (!$clientData) {
            return response()->json(['message' => 'Client tidak di temukan'], 404);
        }
        $clientData->status_boleh_edit = 0;
        if ($id == $idPengguna) {
            $clientData->status_boleh_edit = 1;
        }
        $result = [
            'data_client' => $clientData->toArray()
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
