<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'] ?? null;

try {

    $cpf = Filter::retornaCampoTratado($cpf, null, 14, 'CPF');

    if (!$cpf['result']) {
        throw new Exception($cpf['message'], 1);
    } else {
        $cpf = $cpf['string'];

        $selectValidaCPF = "SELECT * FROM Funcionario WHERE CPF = '$cpf'";
        $queryValidaCPF = $con->query($selectValidaCPF);
        $respostaValidaCPF = $queryValidaCPF->fetch(PDO::FETCH_ASSOC);

        $selectValidaUsuario = "SELECT * FROM USUARIO WHERE CPF = '$cpf'";
        $queryValidaUsuario = $con->query($selectValidaUsuario);
        $respostaValidaUsuario = $queryValidaUsuario->fetch(PDO::FETCH_ASSOC);

        if (empty($respostaValidaCPF)) {
            throw new Exception('Não existe um funcionario cadastrado com esse CPF.', 1);
        }

        if (empty($respostaValidaUsuario)) {
            throw new Exception('Esse funcionario não possui um cadastro de usuario.', 1);
        } else {
            $nome = $respostaValidaUsuario['Nome'];
        }
    }

    $sql = "DELETE FROM funcionario
        WHERE CPF = '$cpf'";

    if (!$con->query($sql)) {
        throw new Exception('Ocorreu um erro ao tentar deletar o usuario.', 1);
    } else {
        $response->setMessage("Funcionario $nome removido com sucesso.");
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
