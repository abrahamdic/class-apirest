<?php
if ( !array_key_exists('HTTP_X_TOKEN', $_SERVER) ) {
    http_response_code( 400 );
    die;
}

$url = 'http://localhost:8001';
$ch = curl_init( $url );
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        "X-Token: {$_SERVER['HTTP_X_TOKEN']}"
        ]
    );
    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        true
    );
    
$res = curl_exec( $ch );

if ( $res !== 'true' ) {
    die;
}

$allowResourceTypes = [
    'books',
    'authors',
    'genders'
];

$resourcetType = $_GET['resource_type'];

if ( !in_array($resourcetType, $allowResourceTypes)) {
    die;
}

// definir los recursos
$books = [
        1 => [
            'titulo' => 'Lo que el viento se llevo',
            'id_autor' => 2,
            'id_genero' => 2
        ],
        2 => [
            'titulo' => 'La Iliada',
            'id_autor' => 1,
            'id_genero' => 1
        ],
        3 => [
            'titulo' => 'La Odisea',
            'id_autor' => 1,
            'id_genero' => 1
        ]
    ];

// Obtenemos el resource_id
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

header( 'Content-Type: application/json' );

switch ( strtoupper($_SERVER['REQUEST_METHOD']) ) {
    case 'GET':
        if ( empty( $resourceId ) ) {
            echo json_encode($books);
        } else {
            if ( array_key_exists($resourceId, $books) ) {
                echo json_encode( $books[ $resourceId ] ) . PHP_EOL;
            }
        }
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $books[] = json_decode($json, true);
        //echo array_keys($books)[ count($books) - 1];
        echo json_encode($books) . PHP_EOL ;
        break;
    case 'PUT':
        if ( !empty($resourceId) && array_key_exists( $resourceId, $books ) ) {
            $json = file_get_contents('php://input');
            $books[ $resourceId ] = json_decode( $json, true );
            echo json_encode($books) . PHP_EOL;
        }
        break;
    case 'DELETE':
        if ( !empty($resourceId) && array_key_exists( $resourceId, $books ) ) {
            unset($books[ $resourceId ]);
            echo json_encode( $books ) . PHP_EOL;
        }
        
    default:
        # code...
        break;
}