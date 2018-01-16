
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$c= new Lists();
if (isset($_REQUEST['appClientID'])) {
    $b = $c->listing('GT_Permission_List', array($_REQUEST['appClientID'], 'app'));
} elseif (isset($_REQUEST['rolID'])) {
    $b = $c->listing('GT_Permission_List', array($_REQUEST['PermissionID'], 'ID'));
}else{
    $b = $c->listing('GT_Permission_List');
}

//var_dump($b);
$response['status']='success';
$response['msg']='Complete';
$response['data'] = $b;

die;