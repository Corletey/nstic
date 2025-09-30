<?php

require 'IMailService.php';
require 'MailgunService.php';
require 'SmtpService.php';
require 'MailSender.php';
require 'MailServiceFactory.php';
$config = require 'config.php';

$factory = new MailServiceFactory($config);
$mailService = $factory->createMailService();

$mailSender = new MailSender($mailService);
$mailSender->send('write2kpani@gmail.com', 'Test Mail');

