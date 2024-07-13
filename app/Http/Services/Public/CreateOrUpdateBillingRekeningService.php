<?php

namespace App\Http\Services\Public;

use App\Models\BillingRekening;
use Illuminate\Support\Facades\Auth;

class CreateOrUpdateBillingRekeningService
{
    public function handle($request)
    {
        // Update or create the billing rekening
        BillingRekening::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'id_bank' => $request->id_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik' => $request->nama_pemilik
            ]
        );

        return response()->json(['message' => 'Billing Rekening berhasil di update'], 200);
    }
}
