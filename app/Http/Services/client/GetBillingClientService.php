<?php

namespace App\Http\Services\client;

use App\Models\BillingClient;
use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use function Termwind\renderUsing;

class GetBillingClientService
{
    public function handle()
    {
        $billingClient = BillingClient::where('id_user', Auth::id())->first();

        $result = [
            'data_client' => $billingClient->toArray()
        ];

        $habisBerlaku = explode('-', $result['habis_berlaku']);
        $result['tahun'] = (int)$habisBerlaku[0];
        $result['bulan'] = (int)$habisBerlaku[1];
        unset($result['habis_berlaku']);

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
