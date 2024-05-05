<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$carteira_de_trabalho = $data['carteira_de_trabalho'];
$cargo = $data['cargo'];

$sql = "UPDATE funcionario
        SET
        CPF = '$cpf',
        Carteira_de_trabalho = '$carteira_de_trabalho',
        Cargo = '$cargo'
        WHERE CPF = ''";

if ($conn->query($sql) === TRUE) {
    echo "Funcionario atualizado com sucesso!";
} else {
    echo "Erro ao atualizar funcionario: " . $conn->error;
}
$conn->close();
