<?php

// inicia a sessão
session_start();

// tempo máximo do login: 30 minutos
$tempoLogin = 1800;

// verifica se existe uma sessão de usuário
if (isset($_SESSION["email"])) {
  // verifica se o login ainda está dentro do prazo
  if (isset($_SESSION["login_expira"]) && time() < $_SESSION["login_expira"]) {
    // usuário está logado
    return;
  }
  // sessão expirou
  session_unset();
  session_destroy();
}

// se não existe sessão válida,
// verifica se existe cookie de login automático
if (isset($_COOKIE["login_token"])) {
    require_once "conexao.php";
    $token = $_COOKIE["login_token"];

    // cria o hash do token recebido
    $tokenHash = hash("sha256", $token);

    // procura um token válido no banco
    $sql = "SELECT * FROM usuarios WHERE token_login_hash = ? AND token_expira > NOW()";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$tokenHash);
    $stmt->execute();
    $result = $stmt->get_result();

    // verifica se encontrou um token válido
    if ($result->num_rows > 0) {
      $dadosUsuario = $result->fetch_assoc();
      // cria uma nova sessão
      session_regenerate_id(true);

      $_SESSION["email"] = $dadosUsuario["email"];
      $_SESSION["nome"] = $dadosUsuario["nome"];
      $_SESSION["login_expira"] = time() + $tempoLogin;
      return;
    }
}

// se chegou aqui, o usuário não está autenticado

setcookie(
  "login_token",
  "",
  ["expires" => time() - 3600, "path" => "/", "httponly" => true, "samesite" => "Lax"]
);

header("Location: login.php");
exit;