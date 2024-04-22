<?php
require_once ('vendor/autoload.php');
class Mailer
{


    public $mailer;

    function __construct()
    {
        $this->$mailer->isSMTP();
        $this->$mailer->Host = $_ENV["Host"];
        $this->$mailer->SMTPAuth = $_ENV["SMTPAuth"];
        $this->$mailer->Username = $_ENV["Username"];
        $this->$mailer->Password = $_ENV["Password"];
        $this->$mailer->SMTPSecure = $_ENV["SMTPSecure"];
        $this->$mailer->Port = $_ENV["Port"];
    }
    function sendMail($subject, $body, $username)
    {
        $this->$mailer->From = "";
        $this->$mailer->FromName = "Hello";
        $this->$mailer->addAddress($username);
        $this->$mailer->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
        $this->$mailer->isHTML(true);
        $this->$mailer->Subject = $subject;
        $this->$mailer->Body = $body;
    }
}