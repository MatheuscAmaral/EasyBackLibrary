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

$sql = "SELECT * FROM Doacao" . $where_clause;

$result = $conn->query($sql);

$doacoes = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $doacao = array(
            "ID_DOACAO" => $row["ID_DOACAO"],
            "ISBN" => $row["ISBN"],
            "CPF" => $row["CPF"],
            "Data" => $row["Data"],
            "Quantidade" => $row["Quantidade"]
        );
        $doacoes[] = $doacao;
    }
    echo json_encode($doacoes);
} else {
    echo json_encode(array("message" => "Nenhuma doação encontrada."));
}
$conn->close();
?>
