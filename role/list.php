<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$c= new Lists();
$b = $c->listing('GT_Role_List', array($_REQUEST['appClientID'], 'appClientID'));
//var_dump($b);
$response['status']='success';
$response['msg']='Complete';
$response['data'] = $b;

die;