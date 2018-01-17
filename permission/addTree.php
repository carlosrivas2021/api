<?php

class Add_Tree {

    
//    public $resul="";
    public static function nested($rows = array(), $parent_id = 0) {
//        $html = "";
        $result = array();
        if (!empty($rows)) {
//            $html .= "<ul>";
            foreach ($rows as $row) {
                if ($row["parent"] == $parent_id) {
//                    $html .= "<li style='margin:5px 0px'>";
//                    $html .= "<span><i class='glyphicon glyphicon-folder-open'></i></span>";
//                    $html .= "<a href='#' style='margin: 5px 6px' class='btn btn-warning btn-xs btn-folder'>";
//
//                    $html .= "<span class='glyphicon glyphicon-plus-sign'></span>" . $row['name'] . "</a>";
                    $result[] = $row['name'];
                    $result1 = self::nested($rows, $row["ID"]);
                    if($result1){
                        $result[] =$result1;
                    }
//                    $html .= "</li>";
                }
            }
//            $html .= "</ul>";
        }

        return $result;
    }

}
