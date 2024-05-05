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

$usuarios = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuario = array(
            'CPF' => $row['CPF'],
            'Nome' => $row['Nome'],
            'Endereco' => $row['Endereco'],
            'Telefone' => $row['Telefone'],
            'Email' => $row['Email'],
        );
        $usuarios[] = $usuario;
    }
    echo json_encode($usuarios);
} else {
    echo json_encode(array('message' => 'Nenhum usuário encontrado'));
}
$conn->close();
