<?php

namespace App\Http\Services\client;

use App\Models\Pengguna;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InsertProyekService
{
    public function handle($request)
    {
        $parameter = $request->all();

        $user = User::find(Auth::id());

        $pengguna = Pengguna::where('id_user', $user->id)->first();

        $parameter['id_client'] = $pengguna->id;

        // Create the Proyek record
        Proyek::create($parameter);

        return response()->json(['message' => 'Project berhasil di insert'], 200);
    }
}
