<?php

require '../vendor/autoload.php';

use Mailgun\Mailgun;

class MailgunService implements IMailService {

    private $mg;
    private $from;
    private $fromName;
    private $subject;
    private $domain;

    public function configure($config) {
        $this->domain = $config['domain'];
        $this->from = $config['from'];
        $this->fromName = $config['fromName'];
        $this->subject = $config['subject'];
        $this->mg = Mailgun::create($config['apiKey']);
    }

    public function sendEmail($to, $text, $subject,  $from) {
        return $this->mg->messages()->send($this->domain, [
            'from' => $from ? $from : $this->fromName . ' <' . $this->from . '>',
            'to' => $to,
            'subject' => $subject ? $subject : $this->subject,
            'html' => $text
        ]);
    }
}
