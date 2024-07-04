<?php

namespace App\Http\Services\Public;

use App\Models\BillingRekening;
use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateOrUpdateBillingRekeningService
{
    public function handle($request)
    {
        $parameter = $request->all();

        $user = User::find(Auth::id());

        $pengguna = Pengguna::where('id_user', $user->id)->first();

        // Update or create the billing rekening
        BillingRekening::updateOrCreate(
            ['id_pengguna' => $pengguna->id],
            $parameter
        );

        return response()->json(['message' => 'Billing Rekening berhasil di update'], 200);
    }
}
