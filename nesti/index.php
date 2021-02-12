<?php
//------------------------------------------------Start the session and include needed files----------------------------------//
session_start();
include('app/loader.php');

//-------------------------------------------------------Connection to the database--------------------------------------------//
require_once(PATH_MODEL . 'Database.php');
$database = new Database();
$database->setBdd();
$connection = $database->getBdd();

//---------------------------------------------------Get the url name from the webpage-----------------------------------------//
$url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING);

//------------------------------------------------------The first page is Recipe-------------------------------------------------//
if (!isset($url)) {
    $url = "recipe";
}

$mySession = new Session();

//$mySession->disconnectUser();
//---------------------------------------------------If the user is not connected---------------------------------------------//
if ($mySession->isUserConnected() == false) {
    $url = "connection";
}

//----------------------------------------------------Go to rooter file-------------------------------------------------------//
require_once(PATH_CONTROLLER . 'Rooter.php');
$rooter = new Rooter();
$rooter->rootReq($url);
//---------------------------------------------------Extract the data---------------------------------------------------------//
if (($rooter->getController()->getData())!=null){
    extract($rooter->getController()->getData());
}

//------------------------------------------------Get the specific View file--------------------------------------------------//
$view = $rooter->getController()->getView();
//-------------------------------------------Go to template with this View file defined---------------------------------------//
include(PATH_VIEW . 'common/template.php');
