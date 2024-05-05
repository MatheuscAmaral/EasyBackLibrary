<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_genero = $data['id_genero'];
$nome_genero = $data['nome_genero'];

$sql = "INSERT INTO genero
        (ID_GENERO,
        Nome_genero)
        VALUES
        ('$id_genero',
         '$nome_genero')";

if ($conn->query($sql) === TRUE) {
    echo "Gênero inserido com sucesso!";
} else {
    echo "Erro ao inserir gênero: " . $conn->error;
}
$conn->close();
