<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$nome_genero = $data['nome_genero'] ?? null;

try {

    $nome_genero = Filter::retornaCampoTratado($nome_genero, 50, null, 'Gênero');

    if(!$nome_genero['result']){
        throw new Exception($nome_genero['message'], 1);
    }else{
        $nome_genero = $nome_genero['string'];

        $selectValidaDescr = "SELECT * FROM Genero WHERE Nome_genero = '$nome_genero'";
        $queryValidaDescr = $con->query($selectValidaDescr);
        $respostaValidaDescr = $queryValidaDescr->fetch(PDO::FETCH_ASSOC);

        if(!empty($respostaValidaDescr)){
            throw new Exception('Já existe um gênero cadastrado com esse nome.', 1);            
        }
    }

    $sql = "INSERT INTO genero
        (Nome_genero)
        VALUES
        ('$nome_genero')";

    if (!$con->query($sql)) {
        throw new Exception('Ocorreu um erro ao tentar cadastrar o gênero.', 1);
    } else {
        $response->setMessage("Gênero $nome_genero cadastrado com sucesso.");
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
