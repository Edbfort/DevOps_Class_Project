<?php

namespace App\Http\Utility;

use Mailjet\Client;
use Mailjet\Resources;

class MailerUtility
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('MAILJET_APIKEY'), env('MAILJET_SECRETKEY'), true, ['version' => 'v3']);
    }

    public static function sendEmail($recipients, string $subject, string $textPart, string $htmlPart)
    {
        $client = new Client(env('MAILJET_APIKEY'), env('MAILJET_SECRETKEY'), true, ['version' => 'v3']);

        $body = [
            'FromEmail' => env('MAILJET_FROM_ADDRESS'),
            'FromName' => env('MAILJET_FROM_NAME'),
            'Recipients' => $recipients,
            'Subject' => $subject,
            'Text-part' => $textPart,
            'Html-part' => $htmlPart
        ];

        $response = $client->post(Resources::$Email, ['body' => $body]);
        return $response;
    }
}
