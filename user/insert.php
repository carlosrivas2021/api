<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Insert_User {

    public $userID;
    public $appClient;
    public $meta;
    public $roleID;
    public $password;
    public $passwordID;
    public $email;

    public function insertuser($datos = array()) {
        foreach ($datos as $key => $value) {
            switch ($key) {
                case 'userID':
                    $this->userID = $value;

                    break;
                case 'appClient':
                    $this->appClient = $value;
                    break;
                case 'meta':
                    $this->meta = $value;
                    break;
                case 'password':
                    $this->password = $value;
                    break;
                case 'roleID':
                    $this->roleID = $value;
                    break;
                case 'email':
                    $this->email = $value;
                    break;
                default:
                    break;
            }
        }
        //Verificar si el 
        if ($this->userID) {
            try {
                $user = new GT_User($this->userID);
                if ($this->userID == $user->get('ID')) {
                    //
                    //Crear los nuevos meta
                    $usersDB = new usersSql();
                    $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
                    //Crear los meta si no existen
                    foreach ($this->meta as $value) {
                        foreach ($value as $key => $valuem) {


                            //var_dump($usersDBconn);
                            $query = $usersDB->query("SELECT meta_key FROM users_meta WHERE meta_key='" . $key . "' limit 1");
                            //$row = $usersDB->fetch_array($query);
                            // var_dump($row);
                            if ($row = $usersDB->fetch_array($query)) {
                                //echo "Entro";
                            } else {
                                $c = new Lists();
                                $b = $c->listing('GT_User_List');
                                foreach ($b as $value1) {
                                    $id = $value1['ID'];
                                    //Activar
                                    $query = $usersDB->query("INSERT INTO `users_meta`(`userID`, `meta_key`, `meta_value`, `editor`) VALUES ($id,'" . $key . "','','2') ");
                                }
                            }
                        }
                    }
                    //Verificar si existe el pass
                    //Si existe lo modifica
                    //Sino lo crea
                    //Siempre y cuando el pass traiga algo
                    if ($this->password) {
//            $hash = $this->password;
                        $hash = password_hash($this->password, PASSWORD_BCRYPT);
                        $query = $usersDB->query("SELECT ID FROM users_password WHERE appClientID = " . $this->appClient . " AND userID= " . $this->userID . "");
                        if ($row1 = $usersDB->fetch_array($query)) {
                            $this->passwordID = $row1['ID'];
                            //echo $this->passwordID;
                            $query = $usersDB->query("UPDATE `users_password` SET `password`='" . $hash . "', `updated_at`='' WHERE ID=$this->passwordID");
                        } else {
                            $query = $usersDB->query("INSERT INTO `users_password`(`userID`, `password`, `appClientID`, `updated_at`) VALUES ($this->userID,'" . $hash . "',$this->appClient,'')");
                        }

//                        //echo $this->passwordID;
//
//                        $mail = "Su nueva contraseña es : " . $this->password;
////Titulo
//                        $titulo = "Actualización de contraseña";
////cabecera
//                        $headers = "MIME-Version: 1.0\r\n";
//                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
////dirección del remitente 
//                        $headers .= "From: globaltech < globaltech@globaltech.com >\r\n";
////Enviamos el mensaje a tu_dirección_email 
//                        $bool = mail("ingcarlosrivas20@gmail.com", $titulo, $mail, $headers);
                    }
                    //Asignar el usuario a un cliente
                    $xuserclient = new GT_X_App_Client($this->appClient);
                    $clientID = $xuserclient->get('clientID');


                    $query = $usersDB->query("SELECT ID FROM `x_users_clients` WHERE userID=$this->userID and clientID=$clientID");
                    if ($row2 = $usersDB->fetch_array($query)) {
                        
                    } else {
                        $query = $usersDB->query("INSERT INTO `x_users_clients`(`userID`, `clientID`, `groupID`) VALUES (" . $this->userID . "," . $clientID . ",'')");
                    }



                    //Verificar rol
                    //Si existe el rol lo cambia
                    //Si no existe lo crea
                    $query = $usersDB->query("SELECT ID,roleID FROM `x_users_roles` WHERE userID=$this->userID and appClientID=$this->appClient");
                    if ($row2 = $usersDB->fetch_array($query)) {
                        if ($this->roleID != $row2['roleID']) {
                            $idxrol = $row2['ID'];
                            $query = $usersDB->query("UPDATE `x_users_roles` SET `roleID`=$this->roleID WHERE ID=$idxrol");
                        }
                    } else {
                        $query = $usersDB->query("INSERT INTO `x_users_roles`(`userID`, `roleID`, `appClientID`) VALUES ($this->userID,$this->roleID,$this->appClient)");
                    }

                    //Actualizar los meta
                    foreach ($this->meta as $value) {
                        foreach ($value as $key => $valuem) {


                            $query = $usersDB->query("SELECT ID FROM users_meta WHERE meta_key='" . $key . "' AND userID=$this->userID limit 1");
                            if ($row3 = $usersDB->fetch_array($query)) {
                                $idxmeta = $row3['ID'];
                                $query = $usersDB->query("UPDATE `users_meta` SET `meta_key`='" . $key . "',`meta_value`='" . $valuem . "',`editor`='',`created`='' WHERE ID=$idxmeta");
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                
            }
        } else {
            //Si no existe el usuario lo crea
            $createUser = new GT_User();
            $createUser->set('username', $this->email);
            $createUser->set('password', $this->email);
            $createUser->set('primary_email', $this->email);
            $this->userID = $createUser->save();

            try {
                $user = new GT_User($this->userID);
                if ($this->userID == $user->get('ID')) {
                    //
                    //Crear los nuevos meta
                    $usersDB = new usersSql();
                    $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');
                    //Crear los meta si no existen
                    foreach ($this->meta as $value) {
                        foreach ($value as $key => $valuem) {


                            //var_dump($usersDBconn);
                            $query = $usersDB->query("SELECT meta_key FROM users_meta WHERE meta_key='" . $key . "' limit 1");
                            //$row = $usersDB->fetch_array($query);
                            // var_dump($row);
                            if ($row = $usersDB->fetch_array($query)) {
                                $query = $usersDB->query("INSERT INTO `users_meta`(`userID`, `meta_key`, `meta_value`, `editor`) VALUES ($this->userID,'" . $key . "','','2') ");
                            } else {
                                $c = new Lists();
                                $b = $c->listing('GT_User_List');
                                foreach ($b as $value1) {
                                    $id = $value1['ID'];
                                    //Activar
                                    $query = $usersDB->query("INSERT INTO `users_meta`(`userID`, `meta_key`, `meta_value`, `editor`) VALUES ($id,'" . $key . "','','2') ");
                                }
                            }
                        }
                    }
                    //Verificar si existe el pass
                    //Si existe lo modifica
                    //Sino lo crea
                    //Siempre y cuando el pass traiga algo
                    if ($this->password) {
//            $hash = $this->password;
                        $hash = password_hash($this->password, PASSWORD_BCRYPT);
                        $query = $usersDB->query("SELECT ID FROM users_password WHERE appClientID = " . $this->appClient . " AND userID= " . $this->userID . "");
                        if ($row1 = $usersDB->fetch_array($query)) {
                            $this->passwordID = $row1['ID'];
                            //echo $this->passwordID;
                            $query = $usersDB->query("UPDATE `users_password` SET `password`='" . $hash . "', `updated_at`='' WHERE ID=$this->passwordID");
                        } else {
                            $query = $usersDB->query("INSERT INTO `users_password`(`userID`, `password`, `appClientID`, `updated_at`) VALUES ($this->userID,'" . $hash . "',$this->appClient,'')");
                        }
                    }
                    //Verificar rol
                    //Si existe el rol lo cambia
                    //Si no existe lo crea
                    $query = $usersDB->query("SELECT ID,roleID FROM `x_users_roles` WHERE userID=$this->userID and appClientID=$this->appClient");
                    if ($row2 = $usersDB->fetch_array($query)) {
                        if ($this->roleID != $row2['roleID']) {
                            $idxrol = $row2['ID'];
                            $query = $usersDB->query("UPDATE `x_users_roles` SET `roleID`=$this->roleID WHERE ID=$idxrol");
                        }
                    } else {
                        $query = $usersDB->query("INSERT INTO `x_users_roles`(`userID`, `roleID`, `appClientID`) VALUES ($this->userID,$this->roleID,$this->appClient)");
                    }


                    //Asignar el usuario a un cliente
                    $xuserclient = new GT_X_App_Client($this->appClient);
                    $clientID = $xuserclient->get('clientID');
                    $query = $usersDB->query("INSERT INTO `x_users_clients`(`userID`, `clientID`, `groupID`) VALUES (" . $this->userID . "," . $clientID . ",'')");
                    //Actualizar los meta
                    foreach ($this->meta as $value) {
                        foreach ($value as $key => $valuem) {


                            $query = $usersDB->query("SELECT ID FROM users_meta WHERE meta_key='" . $key . "' AND userID=$this->userID limit 1");
                            if ($row3 = $usersDB->fetch_array($query)) {
                                $idxmeta = $row3['ID'];
                                $query = $usersDB->query("UPDATE `users_meta` SET `meta_key`='" . $key . "',`meta_value`='" . $valuem . "',`editor`='',`created`='' WHERE ID=$idxmeta");
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                
            }
        }




        return "Create";
    }

}

//$envio = array(appClient => 12, meta => array(first_name => Carlosss, last_name => Rivass, prueba => ''), password => 'prueba', roleID => 1, email => 'a@a.com');
$a = new Insert_User();
$b = $a->insertuser($_REQUEST);
//var_dump($b);
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $b;
die;
