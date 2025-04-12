<?php

class MailSender {

    private $mailService;

    public function __construct(IMailService $mailService) {
        $this->mailService = $mailService;
    }

    public function send($to, $text, $subject = null, $from = null) {
        return $this->mailService->sendEmail($to, $text,$subject, $from);
    }
}
