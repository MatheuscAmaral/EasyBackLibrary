<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$nome = $data['nome'];
$endereco = $data['endereco'];
$telefone = $data['telefone'];
$email = $data['email'];

$sql = "INSERT INTO usuario (CPF, Nome, Endereco, Telefone, Email) 
        VALUES ('$cpf', '$nome', '$endereco', '$telefone', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro ao inserir usuário: " . $conn->error;
}

$conn->close();
