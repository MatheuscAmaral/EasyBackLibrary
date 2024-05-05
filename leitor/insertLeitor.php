<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];
$multa = $data['multa'];

$sql = "INSERT INTO leitor
        (CPF,
        Multa)
        VALUES
        ('$cpf',
         '$multa')";

if ($conn->query($sql) === TRUE) {
    echo "Leitor inserido com sucesso!";
} else {
    echo "Erro ao inserir leitor: " . $conn->error;
}
$conn->close();
