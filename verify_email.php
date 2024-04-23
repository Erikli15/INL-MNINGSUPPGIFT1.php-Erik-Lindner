<?php
require_once ('lib/PageTemplate.php');
require_once ('Database.php');
require_once ('vendor/autoload.php');


$dbContext = new Database();

$TPL = new PageTemplate();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (!isset($TPL->PageTitle)) {
        echo $TPL->PageTitle;
    } ?></title>
</head>

<body>
    <h1>
        Tack för att du varifera dig!
    </h1>
</body>

</html>