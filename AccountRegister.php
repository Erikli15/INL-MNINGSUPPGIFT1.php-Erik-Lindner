<?php
ob_start();
require_once ('vendor/autoload.php');
require_once ('lib/PageTemplate.php');
require_once ('Database.php');
require_once ('Utils/Validator.php');


$dbContext = new Database();

$users = new userDitales();

$message = "";
$username = "";

$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users->Name = $_POST['Name'];
    $users->StreetAddress = $_POST['StreetAddress'];
    $users->Zipcode = $_POST['Zipcode'];
    $users->City = $_POST['City'];


    $v->field('username')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(16)->must_contain('!@#$&')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');


    $v->field('Name')->required()->alpha([' '])->min_len(1)->max_len(50);
    $v->field('StreetAddress')->required()->min_len(1)->max_len(20);
    $v->field('Zipcode')->numeric()->min_len(1)->max_len(100000);
    $v->field('City')->required()->alpha([' '])->min_len(1)->max_len(50);

    if ($v->is_valid()) {


        $message = "Du är nu registrerad";

    } else {
        $message = "Fel på något";
    }

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
            $mail->addAddress($_POST["username"]);
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
            $mail->isHTML(true);
            $mail->Subject = "Registrering";
            $url = 'http://localhost:8000/verify_email.php?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i>";
            $mail->send();

        });
        $dbContext->addDetales($userId, $users->Name, $users->StreetAddress, $users->City, $users->Zipcode);
        header('Location: /thanks.php');
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
                <p>User<strong>&nbsp;REGISTER</strong><?php echo $message ?></p>
                <form method="POST">
                    <input class="input" type="email" placeholder="Enter Your Email" name="username">
                    <span><?php echo $v->get_error_message('username') ?></span>
                    <br />
                    <br />
                    <input class="input" type="password" placeholder="Enter Your Password" name="password">
                    <span><?php echo $v->get_error_message('password') ?></span>
                    <br />
                    <br />
                    <input class="input" type="name" placeholder="Name" name="Name">
                    <span><?php echo $v->get_error_message('Name') ?></span>
                    <br />
                    <br />
                    <input class="input" type="street" placeholder="Street address" name="StreetAddress">
                    <span><?php echo $v->get_error_message('StreetAddress') ?></span>
                    <br />
                    <br />
                    <input class="input" type="postal" placeholder="Postal code" name="Zipcode">
                    <span><?php echo $v->get_error_message('Zipcode') ?></span>
                    <br />
                    <br />
                    <input class="input" type="city" placeholder="City" name="City">
                    <span><?php echo $v->get_error_message('City') ?></span>
                    <br />
                    <br />
                    <button class="newsletter-btn"><i class="fa fa-envelope" href="/thanks.php"></i> Register</button>
                    <span><?php echo $v->get_error_message('') ?></span>
                </form>
            </div>
        </div>
    </div>


</div>


</p>