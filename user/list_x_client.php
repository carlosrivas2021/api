<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class List_X_Client {

    public function listxclient($appClientID) {
        $crmDB = new usersSql();
        $crmDBconn = $crmDB->connect(_TOURTRACK_USERS_DATABASE, _TOURTRACK_USERS, _TOURTRACK_USERS_PASSWORD, 'users');
        $query = $crmDB->query('SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID='.$appClientID.')');
        //var_dump();
        while ($row = $crmDB->fetch_array($query)) {
            $user = new GT_User($row['userID']);
            if ($user->getMeta()) {
                $campos['ID'] = $user->get('ID');
                foreach ($user->getMeta() as $key => $value) {
                  
                    $campos[$key] = $value;
                   
                }
                $finalList[] = $campos;
                unset($campos);
            }

            
        }
        return $finalList;
    }

    //SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID=12);
}

$a = new List_X_Client();
$b = $a->listxclient($_REQUEST['appClientID']);
//var_dump($b);
$response['status']='success';
$response['msg']='Complete';
$response['data'] = $b;
die;