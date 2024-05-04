<?php
// Arquivo: insert_usuario.php

// Inclui o arquivo de conexão com o banco de dados
require_once('database.php');
require_once('index.php');

$data = json_decode(file_get_contents("php://input"), true);
// Recebe os dados do usuário via POST
$cpf = $data['cpf'];
$nome = $data['nome'];
$endereco = $data['endereco'];
$telefone = $data['telefone'];
$email = $data['email'];

// Prepara a instrução SQL para inserção de usuário
$sql = "INSERT INTO usuario (CPF, Nome, Endereco, Telefone, Email) 
        VALUES ('$cpf', '$nome', '$endereco', '$telefone', '$email')";

// Executa a consulta SQL
if ($conn->query($sql) === TRUE) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro ao inserir usuário: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>