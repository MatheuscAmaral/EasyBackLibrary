<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$nome = $data['nome'];
$endereco = $data['endereco'];
$telefone = $data['telefone'];
$email = $data['email'];

$sql = "UPDATE usuario
        SET
            Nome = '$nome'>,
            Endereco = '$endereco'>,
            Telefone = '$telefone'>,
            Email = '$email'>
        WHERE CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Usuário atualizado com sucesso!";
} else {
    echo "Erro ao atualizar usuário: " . $conn->error;
}

$conn->close();
