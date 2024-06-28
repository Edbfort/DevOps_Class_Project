<?php

namespace App\Http\Services\client;

use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UpdateProfileService
{
    public function handle($request, $id)
    {
        $parameters = $request->all();
        $idPengguna = Pengguna::where('id_user', $id)->first()->id;

        if ($id != Auth::id()){
            return response()->json(['message' => 'Kamu tidak mempunyai akses untuk melakukan update untuk profile ini'], 403);
        }
        $clientData = ClientData::where('id_pengguna', $idPengguna)->first();

        if (!$clientData) {
            return response()->json(['message' => 'Client tidak di temukan'], 404);
        }

        $clientData->update($parameters);

        return response()->json(['message' => 'Profile berhasil di update'], 200);
    }

}
