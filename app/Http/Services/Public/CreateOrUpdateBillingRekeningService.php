<?php

namespace App\Http\Services\Public;

use App\Models\BillingRekening;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class CreateOrUpdateBillingRekeningService
{
    public function handle($request)
    {
        // Update or create the billing rekening
        \Log::info('Authenticated user ID: ' . Auth::id());

        BillingRekening::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'id_bank' => $request->id_bank,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik' => $request->nama_pemilik,
            ]
        );

        $pengguna = Pengguna::where([
            'id_user' => Auth::id()
        ])->first();

        $pengguna->update([
            'is_status_pengguna' => 4,
            'waktu_ubah' => new \DateTime()
        ]);

        return response()->json(['message' => 'Billing Rekening berhasil di update'], 200);
    }
}
