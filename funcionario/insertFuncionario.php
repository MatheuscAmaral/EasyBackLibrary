<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$carteira_de_trabalho = $data['carteira_de_trabalho'];
$cargo = $data['cargo'];

$sql = "INSERT INTO funcionario
        (CPF,
        Carteira_de_trabalho,
        Cargo)
        VALUES
        ('$cpf',
        '$carteira_de_trabalho',
        '$cargo')";

if ($conn->query($sql) === TRUE) {
    echo "Funcionario inserido com sucesso!";
} else {
    echo "Erro ao inserir funcionario: " . $conn->error;
}
$conn->close();