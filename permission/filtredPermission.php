<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Filtred_Permission {

    public function filtredPermission($rolID) {
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');


        $query = $usersDB->query('SELECT permissionID FROM `x_roles_permissions` where roleID =' . $rolID . '');
        while ($row = $usersDB->fetch_array($query)) {

            $finalList[] = $row["permissionID"];
            //unset($campos);
        }
//        var_dump($finalList);
        $query = $usersDB->query('SELECT parent FROM `permissions` where id in( SELECT permissionID FROM `x_roles_permissions` where roleID =' . $rolID . ')');
        while ($row = $usersDB->fetch_array($query)) {

            $finalList2[] = $row["parent"];
            //unset($campos);
        }
//        var_dump($finalList2);
        
        foreach ($finalList2 as $value) {
            foreach ($finalList as $key => $value2) {
                if ($value==$value2) {
                    unset($finalList[$key]);
                }
            }
        }
        
        
        return $finalList;
    }

}

$a = new Filtred_Permission();
$b = $a->filtredPermission($_REQUEST['roleID']);
//var_dump($result);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;