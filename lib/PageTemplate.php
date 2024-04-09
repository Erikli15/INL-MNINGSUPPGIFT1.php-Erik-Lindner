<?php
require_once ("Database.php");
#lib/PageTemplate.php
class PageTemplate
{
    public $PageTitle = "Stefans Webshop";
    public $ContentHead;
    public $ContentBody;

    public $Database;

    function __construct()
    {
        $this->Database = new Database();
    }
}