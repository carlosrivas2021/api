<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Edit_Permission {

    public $id;
    public $slug;
    public $name;
    public $parent;
    public $root;
    public $app;
    public $description;
    public $roles = 0;

    public function editpermission($datos = array()) {
        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'id':
                    $this->id = $value;
                    break;
                case 'slug':
                    $this->slug = $value;
                    break;
                case 'name':
                    $this->name = $value;
                    break;
                case 'parent':
                    $this->parent = $value;
                    break;
                case 'root':
                    $this->root = $value;
                    break;
                case 'app':
                    $this->app = $value;
                    break;
                case 'description':
                    $this->description = $value;
                    break;
                case 'roles':
                    $this->roles = $value;
                default:
                    break;
            }
        }

        if ($this->id) {

            $usersDB = new usersSql();
            $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');

            $query = $usersDB->query("SELECT ID FROM permissions WHERE ID ='" . $this->id . "'");
            if ($row = $usersDB->fetch_array($query)) {
                $query = $usersDB->query("SELECT ID FROM permissions WHERE name='" . $this->name . "' AND ID!='" . $this->id . "'");

                if ($row = $usersDB->fetch_array($query)) {
                    return "Record found";
                } else {

                    $query = $usersDB->query("UPDATE `permissions` SET `slug`='" . $this->slug . "',`name`='" . $this->name . "' ,`parent`='" . $this->parent . "',`root`='" . $this->root . "', `description`='" . $this->description . "' WHERE ID ='" . $this->id . "'");
                    $entro = array();
                    foreach ($this->roles as $value) {
                        $query = $usersDB->query("SELECT ID FROM x_roles_permissions WHERE roleID ='" . $value . "' AND permissionID ='" . $this->id . "'");
                        if ($row = $usersDB->fetch_array($query)) {
                            $entro[] = $value;
                        }
                    }
                    if ($this->roles != 0) {
                        $resultado = array_diff($this->roles, $entro);
                        //var_dump($resultado);
                        if ($resultado) {
                            foreach ($resultado as $value) {
                                $query = $usersDB->query("INSERT INTO `x_roles_permissions`(`roleID`, `permissionID`) VALUES ($value,$this->id)");
                            }
                        } else {
                            $where = "";
                            foreach ($entro as $value) {
                                if ($where == "") {
                                    $where = "roleID!='" . $value . "'";
                                } else {
                                    $where = $where . " and roleID!='" . $value . "'";
                                }
                            }
                            //echo $where;
                            $query = $usersDB->query("DELETE FROM `x_roles_permissions` WHERE " . $where . " AND permissionID=$this->id");
                        }
                    } else {

                        $query = $usersDB->query("DELETE FROM `x_roles_permissions` WHERE permissionID=$this->id");
                    }
                }

                return "Updated record";
            } else {

                return "Record not found";
            }
        }
    }

}

$a = new Edit_Permission();
$b = $a->editpermission($_REQUEST);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
