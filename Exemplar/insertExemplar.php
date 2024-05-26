<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$exemplar = $data['exemplar'] ?? null;

try {    
    
    $exemplar = Filter::retornaCampoTratado($exemplar, 50, null, 'Exemplar');

    if (!$exemplar['result']) {
        throw new Exception($exemplar['message'], 1);
    } else {
        $exemplar = $exemplar['string'];
        
        $selectValidaDescr = "SELECT * FROM Exemplar WHERE Exemplar = '$exemplar'";
        $queryValidaDescr = $con->query($selectValidaDescr);
        $respostaValidaDescr = $queryValidaDescr->fetch(PDO::FETCH_ASSOC);

        if (!empty($respostaValidaDescr)) {
            throw new Exception('Já existe um exemplar cadastrado com esse nome.', 1);
        }
    }
    
    $sql = "INSERT INTO Exemplar (Exemplar) VALUES ('$exemplar')";

    if (!$con->query($sql)) {
        throw new Exception('Ocorreu um erro ao tentar cadastrar o exemplar.', 1);
    } else {
        $response->setMessage("Exemplar $exemplar cadastrado com sucesso.");
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
