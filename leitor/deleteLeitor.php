<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];

$sql = "DELETE FROM leitor WHERE CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Leitor deletada com sucesso!";
} else {
    echo "Erro ao deletar leitor: " . $conn->error;
}
$conn->close();
