<?php

// conexão com o banco de dados
require_once "conexao.php";

// inicia a sessão
session_start();

// verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $senha = $_POST["senha"];

  // procura o usuário no banco
  $sql = "SELECT * FROM usuarios WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // verifica se encontrou o usuário
  if ($result->num_rows > 0) {
    $dadosUsuario = $result->fetch_assoc();
    // verifica se a senha informada corresponde ao hash
    if (password_verify($senha, $dadosUsuario["senha"])) {
      // cria um novo ID de sessão
      session_regenerate_id(true);
      // salva os dados do usuário na sessão
      $_SESSION["email"] = $dadosUsuario["email"];
      $_SESSION["nome"] = $dadosUsuario["nome"];
      // define o momento em que o login irá expirar
      $_SESSION["login_expira"] = time() + 1800;

      // verifica se o usuário marcou "manter logado"
      if (isset($_POST["manter_logado"])) {
        // cria um token aleatório
        $token = bin2hex(random_bytes(32));
        // transforma o token em hash para armazenar no banco
        $tokenHash = hash("sha256", $token);
        // define a validade do token: 30 minutos
        $expira = date("Y-m-d H:i:s",time() + 1800);
        // salva o hash e a validade no banco
        $sqlToken = "UPDATE usuarios SET token_login_hash = ?,
                    token_expira = ? WHERE email = ?";
        $stmtToken = $conn->prepare($sqlToken);
        $stmtToken->bind_param("sss",$tokenHash,$expira,$email);
        $stmtToken->execute();

        // cria o cookie no navegador
        setcookie("login_token", $token, ["expires" => time() + 1800,"path" => "/", "httponly" => true, "samesite" => "Lax"]);
      }
      // vai para a página principal
      header("Location: index.php");
      exit;
    } else {
      $erro = "Email ou senha incorretos.";
    }
  } else {
    $erro = "Email ou senha incorretos.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Alunos Concluintes</h1>
  </header>
  <main>
    <h2>Login</h2>
    <?php
    if (isset($erro)) {
      echo "<p>$erro</p>";
    }
    ?>
    <form method="POST">
      <label for="email">Email: </label>
      <input type="email" id="email" name="email" required>
      <br><br>

      <label for="senha">Senha: </label>
      <input type="password" id="senha" name="senha" required>
      <br><br>

      <label>
        <input type="checkbox" name="manter_logado">Manter logado
      </label>
      <br><br>

      <button type="submit">Entrar</button>
      <br><br>

      <button type="button" onclick="window.location.href='cadastro_usuario.php'">Criar conta</button>
    </form>
  </main>
</body>
</html>