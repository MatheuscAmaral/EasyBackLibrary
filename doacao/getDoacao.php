<?php
require_once('../database.php');
require_once('../index.php');

$sql = "SELECT * FROM Doacao";

$result = $conn->query($sql);

$doacoes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doacao = array(
            'ID_DOACAO' => $row['ID_DOACAO'],
            'ISBN' => $row['ISBN'],
            'CPF' => $row['CPF'],
            'Data' => $row['Data'],
            'Quantidade' => $row['Quantidade']
        );
        $doacoes[] = $doacao;
    }
    echo json_encode($doacoes);
} else {
    echo json_encode(array('message' => 'Nenhuma doação encontrada.'));
}
$conn->close();
