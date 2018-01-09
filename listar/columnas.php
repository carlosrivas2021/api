<?php

include_once '../config/config.php';

class columnas {

    public $a;

    public function __construct($listas) {
        $clients = (new $listas())->getList();
        //var_dump($clients[1]->getFields());
        //$algo = $clients[1];
//        var_dump($algo->getFields());
//        var_dump($algo->getMeta());
        //var_dump($clients->getMetaIdx());
        //$arreglo = (array) $clients->_fields;
        //var_dump($arreglo);
        foreach ($clients as $client) {
            //var_dump($client->getFields());
            //var_dump($client->getMeta());
            if ($client->getMeta()) {
                foreach ($client->getMeta() as $key => $value) {
                    $campos[$key] = $value;
                }
                //var_dump($campos);
            }
            if ($client->getFields()){
                foreach ($client->getFields() as $value) {
                    $campos[$value] = $client->get($value);  
                }
            }
            //var_dump($campos);
            $clientList[]=$campos;
            unset($campos);
            //var_dump($campos);
            
            
            
            echo "<br><br>";


            //echo "$client ";
        }
        var_dump($clientList);
    }

}

$b = new columnas('GT_User_List');
