<?php
require_once ('vendor/autoload.php');
require_once ('Database.php');
require_once ('Utils/Mailer.php');
$dbContext = new Database();


if (isset($_POST["username"])) {
    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "stefanssupershopuserdb";

    $con = new mysqli($host, $user, $pass, $db);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $emailTo = $_POST['username'];
    $code = uniqid(true);
    $query = mysqli_query($con, "INSERT INTO resetPasswords (code, username) VALUES('$code','$emailTo')");
    if (!$query) {
        exit('Error');
    }
    try {
        $username = "";
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mailer = new Mailer($mail);
        $mail->AllowEmpty = true;
        $mail->addAddress($_POST['username']);
        $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
        $subject = "Glömt Lösenord";
        $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetPassword.php?code=$code";
        $body = "<i>Hej, klicka på <a href='$url'>$url</a> för att ändra lösenordet</i>";
        $mailer->sendMail($mailer, $subject, $body, $username);
        $mail->send();
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent successfully";
        }
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