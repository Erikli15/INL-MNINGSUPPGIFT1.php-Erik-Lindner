<?php
ob_start();
require_once ('vendor/autoload.php');
require_once ('Database.php');
require_once ('Utils/Validator.php');
require_once ('Utils/Mailer.php');
$dbContext = new Database();

$v = new Validator($_POST);


if (isset($_POST["username"])) {
    $v->field('username')->required()->email();

    if ($v->is_valid()) {


        $message = "Du är nu registrerad";

    } else {
        $message = "Fel på något";
    }
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "stefanssupershopuserdb";

    try {
        $auth = $dbContext->getUserDatabas()->getAuth();

        $auth->forgotPassword($_POST['username'], function ($selector, $token) {
            $username = "";
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mailer = new Mailer($mail);
            $mail->AllowEmpty = true;
            $mail->addAddress($_POST['username']);
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
            $subject = "Glömt Lösenord";
            $url = 'http://localhost:8000/resetPassword.php?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $body = "<i>Hej, klicka på <a href='$url'>$url</a> för att ändra lösenordet</i>";
            $mailer->sendMail($mailer, $subject, $body, $username, $selector, $token);
            $mail->send();
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message has been sent successfully";
            }
        });
    } catch (\Delight\Auth\InvalidEmailException $e) {
        die('Invalid email address');
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
        die('Email not verified');
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit;
}
?>




<form method="post">
    <input type="email" name="username" placeholder="Email" autocomplete="off">
    <br>
    <input type="submit" name="submit" value="Reset Email">
</form>