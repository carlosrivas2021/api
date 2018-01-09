<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$clientsList=array();
$users = (new GT_Client_List())->getList();

foreach($users as $user)
{
    $clientsList[]=array
    (
        'ID'=>$user->get('ID'),
        'first_name'=>$user->get('name')
    );
}

$response['status']='success';
$response['msg']='Complete';
$response['data']=$clientsList;
die;