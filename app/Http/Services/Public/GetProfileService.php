<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class GetProfileService
{
    public function handle($id)
    {
        $idPengguna = Pengguna::where('id_user', $id)->first();

        if (!$idPengguna) {
            return response()->json(['message' => 'Pengguna tidak di temukan'], 404);
        }
        $status_boleh_edit = 0;
        if ($id == Auth::id()) {
            $status_boleh_edit = 1;
        }
        $result = [
            'data_client' => $idPengguna->toArray(),
            'status_boleh_edit' => $status_boleh_edit
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
