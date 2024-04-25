<?php
require_once ("userDatabase.php");
require_once ("userDitales.php");
class Database
{

    private $pdo;
    private $userDatabas;

    function getUserDatabas()
    {
        return $this->userDatabas;
    }
    function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->userDatabas = new userDatabas($this->pdo);
        $this->ifTabletNotExist();
    }

    function addDetales($userId, $Name, $StreetAddress, $City, $Zipcode)
    {
        $prep = $this->pdo->prepare(
            "INSERT INTO userDitales(userId, Name, StreetAddress, City, Zipcode) VALUES(:userId, :Name, :StreetAddress, :City, :Zipcode)"
        );
        $prep->execute(["userId" => $userId, "Name" => $Name, "StreetAddress" => $StreetAddress, "City" => $City, "Zipcode" => $Zipcode]);
        return $this->pdo->lastInsertId();
    }
    function ifTabletNotExist()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `userDitales` (
                `Id` INT AUTO_INCREMENT NOT NULL,
                `userId` INT  NOT NULL,
                `Name` varchar (50) NOT NULL,
                `StreetAddress` varchar(50) NOT NULL,
                `City` varchar(50) NOT NULL,
                `Zipcode` varchar(10) NOT NULL,
                PRIMARY KEY (`id`)
                ) ";

        $this->pdo->exec($sql);

        $this->userDatabas->setUpUser();
        $this->userDatabas->seedUser();

        $initialized = true;
    }

}
