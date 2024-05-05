<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];
$data_emprestimo = $data['data_emprestimo'];
$data_devolucao = $data['data_devolucao'];

$sql = "UPDATE Emprestimo 
        SET Data_emprestimo = '$data_emprestimo', Data_devolucao = '$data_devolucao' 
        WHERE ID_EMPRESTIMO = '$id_emprestimo'";

if ($conn->query($sql) === TRUE) {
    echo "Empréstimo atualizado com sucesso!";
} else {
    echo "Erro ao atualizar empréstimo: " . $conn->error;
}

$conn->close();
?>
