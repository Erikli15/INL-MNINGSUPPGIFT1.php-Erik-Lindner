<?php
ob_start();
require_once ('vendor/autoload.php');
require_once ('Database.php');
require_once ('Utils/Validator.php');
require_once ('Utils/Mailer.php');

$dbContext = new Database();

try {
    if (isset($_GET['selector']) && !empty($_GET['selector']) && isset($_GET['token']) && !empty($_GET['token'])) {
        echo 'Put the selector into a "hidden" field (or keep it in the URL)';
        echo 'Put the token into a "hidden" field (or keep it in the URL)';

        echo 'Ask the user for their new password';
    }
} catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    die('Invalid token');
} catch (\Delight\Auth\TokenExpiredException $e) {
    die('Token expired');
} catch (\Delight\Auth\ResetDisabledException $e) {
    die('Password reset is disabled');
} catch (\Delight\Auth\TooManyRequestsException $e) {
    die('Too many requests');
}
$auth = $dbContext->getUserDatabas()->getAuth();

if ($auth->canResetPassword($_GET['selector'], $_GET['token'])) {
    echo 'Put the selector into a "hidden" field (or keep it in the URL)';
    echo 'Put the token into a "hidden" field (or keep it in the URL)';

    echo 'Ask the user for their new password';
}
if (isset($_POST['password']) && !empty($_POST['password'])) {

    try {
        $auth = $dbContext->getUserDatabas()->getAuth();

        $auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);

        echo 'Password has been reset';
    } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
        die('Invalid token');
    } catch (\Delight\Auth\TokenExpiredException $e) {
        die('Token expired');
    } catch (\Delight\Auth\ResetDisabledException $e) {
        die('Password reset is disabled');
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Invalid password');
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
}

?>


<form method="post">
    <input type="hidden" name="selector" value="<?php echo $_GET['selector']; ?>">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <input type="password" name="password" placeholder="New password">
    <br>
    <input type="submit" name="submit" value="Update password">
</form>