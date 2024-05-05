<?php
require_once('../database.php');
require_once('../index.php');

$data = json_decode(file_get_contents("php://input"), true);

$where_clause = "";

if (!empty($data)) {
    $where_clause .= " WHERE ";
    $filters = array();
    foreach ($data as $key => $value) {
        $filters[] = "$key = '$value'";
    }
    $where_clause .= implode(" AND ", $filters);
}
$sql = "SELECT * FROM Funcionario $where_clause";
$result = $conn->query($sql);

$funcionarios = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $funcionario = array(
            'CPF' => $row['CPF'],
            'Carteira_de_trabalho' => $row['Carteira_de_trabalho'],
            'Cargo' => $row['Cargo']
        );
        $funcionarios[] = $funcionario;
    }
    echo json_encode($funcionarios);
} else {
    echo json_encode(array('message' => 'Nenhum funcionario encontrado.'));
}
$conn->close();