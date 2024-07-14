<?php

namespace App\Http\Controllers;

use Mailjet\Client;
use Mailjet\Resources;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $mj = new Client(env('MAILJET_APIKEY'), env('MAILJET_SECRETKEY'), true, ['version' => 'v3']);
        $body = [
            'FromEmail' => "pilot@mailjet.com",
            'FromName' => "Your Mailjet Pilot",
            'Recipients' => [
                [
                    'Email' => "williamalim410@gmail.com",
                    'Name' => "Passenger 1"
                ]
            ],
            'Subject' => "Your email flight plan!",
            'Text-part' => "Dear passenger, welcome to Mailjet! May the delivery force be with you!",
            'Html-part' => "<h3>Dear passenger, welcome to Mailjet!</h3><br />May the delivery force be with you!"
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            return response()->json($response->getData());
        }

        return response()->json(['message' => 'Failed to send email'], 500);
    }
}
