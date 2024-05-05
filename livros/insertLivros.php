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
$exemplar = $data['exemplar'];

$sql = "INSERT INTO Livro (ISBN, Autor, Genero, Ano_de_publicacao, Editora, Status, Exemplar)
        VALUES ('$isbn', '$autor', '$genero', '$ano_publicacao', '$editora', '$status', '$exemplar')";

if ($conn->query($sql) === TRUE) {
    echo 'Livro inserido com sucesso!';
} else {
    echo 'Erro ao inserir livro: ' . $conn->error;
}
$conn->close();
