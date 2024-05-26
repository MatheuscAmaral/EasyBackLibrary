<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$id_exemplar = $data['id_exemplar'] ?? null;
$exemplar = $data['exemplar'] ?? null;

try {    
    $id_exemplar = Filter::retornaCampoTratado($id_exemplar, null, null, 'ID', false);

    if (!$id_exemplar['result']) {
        throw new Exception($id_exemplar['message'], 1);
    } else {
        $id_exemplar = $id_exemplar['string'];
        
        $selectValidaId = "SELECT * FROM Exemplar WHERE ID_EXEMPLAR = '$id_exemplar'";
        $queryValidaId = $con->query($selectValidaId);
        $respostaValidaId = $queryValidaId->fetch(PDO::FETCH_ASSOC);

        if (empty($respostaValidaId)) {
            throw new Exception('O identificador do exemplar não foi encontrado.', 1);
        }
    }
    
    $exemplar = Filter::retornaCampoTratado($exemplar, 50, null, 'Exemplar');

    if (!$exemplar['result']) {
        throw new Exception($exemplar['message'], 1);
    } else {
        $exemplar = $exemplar['string'];
        
        $selectValidaDescr = "SELECT * FROM Exemplar WHERE Exemplar = '$exemplar' AND ID_EXEMPLAR <> '$id_exemplar'";
        $queryValidaDescr = $con->query($selectValidaDescr);
        $respostaValidaDescr = $queryValidaDescr->fetch(PDO::FETCH_ASSOC);

        if (!empty($respostaValidaDescr)) {
            throw new Exception('Já existe um exemplar cadastrado com esse nome.', 1);
        }
    }
    
    $sql = "UPDATE Exemplar
        SET Exemplar = '$exemplar'
        WHERE ID_EXEMPLAR = '$id_exemplar'";

    if (!$con->query($sql)) {
        throw new Exception('Ocorreu um erro ao tentar atualizar o exemplar.', 1);
    } else {
        $response->setMessage("Exemplar $exemplar atualizado com sucesso.");
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
