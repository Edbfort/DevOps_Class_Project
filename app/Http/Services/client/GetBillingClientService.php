<?php

namespace App\Http\Services\client;

use App\Models\BillingClient;
use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class GetBillingClientService
{
    public function handle()
    {
        $idPengguna = Pengguna::where('id_user', Auth::id())->first()->id;
        $billingClient = BillingClient::where('id_pengguna', $idPengguna)->first();

        $result = [
            'data_client' => $billingClient->toArray()
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
