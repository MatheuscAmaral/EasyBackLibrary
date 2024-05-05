<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$isbn = $data['isbn'];
$cpf = $data['cpf'];
$data_doacao = $data['data'];
$quantidade = $data['quantidade'];

$sql = "INSERT INTO Doacao (ISBN, CPF, Data, Quantidade) 
        VALUES ('$isbn', '$cpf', '$data_doacao', '$quantidade')";

if ($conn->query($sql) === TRUE) {
    echo "Doação inserida com sucesso!";
} else {
    echo "Erro ao inserir doação: " . $conn->error;
}

$conn->close();
?>
