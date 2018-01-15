<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Meta {

    public function metas() {
        $finalList = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        $query = $usersDB->query('SELECT DISTINCT(meta_key) FROM `users_meta`');
        //var_dump($usersDB->fetch_array($query));
        while ($row = $usersDB->fetch_array($query)) {
            
                
                        $finalList[] = $row["meta_key"];
                    
                
            }
            
//        $finalList[] = $campos;
//            unset($campos);
        return $finalList;
    }

    //SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID=12);
}

//var_dump($_REQUEST['appClientID']);
$a = new Meta();
$b = $a->metas();
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
