<?php

namespace App\Http\Services\client;

use App\Models\BillingClient;
use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class UpdateBillingClientService
{
    public function handle($request)
    {
        $billingClient = BillingClient::where('id_user', Auth::id())->first();

        if (!$billingClient) {
            BillingClient::create([
                'id_user' => Auth::id(),
                'nomor_kartu' => $request->nomor_kartu,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'habis_berlaku' => $request->habis_berlaku,
                'cvv' => $request->cvv,
                'waktu_buat' => new \DateTime(),
                'waktu_ubah' => new \DateTime(),
            ]);
        } else {
            $billingClient->update([
                'nomor_kartu' => $request->nomor_kartu,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'habis_berlaku' => $request->habis_berlaku,
                'cvv' => $request->cvv,
                'waktu_ubah' => new \DateTime(),
            ]);
        }

        return response()->json(['message' => 'Billing info berhasil di update'], 200);
    }
}
