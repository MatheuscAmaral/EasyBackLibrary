<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];
$isbn = $data['isbn'];

$sql = "DELETE FROM Contem 
        WHERE ID_EMPRESTIMO = '$id_emprestimo' AND ISBN = '$isbn'";

if ($conn->query($sql) === TRUE) {
    echo "Associação de empréstimo com livro deletada com sucesso!";
} else {
    echo "Erro ao deletar associação de empréstimo com livro: " . $conn->error;
}

$conn->close();
?>
