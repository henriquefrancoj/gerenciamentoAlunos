<?php

// conexão com o banco de dados e proteção contra usuarios não-logdos
require_once "protecao.php";
require_once "conexao.php";

// verifica se o ID do aluno foi enviado pela URL
if(isset($_GET['id'])){
  $id = $_GET['id'];

  // faz a pesquisa do aluno pelo ID
  $sql = "SELECT * FROM alunoconcluinte WHERE id_alunoct = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  $result = $stmt->get_result();

  //verifica se encontrou o aluno
  if ($result-> num_rows > 0){
    $aluno = $result->fetch_assoc();
  } else {
    echo "Aluno não encontrado.";
    exit;
  }
} else {
  echo "Aluno não informado.";
  exit;
}

// verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $nota1 = $_POST["nota1"];
  $nota2 = $_POST["nota2"];
  $nota3 = $_POST["nota3"];
  $nota4 = $_POST["nota4"];

  // atualiza os dados do aluno
  $sql = "UPDATE alunoconcluinte
          SET nome = ?, nota1 = ?, nota2 = ?, nota3 = ?, nota4 = ?
          WHERE id_alunoct = ?";

  $stmt = $conn->prepare($sql);

  $stmt->bind_param(
    "sddddi",
    $nome,
    $nota1,
    $nota2,
    $nota3,
    $nota4,
    $id
  );

  // executa a alteração
  if ($stmt->execute()) {
    // volta para a página principal
    header("Location: index.php");
    exit;
  } else {
    echo "Erro ao atualizar aluno.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Aluno</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>Editar Aluno</h1>
</header>
<main>
  <form method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $aluno['nome']; ?>" required> 
    <br><br>

    <label for="nota1">Nota 1:</label>
    <input type="number" id="nota1" name="nota1" min="0" max="10" step="0.1" value="<?php echo $aluno['nota1']; ?>" required >
    <br><br>

    <label for="nota2">Nota 2:</label>
    <input type="number" id="nota2" name="nota2" min="0" max="10" step="0.1" value="<?php echo $aluno['nota2']; ?>" required >
    <br><br>

    <label for="nota3">Nota 3:</label>
    <input type="number" id="nota3" name="nota3" min="0" max="10" step="0.1" value="<?php echo $aluno['nota3']; ?>" required >
    <br><br>

    <label for="nota4">Nota 4:</label>
    <input type="number" id="nota4" name="nota4" min="0" max="10" step="0.1" value="<?php echo $aluno['nota4']; ?>" required >
    <br><br>

    <button type="submit">Salvar Alterações</button>
  </form>
  <br>
  <button onclick="window.location.href='index.php'">Voltar</button>
</main>
</body>
</html>