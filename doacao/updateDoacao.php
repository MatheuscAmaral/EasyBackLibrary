<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$id_doacao = $data['id_doacao'];
$isbn = $data['isbn'];
$cpf = $data['cpf'];
$data_doacao = $data['data'];
$quantidade = $data['quantidade'];

$sql = "UPDATE Doacao 
        SET ISBN = '$isbn', CPF = '$cpf', Data = '$data_doacao', Quantidade = '$quantidade' 
        WHERE ID_DOACAO = '$id_doacao'";

if ($conn->query($sql) === TRUE) {
    echo 'Doação atualizada com sucesso!';
} else {
    echo 'Erro ao atualizar doação: ' . $conn->error;
}
$conn->close();
