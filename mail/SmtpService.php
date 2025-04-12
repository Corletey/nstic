<?php

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SMTPService implements IMailService {

    private $host;
    private $username;
    private $password;
    private $port;
    private $secure; // 'tls' or 'ssl'
    private $fromName;
    private $replyTo;
    private $subject;

    public function configure($config) {
        $this->host = $config['host'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->port = $config['port'];
        $this->secure = $config['secure'];
        $this->fromName = $config['fromName'];
        $this->replyTo = $config['replyTo'];
        $this->subject = $config['subject'];
    }

    public function sendEmail( $to, $text, $subject, $from) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                      // Enable verbose debug output (2 for debugging)
            $mail->isSMTP();                                           // Set mailer to use SMTP
            $mail->Host = $this->host;                                 // Specify main SMTP servers
            $mail->SMTPAuth = true;                                    // Enable SMTP authentication
            $mail->Username = $this->username;                         // SMTP username
            $mail->Password = $this->password;                         // SMTP password
            $mail->SMTPSecure = $this->secure;                         // Enable TLS or SSL encryption
            $mail->Port = $this->port;                                 // TCP port to connect to

            //Recipients
            $mail->setFrom($this->username);
            $mail->addAddress($to);                                    // Add recipient
            $mail->addReplyTo($this->username, $this->fromName);

            // Content
            $mail->isHTML(false);                                      // Set email format to HTML if needed
            $mail->Subject = $subject ? $subject : $this->subject;
            $mail->Body = $text;

            $mail->send();
            return 'Message has been sent';

        } catch (Exception $e) {
            throw new Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
