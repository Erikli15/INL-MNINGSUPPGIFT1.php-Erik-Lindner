<?PHP
require_once ("vendor/autoload.php");
require_once ("Database.php");

$dbContext = new Database();

$dbContext->getUserDatabas()->getAuth()->logOut();
header('Location: /');
exit;
