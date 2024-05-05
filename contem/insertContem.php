<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];
$isbn = $data['isbn'];

$sql = "INSERT INTO Contem (ID_EMPRESTIMO, ISBN) 
        VALUES ('$id_emprestimo', '$isbn')";

if ($conn->query($sql) === TRUE) {
    echo "Associação de empréstimo com livro inserida com sucesso!";
} else {
    echo "Erro ao inserir associação de empréstimo com livro: " . $conn->error;
}

$conn->close();
