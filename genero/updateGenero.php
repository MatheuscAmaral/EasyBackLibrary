<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_genero = $data['id_genero'];
$nome_genero = $data['nome_genero'];

$sql = "UPDATE genero
        SET
            Nome_genero = '$nome_genero'
        WHERE ID_GENERO = '$id_genero'";

if ($conn->query($sql) === TRUE) {
    echo "Gênero atualizado com sucesso!";
} else {
    echo "Erro ao atualizar gênero: " . $conn->error;
}
$conn->close();