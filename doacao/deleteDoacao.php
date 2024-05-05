<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_doacao = $data['id_doacao'];

$sql = "DELETE FROM Doacao WHERE ID_DOACAO = '$id_doacao'";

if ($conn->query($sql) === TRUE) {
    echo 'Doação deletada com sucesso!';
} else {
    echo 'Erro ao deletar doação: ' . $conn->error;
}
$conn->close();
