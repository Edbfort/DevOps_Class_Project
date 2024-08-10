<?php

namespace App\Http\Services\CreativeHubTeam;

use App\Http\Requests\InsertLamaranProyekRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\LamaranProyek;

class InsertLamaranProyekService
{
    /**
     * Summary of handle
     * @param InsertLamaranProyekRequest $request
     */
    public function handle(InsertLamaranProyekRequest $request)
    {
        $userId = Auth::id();

        $parameter = $request->validated();

        LamaranProyek::updateOrCreate(array_merge(
            [
                'id_team' => $userId,
            ],
            $parameter
        ));

        return response()->json(['message' => 'Pengajuan projek berhasil diajukan'], 200);
    }
}
