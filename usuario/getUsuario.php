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
    
    $selectGetUsuario = "SELECT CPF, Nome, Endereco, Telefone, Email, Senha FROM usuario $where_clause";
    $queryGetUsuario = $con->query($selectGetUsuario);
    $respostaGetUsuario = $queryGetUsuario->fetchAll(PDO::FETCH_ASSOC);
    $numeroLinhasGetUsuario = $queryGetUsuario->rowCount();
    
    if ($numeroLinhasGetUsuario > 0) {
        $response->setMessage('Dados recuperados com sucesso.');
        $response->setData($respostaGetUsuario);
        echo $response->jsonResponse();
    } else {
        $response->setMessage('Nenhum usuário encontrado.');
        echo $response->jsonResponse();
    }
} catch (Exception $e) {
    if($e->getCode() == 1){
        $response->setStatus(400);
        $response->setMessage($e->getMessage());
    }else{
        $response->setStatus(500);
        $response->setMessage('Ocorreu um erro no processamento.');
    }
    echo $response->jsonResponse();
}

