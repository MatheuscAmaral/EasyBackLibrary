<?php
require_once('../database.php');
require_once('../index.php');
require_once('../classes/funcoesValidadoras.php');
$response = new Response();

$data = json_decode(file_get_contents("php://input"), true);

$cpf = $data['cpf'] ?? null;
$carteira_de_trabalho = $data['carteira_de_trabalho'] ?? null;
$cargo = $data['cargo'] ?? null;

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

        if (!empty($respostaValidaCPF)) {
            throw new Exception('Já existe um funcionario cadastrado com esse CPF.', 1);
        }

        if(empty($respostaValidaUsuario)){
            throw new Exception('Esse novo funcionario não possui um cadastro de usuario.', 1);
        }else{
            $nome = $respostaValidaUsuario['Nome'];
        }
    }

    $carteira_de_trabalho = Filter::retornaCampoTratado($carteira_de_trabalho, 20, null, 'Carteira de trabalho');

    if (!$carteira_de_trabalho['result']) {
        throw new Exception($carteira_de_trabalho['message'], 1);
    } else {
        $carteira_de_trabalho = $carteira_de_trabalho['string'];
    }

    $cargo = Filter::retornaCampoTratado($cargo, 100, null, 'Cargo');

    if (!$cargo['result']) {
        throw new Exception($cargo['message'], 1);
    } else {
        $cargo = $cargo['string'];
    }

    $insertFuncionario = "INSERT INTO FUNCIONARIO
                            (
                                CPF
                            , CARTEIRA_DE_TRABALHO
                            , CARGO
                            )
                            VALUES
                            (   '$cpf' -- <{CPF: }>
                            , '$carteira_de_trabalho' -- <{CARTEIRA_DE_TRABALHO: }>
                            , '$cargo' -- <{CARGO: }>
                            )";
    if (!$con->query($insertFuncionario)) {
        throw new Exception('Ocorreu um erro ao tentar criar o novo funcionario.', 1);
    } else {
        $response->setMessage("Funcionario $nome cadastrado com sucesso.");
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
        $response->setSql($selectGetUsuario);
    }
    echo $response->jsonResponse();
}
