<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];

$sql = "DELETE FROM usuario
        WHERE CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Usuário deletado com sucesso!";
} else {
    echo "Erro ao deletar usuário: " . $conn->error;
}

$conn->close();
