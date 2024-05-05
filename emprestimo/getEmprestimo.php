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

$sql = "SELECT * FROM Emprestimo" . $where_clause;

$result = $conn->query($sql);

$emprestimos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $emprestimo = array(
            "ID_EMPRESTIMO" => $row["ID_EMPRESTIMO"],
            "Data_emprestimo" => $row["Data_emprestimo"],
            "Data_devolucao" => $row["Data_devolucao"]
        );
        $emprestimos[] = $emprestimo;
    }
    echo json_encode($emprestimos);
} else {
    echo json_encode(array("message" => "Nenhum empréstimo encontrado."));
}
$conn->close();
?>
