<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Insert_Permission {

    public $id;
    public $slug;
    public $name;
    public $parent;
    public $root;
    public $app;
    public $description;
    public $appClientID;
    public $roles = 0;

    public function inserpermission($datos = array()) {
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
                case 'appClientID':
                    $this->appClientID = $value;
                    break;
                case 'roles':
                    $this->roles = $value;
                default:
                    break;
            }
        }




        if ($this->name) {
            if ($this->appClientID) {
                $usersDB = new usersSql();
                $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
                $query = $usersDB->query("SELECT pms.ID as ID FROM permissions as pms Inner Join x_apps_clients  as xac on  xac.appID=pms.app where xac.ID='" . $this->appClientID . "' and name='" . $this->name . "'");

                if ($row = $usersDB->fetch_array($query)) {
                    return "Record found";
                } else {
                    $query = $usersDB->query("SELECT appID FROM x_apps_clients WHERE ID=$this->appClientID");

                    if ($row = $usersDB->fetch_array($query)) {
                        $this->app = $row["appID"];
                        $query = $usersDB->query("INSERT INTO `permissions`(`slug`, `name`, `parent`, `root`, `app`, `description`) VALUES ('" . $this->slug . "','" . $this->name . "','" . $this->parent . "','" . $this->root . "','" . $this->app . "','" . $this->description . "')");
                        $this->id = $usersDB->insert_id();
                        if ($this->roles != 0) {
                            $entro = array();
                            foreach ($this->roles as $value) {
                                $query = $usersDB->query("SELECT ID FROM x_roles_permissions WHERE roleID ='" . $value . "' AND permissionID ='" . $this->id . "'");
                                if ($row = $usersDB->fetch_array($query)) {
                                    $entro[] = $value;
                                }
                            }

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
                        }
                    }

                    return "Record created";
                }
            } else {
                return "Falta parametro appClientID";
            }
        } else {
            return "Falta parametro name";
        }
    }

}

$a = new Insert_Permission();
$b = $a->inserpermission($_REQUEST);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
