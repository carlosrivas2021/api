<?php

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//include_once '../config/config.php';
require_once '../objects/sql.class.php';
require_once './addTree.php';

class List_Tree {

    private $_dbh;
    private $_elements = array();

    public function get() {
        $usersDB = new usersSql();
        $usersDBconn = $usersDB->connect('localhost', 'root', '200306', 'users');

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

//    public static function nested($rows = array(), $parent_id = 0) {
//        $html = "";
//        if (!empty($rows)) {
//            $html .= "<ul>";
//            foreach ($rows as $row) {
//                if ($row["parent"] == $parent_id) {
//                    $html .= "<li style='margin:5px 0px'>";
//                    $html .= "<span><i class='glyphicon glyphicon-folder-open'></i></span>";
//                    $html .= "<a href='#' style='margin: 5px 6px' class='btn btn-warning btn-xs btn-folder'>";
//
//                    $html .= "<span class='glyphicon glyphicon-plus-sign'></span>" . $row['name'] . "</a>";
//
//                    $html .= self::nested($rows, $row["ID"]);
//                    $html .= "</li>";
//                }
//            }
//            $html .= "</ul>";
//        }
//        return $html;
//    }

}

$tree = new List_Tree();

$elements = $tree->get();
$masters = $elements["masters"];
//var_dump($masters);
$childrens = $elements["childrens"];
//var_dump($childrens);
echo "<ul>";
foreach ($masters as $master) {

    echo '<li style="margin: 5px 0px">';
    echo "<span><i class='glyphicon glyphicon-folder-open'></i></span>";
    echo '<a href="#" data-status="' . $master["have_childrens"];
    echo '       style="margin: 5px 6px" class="btn btn-warning btn-xs btn-folder">';

    echo $master["name"] . '</a>';
    echo Add_Tree::nested($childrens, $master["ID"]);
    echo "</li>";
}

echo "</ul>";
