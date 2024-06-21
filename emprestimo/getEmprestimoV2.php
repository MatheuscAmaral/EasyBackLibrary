<?php
require_once('../database.php');
require_once('../index.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$where_clause = "";

try {
    if (!empty($data)) {
        $where_clause .= " WHERE ";
        $filters = array();
        foreach ($data as $key => $value) {
            $filters[] = "$key = '$value'";
        }
        $where_clause .= implode(" AND ", $filters);
    }

    $sql = "SELECT * FROM Emprestimo 
    INNER JOIN Contem ON Emprestimo.ID_EMPRESTIMO = Contem.ID_EMPRESTIMO
    INNER JOIN Faz ON Emprestimo.ID_EMPRESTIMO = Faz.ID_EMPRESTIMO
    " . $where_clause;
    $query = $con->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $numResult = $query->rowCount();

    if ($numResult > 0) {
        $response->setMessage('Dados recuperados com sucesso.');
        $response->setData($result);
    } else {
        $response->setMessage('Nada encontrado');
    }
} catch (PDOException $e) {
    $response->setStatus(500);
    $response->setMessage('Ocorreu um erro no processamento.');
    $response->setMessageErro($e->getMessage());
    $response->setSql($sql);
} catch (Exception $e) {
    $response->setStatus(400);
    $response->setMessage($e->getMessage());
} finally {
    echo $response->jsonResponse();
}