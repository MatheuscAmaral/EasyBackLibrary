<?php
require_once('../database.php');
require_once('../index.php');

$sql = "SELECT usuario.CPF,
            usuario.Nome,
            usuario.Endereco,
            usuario.Telefone,
            usuario.Email
        FROM usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

echo json_encode($response);

$conn->close();
