<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

try {
  $client = new GT_Client();
  $fields = $client->loadBy($_POST['name'], 'name');
  $response['status']='error';
  $response['msg']='Already exists a client with the "' . $_POST['name'] . '" name.';
  die;
} catch(Exception $e) { }

unset($client);
$client = new GT_Client();
$client->set('name', $_POST['name']);
$insertId = $client->save();

$response['status']='success';
$response['msg']='Complete';
$response['data'] = $insertId;
die;