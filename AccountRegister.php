<?php
ob_start();
require_once ('vendor/autoload.php');
require_once ('lib/PageTemplate.php');
require_once ('Database.php');


$dbContext = new Database();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $userId = $dbContext->getUserDatabas()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $_ENV["Host"];
            $mail->SMTPAuth = $_ENV["SMTPAuth"];
            $mail->Username = $_ENV["Username"];
            $mail->Password = $_ENV["Password"];
            $mail->SMTPSecure = $_ENV["SMTPSecure"];
            $mail->Port = $_ENV["Port"];

            $mail->From = "";
            $mail->FromName = "Hello";
            $mail->addAddress($_POST['username']);
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
            $mail->isHTML(true);
            $mail->Subject = "Registrering";
            $url = 'http://localhost:5000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i>";
            $mail->send();

        });
        ob_end_clean();
        header('Location: /user/login');
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


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