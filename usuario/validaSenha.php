<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents('php://input'), true);

$cpf = $data['cpf'];
$senha = $data['senha'];

$sql = "SELECT Senha FROM usuario WHERE cpf = '$cpf'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    if ($usuario[0]['Senha'] == $senha) {
        echo json_encode(array('message' => 'Senha valida.'));
    } else {
        echo json_encode(array('message' => 'Senha invalida.'));
    }
} else {
    echo json_encode(array('message' => 'Usuário não encontrado.'));
}
