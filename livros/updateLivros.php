<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$isbn = $data['isbn'];
$autor = $data['autor'];
$genero = $data['genero'];
$ano_publicacao = $data['ano_publicacao'];
$editora = $data['editora'];
$status = $data['status'];

$sql = "UPDATE Livro 
        SET Autor = '$autor', Genero = '$genero', Ano_de_publicacao = '$ano_publicacao', Editora = '$editora', Status = '$status' 
        WHERE ISBN = '$isbn'";

if ($conn->query($sql) === TRUE) {
    echo "Livro atualizado com sucesso!";
} else {
    echo "Erro ao atualizar livro: " . $conn->error;
}

$conn->close();
