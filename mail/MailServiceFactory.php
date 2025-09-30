<?php

class MailServiceFactory {

    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function createMailService() {
        $type = $this->config['type'];
        $className = ucfirst($type) . "Service"; // Convert 'mailgun' to 'MailgunService', for example

        if (!class_exists($className)) {
            throw new Exception("Unsupported mail service type: $type");
        }

        $mailService = new $className();
        $mailService->configure($this->config);

        return $mailService;
    }
}
