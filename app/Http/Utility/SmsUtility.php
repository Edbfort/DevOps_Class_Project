<?php

namespace App\Http\Utility;

use Illuminate\Support\Facades\Http;

class SmsUtility
{
    public static function sendSms(string $nomorTelepon = "6289604884108", string $text = "Hayo Akan Kena Hack")
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 829f19c1110f4ca9be1a2b02c5004418',
            'Content-Type' => 'application/json'
        ])->post('https://sms.api.sinch.com/xms/v1/3313d3ac9c1f4bdfab8e08ac3d4e31a5/batches', [
            "from" => "447520651400",
            "to" => [$nomorTelepon],
            "body" => $text
        ]);

        return response()->json(json_decode($response->getBody()->getContents()));
    }
}
