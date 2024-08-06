<?php

namespace App\Http\Utility;

use GuzzleHttp\Client;

class SmsUtility
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public static function sendSms(string $nomorTelepon, string $text)
    {
        $client = new Client();

        $response = $client->request('POST', 'https://rest.nexmo.com/sms/json', [
            'form_params' => [
                'api_key' => env('VONAGE_KEY'),
                'api_secret' => env('VONAGE_SECRET'),
                'from' => env('VONAGE_FROM_NAME'),
                'to' => $nomorTelepon,
                'text' => $text
            ]
        ]);

        return response()->json(json_decode($response->getBody()->getContents()));
    }
}
