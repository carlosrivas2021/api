<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class List_X_User {

    public function listxuser($userID, $appClientID) {
        $pass = new GT_User_Password(array($userID, $appClientID), array('userID', 'appClientID'));
        if ($pass->getFields()) {
            
                $campos['passID'] = $pass->get('ID');
            
        }
        return $campos;
    }

}

$a = new List_X_User();
$b = $a->listxuser($_REQUEST['userID'], $_REQUEST['appClientID']);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
