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
        $query = $usersDB->query('SELECT parent FROM `permissions`');
        while ($row = $usersDB->fetch_array($query)) {

            $finalList2[] = $row["parent"];
            //unset($campos);
        }
        
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

$b = new Filtred_Permission();
$result = $b->filtredPermission(2);
var_dump($result);
