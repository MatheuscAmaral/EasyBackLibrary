<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];
$cpf = $data['cpf'];

$sql = "DELETE FROM Faz 
        WHERE ID_EMPRESTIMO = '$id_emprestimo' AND CPF = '$cpf'";

if ($conn->query($sql) === TRUE) {
    echo "Associação de empréstimo com usuário deletada com sucesso!";
} else {
    echo "Erro ao deletar associação de empréstimo com usuário: " . $conn->error;
}

$conn->close();
?>
