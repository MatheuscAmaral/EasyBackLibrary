<?php
require_once('../database.php');
require_once('../index.php');

$sql = "SELECT * FROM Livro";

$result = $conn->query($sql);

$livros = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $livro = array(
            'ISBN' => $row['ISBN'],
            'Autor' => $row['Autor'],
            'Genero' => $row['Genero'],
            'Ano_de_publicacao' => $row['Ano_de_publicacao'],
            'Editora' => $row['Editora'],
            'Status' => $row['Status'],
            'Exemplar' => $row['Exemplar'],
        );
        $livros[] = $livro;
    }
    echo json_encode($livros);
} else {
    echo json_encode(array('message' => 'Nenhum livro encontrado.'));
}
$conn->close();
