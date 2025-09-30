<?php

use Mailgun\Mailgun;

class MailgunService {

    private $mailgun;
    private $domain = "mg.aau.org";
    private $apiKey = "8be931be086b49d1c2e4e6eba89e8a37-4b98b89f-9f4f426d";

    public function __construct() {
        require 'vendor/autoload.php';
        
        $this->mailgun = Mailgun::create($this->apiKey);
    }

    public function sendEmail($to, $subject, $body, $from = 'Association of African Universities <no_reply@mg.aau.org>') {
        $response = $this->mailgun->messages()->send($this->domain, [
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'html'    => $body
        ]);
        return $response;
    }
}