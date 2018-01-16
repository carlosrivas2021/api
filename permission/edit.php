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
                default:
                    break;
            }
        }
        
        if ($this->id) 
        {
 
           $usersDB = new usersSql();
           $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');

           $query = $usersDB->query("SELECT ID FROM permissions WHERE ID ='".$this->id."'");
            if ($row = $usersDB->fetch_array($query)) 
            {


         $query = $usersDB->query("UPDATE `permissions` SET `slug`='" .$this->slug . "',`name`='" .$this->name . "' ,`parent`='" .$this->parent . "',`root`='" . $this->root . "',`app`='" .$this->app . "', `description`='" . $this->description . "' WHERE ID ='".$this->id."'");


            return  "Updated record" ; 

            } else {

            return  "Record not found" ;           
            
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