<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    // remplacer ici par les clefs api Mailjet de la boucherie
    private $api_key = '8a20f4046f4569060a23b6cd78a16a07';
    private $api_key_secret = 'de6b4a240e228827c7d5d8c9f7bc56a3';

    public function send($to_mail, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        // Modifier ici avec l'adresse mail de la boucherie
                        'Email' => "projet.team.gradient@gmail.com",
                        'Name' => "Boucherie Paux"
                    ],
                    'To' => [
                        [
                            'Email' => $to_mail,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3682646,
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
