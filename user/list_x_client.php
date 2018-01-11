<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class List_X_Client {

    public function listxclient($appClientID) {
        $finalList = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        $query = $usersDB->query('SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from `x_apps_clients` where ID="' . $appClientID . '")');
        //var_dump($usersDB->fetch_array($query));
        while ($row = $usersDB->fetch_array($query)) {
            $user = new GT_User($row['userID']);
            if ($user->getMeta()) {
                $campos['ID'] = $user->get('ID');
                foreach ($user->getMeta() as $key => $value) {
                    if ($key == "first_name") {
                        $campos[$key] = $value;
                    }
                    if ($key == "last_name") {
                        $campos[$key] = $value;
                    }
                }
            }
            $finalList[] = $campos;
            unset($campos);
        }
        return $finalList;
    }

    //SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID=12);
}

//var_dump($_REQUEST['appClientID']);
$a = new List_X_Client();
$b = $a->listxclient($_REQUEST['appClientID']);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
