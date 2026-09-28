<?php

// conexão com o banco de dados
require_once "conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $nome = $_POST["nome"];
  $senha = $_POST["senha"];

  // Verifica se o usuário já existe
  $sql = "SELECT email FROM usuarios WHERE email = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $erro = "Esse email já foi cadastrado.";
  } else {
    // Cria o hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Cadastra o novo usuário
    $sql = "INSERT INTO usuarios (email, nome, senha)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $nome, $senhaHash);
    if ($stmt->execute()) {
      $sucesso = "Usuário cadastrado com sucesso!";
    } else {
      $erro = "Erro ao cadastrar usuário.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Conta</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>Criar Conta</h1>
</header>
<main>
  <?php
  if ($erro != "") {
    echo "<p>$erro</p>";
  }
  if ($sucesso != "") {
    echo "<p>$sucesso</p>";
  }
  ?>
  <form method="POST">
    <label for="nome">Nome: </label>
    <input type="text" id="nome" name="nome" required>
    <br><br>

    <label for="email">Email: </label>
    <input type="email" id="email" name="email" required>
    <br><br>

    <label for="senha">Senha: </label>
    <input type="password" id="senha" name="senha" required>
    <br><br>

    <button type="submit">Criar Conta</button>
  </form>
  <br>

  <button onclick="window.location.href='login.php'">Voltar para o Login</button>
</main>
</body>
</html>