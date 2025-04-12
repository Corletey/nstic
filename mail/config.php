<?php

return [
    //General
    'type' => 'smtp',  // mailgun or 'smtp'
    'from'  => 'no_reply@mg.aau.org',
    'fromName' => 'Association of African Universities',
    'subject' => 'Online Grants Management System - National Science, Technology and Innovation Council',
    
    //Maigun
    'domain' => 'mg.aau.org',
    'apiKey' => '8be931be086b49d1c2e4e6eba89e8a37-4b98b89f-9f4f426d',
    
    // SMTP or additional mail services
    //Office 365
    // 'host' => 'smtp.office365.com',
    // 'username' => 'admin@aau.org',
    // 'password' => 'j4Y1$1$@gh1',
    // 'replyTo' => 'admin@aau.org',
    //Gmail
    'host' => 'smtp.gmail.com',
    'username' => 'aaumail1@gmail.com',
    'password' => 'ycrooepturbagkud', 
    'replyTo' => 'aaumail1@gmail.com',
    'port' => 587, // 587 for TLS or 465 for SSL
    'secure' => 'tls', // or ssl
];
