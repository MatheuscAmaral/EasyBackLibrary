<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];

$sql = "DELETE FROM Emprestimo WHERE ID_EMPRESTIMO = '$id_emprestimo'";

if ($conn->query($sql) === TRUE) {
    echo "Empréstimo deletado com sucesso!";
} else {
    echo "Erro ao deletar empréstimo: " . $conn->error;
}

$conn->close();
?>
