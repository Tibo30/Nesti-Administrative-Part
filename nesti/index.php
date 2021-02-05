<?php
//define('URL', str_replace("index.php","",(isset($_SERVER['HTTPS'])?"https":"http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
session_start();
include('app/config.php');
//include(PATH_VIEW.'common/head.php'); 
$url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING);
// if (!isset($url)){
//     $url="recipe";
// }

//auto loading classes
spl_autoload_register(function ($class) {
    $sources = array(PATH_MODEL . 'dao/' . $class . '.php', PATH_CTRL . $class . '.php ',  PATH_MODEL . 'entities/' . $class . '.php');
    foreach ($sources as $source) {
        if (file_exists($source)) {
            require_once $source;
        }
    }
});

if (!isset($url)) {
    $url = "recipe";
}

//echo "url :".$url." / ";
//echo "index / ";

$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING) .

    $_SESSION["email"] = "tiboJoy@hotmail.fr";
$_SESSION["password"] = "test";
$_SESSION["lastname"] = "Jolivet";
$_SESSION["firstname"] = "Thibault";
//var_dump($_SESSION["email"]);
//var_dump($_SESSION["password"]);
//var_dump($_SESSION["lastname"]);
//var_dump($_SESSION["firstname"]);

if (!isset($_SESSION["email"]) || !isset($_SESSION["password"])) {
    //header('Location:'.PATH_VIEW.'content/connection_content.php');
    $url = "connection";
}

require_once(PATH_MODEL . 'Database.php');
$database = new Database();
$database->setBdd();
$connection = $database->getBdd();
if (isset($connection)) {
    //echo "connection successful";
    //$name=$connection->;
}

require_once(PATH_CONTROLLER . 'Rooter.php');
$rooter = new Rooter();
$rooter->rootReq($url);

//if ($url!="connection"){
extract($rooter->getController()->getData());
$view = $rooter->getController()->getView();
//}


include(PATH_VIEW . 'common/template.php');
