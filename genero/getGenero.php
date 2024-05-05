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
$sql = "SELECT * FROM genero $where_clause";
$result = $conn->query($sql);

$generos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genero = array(
            'ID_GENERO' => $row['ID_GENERO'],
            'Nome_genero' => $row['Nome_genero']
        );
        $generos[] = $genero;
    }
    echo json_encode($generos);
} else {
    echo json_encode(array('message' => 'Nenhum gênero encontrado.'));
}
$conn->close();
