<?php
require_once ('lib/PageTemplate.php');
require_once ("Database.php");

$dbContext = new Database();
$message = "";
$username = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Hejsan123#
    try {
        $dbContext->getUserDatabas()->getAuth()
            ->login($username, $password);
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $message = "Could not login";

    }
}
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
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
                <p>User<strong>&nbsp;LOGIN</strong></p>
                <form method="POST">
                    <input class="input" type="email" placeholder="Enter Your Email" name="username">
                    <br />
                    <br />
                    <input class="input" type="password" placeholder="Enter Your Password" name="password"
                        value="<?php echo $username ?>">
                    <br />
                    <br />
                    <button class="newsletter-btn"><i class="fa fa-envelope"></i> Login</button>
                </form>
                <a href="">Lost password?</a>
            </div>
        </div>
    </div>


</div>


</p>