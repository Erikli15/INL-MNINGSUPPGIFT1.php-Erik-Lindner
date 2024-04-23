<?php
require_once ('lib/PageTemplate.php');
require_once ('Database.php');
require_once ('vendor/autoload.php');

$TPL = new PageTemplate();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($TPL->PageTitle)) {
        echo $TPL->PageTitle;
    } ?></title>
</head>

<body>
    <h1>Tack för att du registerde dig hos oss på <?php if (isset($TPL->PageTitle)) {
        echo $TPL->PageTitle;
    } ?></h1>
    <p>Du har fått ett mail, klicka på länken för att varifera dig.</p>
</body>

</html>