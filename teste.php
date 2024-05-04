<?php
require_once('database.php');
require_once('index.php');

$response = array(
    'Aluno' => [
        'Derick Lucas Alves Rodrigues',
        'Matheus Antônio Valentin Freitas',
        'Matheus Campos do Amaral',
        'Rodrigo Mota Proton Campos',
        'Vinicius Celio Fontes Ribeiro'
    ],
    'Professor' => 'Luciana Mara Freitas Diniz',
    'Materia' => 'Trabalho Interdiciplinar: Aplicações para Processos de Negócios'
);

echo json_encode($response);

$conn->close();
