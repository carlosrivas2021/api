<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class X_User_Rol {

    public function xuserrol($userID, $appClientID) {
        $rol = new GT_X_User_Role(array($userID, $appClientID), array('userID', 'appClientID'));
        return $rol->get('roleID');
    }

}


$a = new X_User_Rol();
$b = $a->xuserrol($_REQUEST['userID'],$_REQUEST['appClientID']);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;