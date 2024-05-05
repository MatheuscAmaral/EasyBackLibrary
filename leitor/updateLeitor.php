<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$multa = $data['multa'];

$sql = "UPDATE leitor
        SET
            Multa = '$multa'
        WHERE CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Leitor atualizado com sucesso!";
} else {
    echo "Erro ao atualizar leitor: " . $conn->error;
}
$conn->close();
