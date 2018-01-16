<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Permission_X_Rol {

    public function permissionxrol($appClientID, $rolID = '') {
        $finalList = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        if ($rolID == '') {
echo $rolID;
            $query = $usersDB->query('select * from permissions where permissions.app in ( select x_apps_clients.appID from x_apps_clients where x_apps_clients.ID="' . $appClientID . '")');
        } else {
            $query = $usersDB->query('SELECT permissionID FROM `x_roles_permissions` where roleID =' . $rolID . '');
        }

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
if (isset($_REQUEST['roleID'])) {
    $b = $a->permissionxrol('',$_REQUEST['roleID']);
} else {
    $b = $a->permissionxrol($_REQUEST['appClientID'],'');
}

//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;

//select * from permissions where ID in ( select permissionID from x_roles_permissions where roleID in ((SELECT ID FROM `roles` where appClientID=12)))