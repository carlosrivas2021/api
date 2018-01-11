<?php

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Auth {

    public $answer;
    public $answerPassword;
    public $answerPermission;

    public function Login($user = "carlos", $password = "prueba", $appClientID = "12") {
        $this->answer = "";

        $users = new GT_User();

        try {
            $users->loadBy($user, 'primary_email');
        } catch (Exception $ex) {
            $users->loadBy($user, 'username');
        }
        $pass = new GT_User_Password($users->get('ID'), 'userID');

        if (password_verify($password, $pass->get('password')) && $appClientID == $pass->get('appClientID')) {
            $this->answerPassword = "success";
        } else {
            $this->answerPassword = "error";
        }
        $rol = new GT_X_User_Role(array($users->get('ID'), $appClientID), array('userID', 'appClientID'));


        $appxclient = new GT_X_App_Client($appClientID, 'ID');
        //var_dump($app);

        $rolxpermission = new GT_X_Role_Permission_List($rol->get('roleID'), 'roleID');
        foreach ($rolxpermission->getList() as $value) {
            $permission = new GT_Permission($value->get('permissionID'));
            if ($permission->get('slug') == 'can_login' && $permission->get('app') == $appxclient->get('appID')) {
                $this->answerPermission = "success";
            } 
        }
        if ($this->answerPassword=="error") {
            $this->answer = "error1";
        } elseif ($this->answerPermission!="success") {
            $this->answer = "error2";
        }else{
            $this->answer = "success";
        }
        //$app== new GT_Permission
        //return $rol;
        return $this->answer;
    }

}

$c = new Auth();
$b = $c->Login();
//var_dump($b);
$data[] = array(
    "result" => $b
        );

//$hash = echo password_hash("prueba", PASSWORD_BCRYPT);
//echo $hash;
//echo "<br>";
//echo "<br>";
//$hash = '$2y$12$pHMobVbl5tXlbhnWtwF72.wMLXeuuhx50atoAgC5bYC/aXGEHfgl2';
//echo "<br>";
//echo "<br>";
//echo $hash;
//echo "<br>";
//echo "<br>";
//var_dump(password_verify('prueba', $hash));
$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $data;
die;
