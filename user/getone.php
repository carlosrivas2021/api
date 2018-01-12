<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$c = new GetOne();
if (substr_count($_REQUEST['username'], '@') == 1) {
    $b = $c->get_one('GT_User', $_REQUEST['username'], 'primary_email');
} else {
    $b = $c->get_one('GT_User', $_REQUEST['username'], 'username');
}

//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
