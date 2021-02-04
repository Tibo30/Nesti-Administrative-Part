<?php
//define('URL', str_replace("index.php","",(isset($_SERVER['HTTPS'])?"https":"http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
session_start();

$url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING );

include('app/config.php');

// if(!(isset($_SESSION['login']) && $_SESSION['login']!="")){
//     //header('Location:'.PATH_VIEW.'content/connection_content.php');
//     $url="connection";
// }

require_once(PATH_MODEL.'Database.php');
$database=new Database();
$connection=$database->getBdd();
if(isset($connection)){
    echo "connection successful";
}

require_once(PATH_CONTROLLER.'Rooter.php');
$rooter = new Rooter();
$rooter->rootReq($url);

//if ($url!="connection"){
    extract($rooter->getController()->getData());
    $view=$rooter->getController()->getView();
//}


include (PATH_VIEW.'common/template.php');
