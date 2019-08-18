<?php

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
                echo json_encode( $books[ $resourceId ] );
            }    
        }
        
        break;
    case 'POST':
        $json = file_get_contents('php://input');
        $books[] = json_decode($json, true);
        //echo array_keys($books)[ count($books) - 1];
        echo json_encode($books);
        break;
    case 'PUT':
        break; 
    default:
        # code...
        break;
}