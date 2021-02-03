<?php
$loc = filter_input(INPUT_GET, "loc", FILTER_SANITIZE_STRING );
if (!$loc){
  $loc="connection";
}
include('app/config.php');
require_once(PATH_MODEL."database.php");
$database=new Database();
$connection=$database->connect();
// $query->setTable("user");
include (PATH_VIEW.'common/template.php' );