<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$id_genero = $data['id_genero'] ?? null;
$nome_genero = $data['nome_genero'] ?? null;

try {

    $id_genero = Filter::retornaCampoTratado($id_genero, null, null, 'ID', false);

    if (!$id_genero['result']) {
        throw new Exception($id_genero['message'], 1);
    } else {
        $id_genero = $id_genero['string'];

        $selectValidaId = "SELECT * FROM Genero WHERE ID_GENERO = '$id_genero'";
        $queryValidaId = $con->query($selectValidaId);
        $respostaValidaId = $queryValidaId->fetch(PDO::FETCH_ASSOC);

        if (empty($respostaValidaId)) {
            throw new Exception('O identificador do gênero não foi encontrado.', 1);
        }
    }

    if (!$nome_genero['result']) {
        throw new Exception($nome_genero['message'], 1);
    } else {
        $nome_genero = $nome_genero['string'];

        $selectValidaDescr = "SELECT * FROM Genero WHERE Nome_genero = '$nome_genero' AND ID_GENERO <> '$id_genero'";
        $queryValidaDescr = $con->query($selectValidaDescr);
        $respostaValidaDescr = $queryValidaDescr->fetch(PDO::FETCH_ASSOC);

        if (!empty($respostaValidaDescr)) {
            throw new Exception('Já existe um gênero cadastrado com esse nome.', 1);
        }
    }

    $sql = "UPDATE genero
        SET
            Nome_genero = '$nome_genero'
        WHERE ID_GENERO = '$id_genero'";

    if (!$con->query($sql)) {
        throw new Exception('Ocorreu um erro ao tentar atualizar o gênero.', 1);
    } else {
        $response->setMessage("Gênero $nome_genero atualizado com sucesso.");
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
