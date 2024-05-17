<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$where_clause = "";
$filters = array();

if (!empty($data)) {
    $where_clause .= " WHERE ";
    foreach ($data as $key => $value) {
        $filters[] = "$key = ?";
    }
    $where_clause .= implode(" AND ", $filters);
}

$sql = "SELECT CPF, Nome, Endereco, Telefone, Email, Senha FROM usuario $where_clause";
$stmt = $conn->prepare($sql);

if (!empty($filters)) {
    $types = str_repeat('s', count($data));
    $stmt->bind_param($types, ...array_values($data));
}

$stmt->execute();
$result = $stmt->get_result();

$usuarios = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuario = array(
            'CPF' => $row['CPF'],
            'Nome' => $row['Nome'],
            'Endereco' => $row['Endereco'],
            'Telefone' => $row['Telefone'],
            'Email' => $row['Email'],
            'Senha' => isset($row['Senha']) ? $row['Senha'] : null
        );
        $usuarios[] = $usuario;
    }
    echo json_encode($usuarios);
} else {
    echo json_encode(array('message' => 'Nenhum usuário encontrado'));
}

$stmt->close();
$conn->close();
