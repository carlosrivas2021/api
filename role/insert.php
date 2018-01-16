<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Insert_Rol {

    public $roleID;
    public $roleName;
    public $permissions = 0;
    public $appClient;
    public $descripcion;

    public function insertRol($datos = array()) {

        //var_dump($datos);

        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'roleID':
                    $this->roleID = $value;

                    break;
                case 'permission':
                    $this->permissions = $value;
                    break;
                case 'roleName':
                    $this->roleName = $value;
                    break;
                case 'appClientID':
                    $this->appClient = $value;
                    break;
                case 'descripcion':
                    $this->descripcion = $value;
                    break;
                default:
                    break;
            }
        }
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
        $query = $usersDB->query('SELECT * FROM roles WHERE  name="' . $this->roleName . '" AND appClientID="' . $this->appClient . '"');
        if ($row = $usersDB->fetch_array($query)) {
            return "Rol exist";
        } else {


            $createRol->set('name', $this->roleName);
            $createRol->set('appClientID', $this->appClient);
            $createRol->set('description', $this->descripcion);
            $this->roleID = $createRol->save();
            // echo $this->roleID;
            // var_dump($this->permissions);
            if ($this->permissions == 0) {
                $query = $usersDB->query("DELETE FROM `x_roles_permissions` WHERE roleID=$this->roleID");
            } else {
                $entro = array();
                foreach ($this->permissions as $value) {

                    $query = $usersDB->query("SELECT * FROM `x_roles_permissions` where roleID=$this->roleID and permissionID=$value");
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
            }


            return "ok";
        }
    }

}

//$datos = array("roleName" => "Nuevo Rol", "descripcion" => "Nueva descripcion", "appClientID" => 12, "permission" => array(1));
$a = new Insert_Rol();
$b = $a->insertRol($_REQUEST);
////var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;

die;
