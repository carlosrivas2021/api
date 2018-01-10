<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

try {
  $group = new GT_Users_Group();
  $fields = $group->loadBy($_POST['name'], 'name');
  $response['status']='error';
  $response['msg']='Already exists a group with the "' . $_POST['name'] . '" name.';
  die;
} catch(Exception $e) { }

unset($group);
$group = new GT_Users_Group();
$group->set('name', $_POST['name']);
$group->set('appClientID', 200);
$insertId = $group->save();

$response['status']='success';
$response['msg']='Complete';
$response['data'] = $insertId;
die;