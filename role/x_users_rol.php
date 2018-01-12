<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class X_Users_Rol {

    public function xusersrol($appClientID) {
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        //var_dump($usersDBconn);
        $query = $usersDB->query("SELECT * FROM `x_users_roles` WHERE appClientID=$appClientID GROUP BY ID,userID");
        while ($row = $usersDB->fetch_array($query)) {
            $id = $row["userID"];
            $user = new GT_User($row["userID"]);
            if ($user->getMeta()) {
                $campos['ID'] = $user->get('ID');
                //  var_dump($campos);
                foreach ($user->getMeta() as $key => $value) {
                    
                        $campos[$key] = $value;

                }
            }
            $finalList[] = $campos;
            unset($campos);
        }
        return $finalList;
    }

}

$a = new X_Users_Rol();
$b = $a->xusersrol($_REQUEST['appClientID']);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
