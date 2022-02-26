<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    // remplacer ici par les clefs api Mailjet de la boucherie
    private $api_key = '9d8a3462a17da709f9c4e4accbbbf626';
    private $api_key_secret = 'df9bbfae265028b82d4513329ab4cb40';

    public function send($to_mail, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        // Modifier ici avec l'adresse mail de la boucherie
                        'Email' => "py.castelleta.pro@gmail.com",
                        'Name' => "Boucherie Paux"
                    ],
                    'To' => [
                        [
                            'Email' => $to_mail,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3682155,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
