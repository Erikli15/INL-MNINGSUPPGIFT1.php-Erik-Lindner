<?php
require_once ('vendor/autoload.php');
require_once ('Database.php');
require_once ('Utils/Validator.php');
require_once ('Utils/Mailer.php');

if (!isset($_GET['code'])) {
    exit("can't find the page");
}

$host = "localhost";
$user = "root";
$pass = "root";
$db = "stefanssupershopuserdb";

$con = new mysqli($host, $user, $pass, $db);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$code = $_GET['code'];
$getCodequery = mysqli_query($con, "SELECT * FROM resetPasswords WHERE code = '$code'");
if (mysqli_num_rows($getCodequery) == 0) {
    exit("can't find the page because not same code");
}

// handling the form 
if (isset($_POST['password'])) {
    $pw = $_POST['password'];
    $pw = md5($pw); // not the best option but for demo simpilicity
    $row = mysqli_fetch_array($getCodequery);
    $email = $row['username'];
    $query = mysqli_query($con, "UPDATE users SET password = '$pw' WHERE username = '$email'");

    if ($query) {
        $query = mysqli_query($con, "DELETE FROM resetPasswords WHERE code ='$code'");
        exit('Password updated');
    } else {
        exit('Something went wrong :(');
    }
}


?>


<form method="post">
    <input type="password" name="password" placeholder="New password">
    <br>
    <input type="submit" name="submit" value="Update password">
</form>