<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Permission_X_Rol {

    public function permissionxrol($appClientID) {
        $finalList = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        $query = $usersDB->query('select * from permissions where ID in ( select permissionID from x_roles_permissions where roleID in ((SELECT ID FROM `roles` where appClientID="'.$appClientID.'")))');
       // var_dump($usersDB->fetch_array($query));
        while ($row = $usersDB->fetch_array($query)) {
                               
            $finalList[] = $row;
            //unset($campos);
        }
        return $finalList;
    }

    //SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID=12);
}

//var_dump($_REQUEST['appClientID']);
$a = new Permission_X_Rol();
$b = $a->permissionxrol($_REQUEST['appClientID']);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;

//select * from permissions where ID in ( select permissionID from x_roles_permissions where roleID in ((SELECT ID FROM `roles` where appClientID=12)))