<?php

// inicia a sessão
session_start();

// conexão com o banco de dados
require_once "conexao.php";

// verifica se ainda existe um usuário logado
if (isset($_SESSION["email"])){
  $email = $_SESSION["email"];

  // faz a remoção do token de login auto
  $sql = "UPDATE usuarios 
          SET token_login_hash = NULL,
              token_expira = NULL
          WHERE email = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
}

// apaga as informações armazenadas na sessão e a destroi
session_unset();
session_destroy();


// apaga o cookie de login automático
setcookie(
  "login_token",
  "",["expires" => time() - 3600, "path" => "/", "httponly" => true, "samesite" => "Lax"]
);

// volta para o login
header("Location: login.php");
exit;