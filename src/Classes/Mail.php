<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;
use Symfony\Component\Dotenv\Dotenv;

class Mail
{
    // remplacer ici par les clefs api Mailjet de la boucherie
    private $api_key;
    private $api_key_secret;

    public function __construct()
    {
        (new Dotenv())->bootEnv(dirname(__DIR__) . '/../.env');
        $this->api_key = $_ENV['API_KEY'];
        $this->api_key_secret = $_ENV['API_KEY_SECRET'];
    }

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
