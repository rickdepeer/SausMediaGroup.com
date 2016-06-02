<?php

define("ROOT", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class)
{
    if(file_exists(ROOT.DS.'controllers'.DS.$class.'.php'))
    {
        require_once(ROOT.DS.'controllers'.DS.$class.'.php');
    }
    if(file_exists(ROOT.DS.'models'.DS.$class.'.php'))
    {
        require_once(ROOT.DS.'models'.DS.$class.'.php');
    }
});

$request_uri = explode("/", $_SERVER["REQUEST_URI"]);
$script_name = explode("/", $_SERVER["SCRIPT_NAME"]);

for($i = 0; $i < count($script_name); $i++)
{
    if($request_uri[$i] == $script_name[$i])
    {
        unset($request_uri[$i]);
    }
}

$command = array_values($request_uri);

foreach($command as $index => $value)
{
    if(empty($value))
    {
        unset($command[$index]);
    }
}

//var_dump($command);

$ctrl = new MainController();

if(in_array("home", $command))
{
    $ctrl->home();
}
elseif(in_array("forum", $command))
{
    $ctrl->forum();
}
elseif(empty($command))
{
    $ctrl->home();
}
else
{
    $ctrl->show404();
}