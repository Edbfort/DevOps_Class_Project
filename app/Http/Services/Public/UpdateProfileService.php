<?php

namespace App\Http\Services\Public;

use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class UpdateProfileService
{
    public function handle($request)
    {
        $parameter = $request->all();
        $pengguna = Pengguna::where('id_user', Auth::id())->first();

        $pengguna->update(array_merge($parameter, ['status' => 1]));

        return response()->json(['message' => 'Profile berhasil di update'], 200);
    }
}
