<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

try {
  $app = new GT_App();
  $fields = $app->loadBy($_POST['name'], 'name');
  $response['status']='error';
  $response['msg']='Already exists an app with the "' . $_POST['name'] . '" name.';
  die;
} catch(Exception $e) { }

try {
  $fields = $app->loadBy($_POST['api_key'], 'api_key');
  $response['status']='error';
  $response['msg']='Already exists an app with the "' . $_POST['name'] . '" api key.';
  die;
} catch(Exception $e) { }

unset($app);
$app = new GT_App();
$app->set('name', $_POST['name']);
$app->set('api_key', $_POST['api_key']);
$insertId = $app->save();

$response['status']='success';
$response['msg']='Complete';
$response['data'] = $insertId;
die;