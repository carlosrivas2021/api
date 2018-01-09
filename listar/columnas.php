<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

class columnas {

    public $a;

    public function __construct($listas) {
        $listados = (new $listas())->getList();

        foreach ($listados as $listado) {

            if ($listado->getFields()) {
                foreach ($listado->getFields() as $value) {
                    $campos[$value] = $listado->get($value);
                }
            }
            if ($listado->getMeta()) {
                foreach ($listado->getMeta() as $key => $value) {
                    $campos[$key] = $value;
                }
            }


            $listaFinal[] = $campos;
            unset($campos);
            //var_dump($campos);
            //echo "<br><br>";
            //echo "$client ";
        }

        //return $listaFinal;
        var_dump($listaFinal);
    }

}

$b = new columnas('GT_User_List');
$response['data'] = $b;
