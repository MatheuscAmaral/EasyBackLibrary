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

$sql = "SELECT * FROM Faz" . $where_clause;

$result = $conn->query($sql);

$faz = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $faz_item = array(
            "ID_EMPRESTIMO" => $row["ID_EMPRESTIMO"],
            "CPF" => $row["CPF"],
            "Quantidade" => $row["Quantidade"]
        );
        $faz[] = $faz_item;
    }
    echo json_encode($faz);
} else {
    echo json_encode(array("message" => "Nenhuma associação encontrada."));
}
$conn->close();
?>
