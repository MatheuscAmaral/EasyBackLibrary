<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];

$sql = "DELETE FROM funcionario
        WHERE CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Funcionario deletada com sucesso!";
} else {
    echo "Erro ao deletar funcionario: " . $conn->error;
}
$conn->close();
