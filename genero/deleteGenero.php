<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

$sql = "DELETE FROM genero
        WHERE ID_GENERO = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "Gênero deletada com sucesso!";
} else {
    echo "Erro ao deletar gênero: " . $conn->error;
}
$conn->close();
