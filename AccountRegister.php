<?php
require_once ("Utils/Validator.php");
require_once ('lib/PageTemplate.php');
require_once ('Database.php');


$dbContext = new Database();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO:Add validation - redan registrerad, password != passwordAgain
    $username = $_POST['username'];
    $password = $_POST['password']; // Hejsan123#
    try {
        $userId = $dbContext->getUserDatabas()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.ethereal.email';
            $mail->SMTPAuth = true;
            $mail->Username = 'rollin61@ethereal.email';
            $mail->Password = '1XaAWE4ZkqfF69mYcQ';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->From = "stefans@superdupershop.com";
            $mail->FromName = "Hello"; //To address and name 
            $mail->addAddress("recepient1@example.com"); //Address to which recipient will reply 
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
            $mail->isHTML(true);
            $mail->Subject = "Registrering";
            $url = 'http://localhost:5000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i>";
            $mail->send();

        });
        header('Location: /user/login');
        exit;
    } catch (Exception $e) {
        throw $e;
        echo $e->getMessage();
        exit;
        $message = "Error";
    }
}

# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Regsier";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
?>
<p>
<div class="row">

    <div class="row">
        <div class="col-md-12">
            <div class="newsletter">
                <p>User<strong>&nbsp;REGISTER</strong></p>
                <form method="POST">
                    <input class="input" type="email" placeholder="Enter Your Email">
                    <br />
                    <br />
                    <input class="input" type="password" placeholder="Enter Your Password">
                    <br />
                    <br />
                    <input class="input" type="password" placeholder="Repeat Password">
                    <br />
                    <br />
                    <input class="input" type="name" placeholder="Name">
                    <br />
                    <br />
                    <input class="input" type="street" placeholder="Street address">
                    <br />
                    <br />
                    <input class="input" type="postal" placeholder="Postal code">
                    <br />
                    <br />
                    <input class="input" type="city" placeholder="City">
                    <br />
                    <br />
                    <button class="newsletter-btn"><i class="fa fa-envelope"></i> Register</button>
                </form>
            </div>
        </div>
    </div>


</div>


</p>