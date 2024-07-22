<?php

namespace App\Http\Services\Client;

use App\Models\BillingClient;
use Illuminate\Support\Facades\Auth;

class GetBillingClientService
{
    public function handle()
    {
        $result = BillingClient::select('*')->where('id_user', Auth::id())->get()->toArray();

        if (count($result)) {
            $result = $result[0];
            $habisBerlaku = explode('-', $result['habis_berlaku']);
            $result['tahun'] = (int)$habisBerlaku[0];
            $result['bulan'] = (int)$habisBerlaku[1];
            unset($result['habis_berlaku']);
        }

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
