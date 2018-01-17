<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';
//require_once '../objects/sql.class.php';
require_once './addTree.php';

class List_Tree {

    private $_dbh;
    private $_elements = array();

    public function get() {
        $usersDB = new usersSql();
  //      $usersDBconn = $usersDB->connect('localhost', 'root', '200306', 'users');
        $usersDBconn = $usersDB->connect(_AURORA_USERS_DATABASE, _AURORA_USERS, _AURORA_USERS_PASSWORD, 'users');

        $query = $usersDB->query('SELECT * FROM permissions');
        $this->_elements["masters"] = $this->_elements["childrens"] = array();
        while ($element = $usersDB->fetch_array($query)) {
            if ($element["parent"] == 0) {
                array_push($this->_elements["masters"], $element);
            } else {
                array_push($this->_elements["childrens"], $element);
            }
        }

//var_dump($query);

        return $this->_elements;
    }

}

$tree = new List_Tree();

$elements = $tree->get();
$b['masters'] = $elements["masters"];
//var_dump($masters);
$b['children'] = $elements["childrens"];
//var_dump($childrens);
//$response['status'] = 'success';
//$response['msg'] = 'Complete';
//$response['data'] = $b;
//var_dump($b['masters']);
foreach ($b['masters'] as $master) {
    $new[] = $master["name"];
    $result1 = Add_Tree::nested($b['children'], $master["ID"]);
    if($result1){
                        $new[]=$result1;
                    }
}

$response['status'] = 'success';
$response['msg'] = 'Complete';
$response['data'] = $new;
die;
//echo "<ul>";
//foreach ($masters as $master) {
//
//    echo '<li style="margin: 5px 0px">';
//    echo "<span><i class='glyphicon glyphicon-folder-open'></i></span>";
//    
//    echo '       style="margin: 5px 6px" class="btn btn-warning btn-xs btn-folder">';
//
//    echo $master["name"] . '</a>';
//    echo Add_Tree::nested($childrens, $master["ID"]);
//    echo "</li>";
//}
//
//echo "</ul>";
