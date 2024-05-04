<?php
require_once('database.php');
require_once('index.php');

$response = array(
    'message' => 'Este é um exemplo de resposta do PHP.',
    'data' => array(
        'foo' => 'bar'
    )
);

$sql = "SELECT * FROM Usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
}

echo json_encode($response);

$conn->close();
?>