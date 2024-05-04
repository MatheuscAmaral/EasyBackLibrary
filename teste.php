<?php
require_once('database.php');
require_once('index.php');

$response = array(
    'message' => 'Este é um exemplo de resposta do PHP.',
    'data' => array(
        'foo' => 'bar'
    )
);

echo json_encode($response);

$conn->close();
