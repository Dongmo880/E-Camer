<?php
namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private  $apiKey = '388900925bbd8cd933dc6c6938ec5854';
    private  $apiKey_secrete  = '5242e6378239cddc95a3f95d16f3a220';

    public  function send($to_email,$to_name,$subject,$content)
    {
        $mj = new Client($this->apiKey, $this->apiKey_secrete,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "armandbonheur49@gmail.com",
                        'Name' => "E-camer"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3911711,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content'=>$content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
        //$response->success() && dd($response->getData());
    }
}