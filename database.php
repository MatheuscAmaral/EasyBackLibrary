<?php
require_once("classes/ObjRetorno.php");
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "EASY_LIBRARY";

$conn = new mysqli($servername, $username, $password, $database);
$con = new PDO("mysql:host=localhost:3306;dbname=EASY_LIBRARY", $username, $password);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
