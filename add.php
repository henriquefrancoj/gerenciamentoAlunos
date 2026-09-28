<!-- Formulário p/ add alunos ao banco de dados MySQL -->
<?php

// conexão com o banco de dados e proteção contra usuarios não-logdos
require_once "protecao.php";
require_once "conexao.php";

// verifica se o formulário foi enviado no método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // recebe os dados enviados pelo formulário
  $nome = $_POST["nome"];
  $nota1 = $_POST["nota1"];
  $nota2 = $_POST["nota2"];
  $nota3 = $_POST["nota3"];
  $nota4 = $_POST["nota4"];

  // insre os dados dentro do banco de dados
  // não precisa do id_alunoct pois ele possui AUTO_INCREMENT, gerando o valor automaticamente
  $sql = "INSERT INTO alunoconcluinte
  (nome, nota1, nota2, nota3, nota4) VALUES (?, ?, ?, ?, ?)";

  // prepara a consulta e insere os valores nos lugares dos '?'
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sdddd",
    $nome,
    $nota1,
    $nota2,
    $nota3,
    $nota4
  );

  // faz o cadastro dos nomes e retorna para o index, ou retorna uma mensagem de erro
  if($stmt->execute()){

    //fecha as conexões abertas
    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit;
  } else {
    echo "<p>Erro ao cadastrar aluno.</p>";

    $stmt->close();
    $conn->close();
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Novos Alunos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Adicionar Aluno</h1>
  </header>
  <main>
    <!-- formulário para cadastrar um novo aluno, com o POST sendo o mensageiro dos dados -->
    <form action="add.php" method="POST">
      <label for="nome">Nome do Aluno:</label>
      <input type="text" id="nome" name="nome" required><br><br>

      <label for="nota1">Nota 1:</label>
      <input type="number" id="nota1" name="nota1" step="0.5" min="0" max="10" required><br><br>

      <label for="nota2">Nota 2:</label>
      <input type="number" id="nota2" name="nota2" step="0.5" min="0" max="10" required><br><br>

      <label for="nota3">Nota 3:</label>
      <input type="number" id="nota3" name="nota3" step="0.5" min="0" max="10" required><br><br>

      <label for="nota4">Nota 4:</label>
      <input type="number" id="nota4" name="nota4" step="0.5" min="0" max="10" required><br><br>

      <button type="submit">Cadastrar aluno</button>
      <button type="reset">Limpar</button>
    </form>
    <!-- retorna manualmente à pagina inicial -->
    <button type="button" onclick="window.location.href='index.php'">Voltar</button>
  </main>
</body>
</html>



  