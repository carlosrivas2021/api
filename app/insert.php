<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

try {
  $app = new GT_App();
  $app->loadBy($_POST['name'], 'name');
  $response['status']='error';
  $response['msg']='Already exists an app with the "' . $_POST['name'] . '" name.';
  die;
} catch(Exception $e) { }

$lengthKey = 32;
do {
  $apiKey = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($lengthKey/strlen($x)) )),1,$lengthKey);
  try {
    $app->loadBy($apiKey, 'api_key');
    $continue = true;
  } catch(Exception $e) { $continue = false; }
} while($continue);

unset($app);
$app = new GT_App();
$app->set('name', $_POST['name']);
$app->set('api_key', $apiKey);
$insertId = $app->save();

$response['status']='success';
$response['msg']='Complete';
$response['data'] = $insertId;
die;