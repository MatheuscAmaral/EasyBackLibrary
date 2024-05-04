<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "EASY_LIBRARY";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
