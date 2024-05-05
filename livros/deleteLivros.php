<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$isbn = $data['isbn'];

$sql = "DELETE FROM Livro WHERE ISBN = '$isbn'";

if ($conn->query($sql) === TRUE) {
    echo "Livro deletado com sucesso!";
} else {
    echo "Erro ao deletar livro: " . $conn->error;
}

$conn->close();
