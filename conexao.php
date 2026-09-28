<?php 
// definição dos dados para conectar com o banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pwii";

// cria a conexão com o BD e veerifica se ocorreu algum erro
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
  die("Falha na conexão: " . $conn->connect_error);
}

?>