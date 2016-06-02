<?php

/**
 * Created by PhpStorm.
 * User: rick
 * Date: 31-5-2016
 * Time: 17:54
 */
class MainController
{
    public function home()
    {
        require_once("views/templates/header.php");
        require_once("views/home.php");
        require_once("views/templates/footer.php");
    }

    public function forum()
    {
        require_once("views/templates/header.php");
        require_once("views/forum.php");
        require_once("views/templates/footer.php");
    }

    public function show404()
    {
        require_once("views/404.html");
        return true;
    }
}