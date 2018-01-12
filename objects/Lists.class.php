<?php

//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//include_once '../config/config.php';

class Lists {



    public function listing($list, $where = '') {
        $finalList='';
        $k=null;
        if($where == '') {
            $listings = (new $list())->getList();
        }else {
            $listings = (new $list($where[0], $where[1]))->getList();
        }
        

        foreach ($listings as $listing) {

            if ($listing->getFields()) {
                foreach ($listing->getFields() as $value) {
                    $campos[$value] = $listing->get($value);
                }
            }
            if ($listing->getMeta()) {
                foreach ($listing->getMeta() as $key => $value) {

                    $campos['meta'][$key] = $value;
                    
                }

            }


            $finalList[] = $campos;
            unset($campos);
         
        }

        return $finalList;
        
    }

}
//$c= new Lists();
//$b = $c->listing('GT_User_List');
//$response['status']='success';
//$response['msg']='Complete';
//$response['data'] = $b;
//die;