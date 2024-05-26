<?php
require_once('../database.php');
require_once('../index.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$where_clause = "";
$filters = array();

try {
    if (!empty($data)) {
        $where_clause .= " WHERE ";
        foreach ($data as $key => $value) {
            $filters[] = "$key = '$value'";
        }
        $where_clause .= implode(" AND ", $filters);
    }

    $sql = "SELECT funcionario.CPF
                , funcionario.Carteira_de_trabalho
                , funcionario.Cargo
            FROM funcionario $where_clause";
    $query = $con->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $numResult = $query->rowCount();

    if ($numResult > 0) {
        $response->setMessage('Dados recuperados com sucesso.');
        $response->setData($result);
        echo $response->jsonResponse();
    } else {
        $response->setMessage('Nenhum funcionario encontrado');
        echo $response->jsonResponse();
    }
} catch (Exception $e) {
    if ($e->getCode() == 1) {
        $response->setStatus(400);
        $response->setMessage($e->getMessage());
    } else {
        $response->setStatus(500);
        $response->setMessage('Ocorreu um erro no processamento.');
        $response->setMessageErro($e->getMessage());
        $response->setSql($sql);
    }
    echo $response->jsonResponse();
}