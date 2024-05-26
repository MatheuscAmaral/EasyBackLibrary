<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents('php://input'), true);

$cpf = $data['cpf'] ?? null;
$senha = $data['senha'] ?? null;

try {

    $cpf = Filter::retornaCampoTratado($cpf, null, 14, 'CPF', false);

    if (!$cpf['result']) {
        throw new Exception($cpf['message'], 1);
    } else {
        $cpf = $cpf['string'];

        $selectValidaCPF = "SELECT * FROM USUARIO WHERE CPF = '$cpf'";
        $queryValidaCPF = $con->query($selectValidaCPF);
        $respostaValidaCPF = $queryValidaCPF->fetch(PDO::FETCH_ASSOC);

        if (empty($respostaValidaCPF)) {
            throw new Exception('O CPF informado não esta relacionado a nenhum usuario cadastrado no sistema.', 1);
        }
    }

    $senha = Filter::retornaCampoTratado($senha, 20, null, 'Senha', false);

    if (!$senha['result']) {
        throw new Exception($senha['message'], 1);
    } else {
        $senha = $senha['string'];
    }

    $selectSenha = "SELECT Senha FROM usuario WHERE cpf = '$cpf'";
    $querySenha = $con->query($selectSenha);
    $respostaSenha = $querySenha->fetch(PDO::FETCH_ASSOC);

    if ($respostaSenha['Senha'] == $senha) {
        $response->setMessage('Senha valida.');
        $response->setData(true);
    } else {
        $response->setMessage('Senha invalida.');
        $response->setData(false);
    }

    echo $response->jsonResponse();
} catch (Exception $e) {
    if ($e->getCode() == 1) {
        $response->setStatus(400);
        $response->setMessage($e->getMessage());
    } else {
        $response->setStatus(500);
        $response->setMessage('Ocorreu um erro no processamento.');
        $response->setMessageErro($e->getMessage());
        $response->setSql($selectSenha);
    }
    echo $response->jsonResponse();
}
