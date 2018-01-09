<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$clientsList=array();
$clients = (new GT_Client_List())->getList();

foreach($clients as $client)
{
    $clientsList[]=array
    (
        'ID'=>$client->get('ID'),
        'first_name'=>$client->get('name')
    );
}

$response['status']='success';
$response['msg']='Complete';
$response['data']=$clientsList;
die;