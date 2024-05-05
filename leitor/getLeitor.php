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
$sql = "SELECT * FROM leitor $where_clause";
$result = $conn->query($sql);

$leitores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leitor = array(
            'CPF' => $row['CPF'],
            'Multa' => $row['Multa']
        );
        $leitores[] = $leitor;
    }
    echo json_encode($leitores);
} else {
    echo json_encode(array('message' => 'Nenhum leitor encontrado.'));
}
$conn->close();
