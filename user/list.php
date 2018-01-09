<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$usersList=array();
$clients = (new GT_User_List())->getList();

foreach($clients as $client)
{
    $usersList[]=array
    (
        'ID'=>$client->get('ID'),
        'first_name'=>$client->get('first_name'),
        'last_name'=>$client->get('last_name')
    );
}

$response['status']='success';
$response['msg']='Complete';
$response['data']=$usersList;
die;