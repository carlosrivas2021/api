<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class Auth {
    
    public $answer;

    public function Login($user = "carlos", $password = "prueba", $appClientID = "12") {
        $this->answer = "";

        $users = new GT_User();

        try {
            $users->loadBy($user, 'primary_email');
        } catch (Exception $ex) {
            $users->loadBy($user, 'username');
        }
        $pass = new GT_User_Password();
        try {
            $pass->loadBy($users->get('ID'), 'userID');
        } catch (Exception $ex) {
            
        }
        if (password_verify($password, $pass->get('password')) && $appClientID == $pass->get('appClientID')) {
            $this->answer = "success";
        } else {
            $this->answer = "error";
        }

        return $this->answer;
    }

}

$c = new Auth();
$b = $c->Login();

$data[] = array(
    "ans" => $b
        );

//$hash = password_hash("prueba", PASSWORD_BCRYPT);
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
