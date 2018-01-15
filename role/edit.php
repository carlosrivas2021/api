<?php

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Edit_Rol {

    public $roleID;
    public $permissions;

    public function editRol($datos = array()) {

        //var_dump($datos);

        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'roleID':
                    $this->roleID = $value;

                    break;
                case 'permission':
                    $this->permissions = $value;
                    break;
                default:
                    break;
            }
        }
       // var_dump($this->permissions);

        $entro = array();
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        foreach ($this->permissions as $value) {

            $query = $usersDB->query("SELECT * FROM `x_roles_permissions` where roleID=1 and permissionID=$value");
            if ($row = $usersDB->fetch_array($query)) {
                $entro[] = $value;
            }
        }
        //var_dump($entro);
        $resultado = array_diff($this->permissions, $entro);
        //var_dump($resultado);
        if ($resultado) {
            foreach ($resultado as $value) {
                $query = $usersDB->query("INSERT INTO `x_roles_permissions`(`roleID`, `permissionID`) VALUES ($this->roleID,$value)");
            }
        } else {
            $where = "";
            foreach ($entro as $value) {
                if ($where == "") {
                    $where = "permissionID!='" . $value . "'";
                } else {
                    $where = $where . " and permissionID!='" . $value . "'";
                }
            }
            //echo $where;
            $query = $usersDB->query("DELETE FROM `x_roles_permissions` WHERE " . $where . " AND roleID=$this->roleID");
        }
        
        return "ok";
    }

}

//$datos = array("roleID" => 1, "permission" => array( 2, 3));
$a = new Edit_Rol();
$b = $a->editRol($_REQUEST);
////var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;

die;
