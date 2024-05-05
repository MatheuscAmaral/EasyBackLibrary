<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_emprestimo = $data['id_emprestimo'];
$cpf = $data['cpf'];
$quantidade = $data['quantidade'];

$sql = "INSERT INTO Faz (ID_EMPRESTIMO, CPF, Quantidade) 
        VALUES ('$id_emprestimo', '$cpf', '$quantidade')";

if ($conn->query($sql) === TRUE) {
    echo "Associação de empréstimo com usuário inserida com sucesso!";
} else {
    echo "Erro ao inserir associação de empréstimo com usuário: " . $conn->error;
}

$conn->close();
?>
