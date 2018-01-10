<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

try {
  $app = new GT_User();
  $fields = $app->loadBy($_POST['username'], 'username');
  $response['status']='error';
  $response['msg']='Already exists an user with the "' . $_POST['username'] . '" username.';
  die;
} catch(Exception $e) { }

try {
  $fields = $app->loadBy($_POST['primary_email'], 'primary_email');
  $response['status']='error';
  $response['msg']='Already exists an user with the "' . $_POST['primary_email'] . '" email.';
  die;
} catch(Exception $e) { }

// unset($app);
// $app = new GT_App();
// $app->set('name', $_POST['name']);
// $app->set('api_key', $_POST['api_key']);
// $insertId = $app->save();

$response['status']='success';
$response['msg']='Complete';
// $response['data'] = $insertId;
die;