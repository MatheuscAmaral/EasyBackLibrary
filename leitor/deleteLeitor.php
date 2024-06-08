<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'];

try {

    $cpf = Filter::retornaCampoTratado($cpf, null, 14, 'CPF');

    if (!$cpf['result']) {
        throw new Exception($cpf['message'], 1);
    } else {
        $cpf = $cpf['string'];

        $selectValidaCPF = "SELECT * FROM USUARIO WHERE CPF = '$cpf'";
        $queryValidaCPF = $con->query($selectValidaCPF);
        $respostaValidaCPF = $queryValidaCPF->fetch(PDO::FETCH_ASSOC);

        $usuario = $respostaValidaCPF['Nome'];

        if (empty($respostaValidaCPF)) {
            throw new Exception('Não existe um usuario com esse CPF.');
        }
    }

    $sql = "DELETE FROM leitor WHERE CPF = '$cpf'";

    $con->query($sql);

    $response->setMessage("Leitor $usuario removido com sucesso.");
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
