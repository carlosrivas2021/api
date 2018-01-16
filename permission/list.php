
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/config.php';

$c= new Lists();
if (isset($_REQUEST['permissionID'])) {
    $b = $c->listing('GT_Permission_List', array($_REQUEST['permissionID'], 'ID'));
}else{
    $b = $c->listing('GT_Permission_List');
}

//var_dump($b);
$response['status']='success';
$response['msg']='Complete';
$response['data'] = $b;

die;

[
	[
        'id' => 1,
        'nombre' => 'permiso_1',
        'padre' => 0
    ],
    [
        'id' => 2,
        'nombre' => 'permiso_2',
        'padre' => 0
    ],
    [
        'id' => 3,
        'nombre' => 'permiso_3',
        'padre' => 1
    ],
    [
        'id' => 4,
        'nombre' => 'permiso_4',
        'padre' => 1
    ],
    [
        'id' => 5,
        'nombre' => 'permiso_5',
        'padre' => 3
    ],
    [
        'id' => 6,
        'nombre' => 'permiso_6',
        'padre' => 5
    ],
    [
        'id' => 7,
        'nombre' => 'permiso_7',
        'padre' => 2
    ],
    [
        'id' => 8,
        'nombre' => 'permiso_8',
        'padre' => 2
    ],
    [
        'id' => 9,
        'nombre' => 'permiso_9',
        'padre' => 6
    ],
    [
        'id' => 10,
        'nombre' => 'permiso_10',
        'padre' => 3
    ]
];

/**
 * permiso_1
 *   permiso_3
 *     permiso_5
 *       permiso_6
 *         permiso_9
 *     permiso_10
 *   permiso_4
 * permiso_2
 *   permiso_7
 *   permiso_8
 * 
 */