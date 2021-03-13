<?php

$data = [];
$data['success'] = true;
$data['test']=2;


//header('Content-Type: application/json');
echo json_encode($data);
die;
