<?php

interface IMailService {
    public function sendEmail($to, $text, $subject, $from);
    public function configure($config);
}