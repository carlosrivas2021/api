<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Permission_X_Rol {

    public function permissionxrol($appClientID = '', $rolID = '', $permissionID = '') {
        $finalList = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        if ($appClientID != '') {
            echo $rolID;
            $query = $usersDB->query('select * from permissions where permissions.app in ( select x_apps_clients.appID from x_apps_clients where x_apps_clients.ID="' . $appClientID . '")');
            while ($row = $usersDB->fetch_array($query)) {

                $finalList[] = $row;
                //unset($campos);
            }
        } elseif ($permissionID != '') {
            $query = $usersDB->query('SELECT roleID FROM `x_roles_permissions` where permissionID =' . $permissionID . '');
            while ($row = $usersDB->fetch_array($query)) {

                $finalList[] = $row["roleID"];
                //unset($campos);
            }
        } else {
            $query = $usersDB->query('SELECT permissionID FROM `x_roles_permissions` where roleID =' . $rolID . '');
            while ($row = $usersDB->fetch_array($query)) {

                $finalList[] = $row["permissionID"];
                //unset($campos);
            }
        }


        // var_dump($usersDB->fetch_array($query));

        return $finalList;
    }

    //SELECT userID FROM `x_users_clients` WHERE clientID in (select clientID from x_apps_clients where ID=12);
}

//var_dump($_REQUEST['appClientID']);

$a = new Permission_X_Rol();
if (isset($_REQUEST['roleID'])) {
    $b = $a->permissionxrol('', $_REQUEST['roleID'], '');
} elseif (isset($_REQUEST['permissionID'])) {
    $b = $a->permissionxrol('', '', $_REQUEST['permissionID']);
} else {
    $b = $a->permissionxrol($_REQUEST['appClientID'], '', '');
}

//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;

//select * from permissions where ID in ( select permissionID from x_roles_permissions where roleID in ((SELECT ID FROM `roles` where appClientID=12)))