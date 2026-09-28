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

// verifica se o botão de confirmação foi pressionado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // comando para excluir o aluno
  $sql = "DELETE FROM alunoconcluinte WHERE id_alunoct = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);

  // executa a exclusão
  if ($stmt->execute()) {
    // volta para a página principal
    header("Location: index.php");
    exit;
  } else {
    echo "Erro ao excluir aluno.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excluir Aluno</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Excluir Aluno</h1>
  </header>
  <main>
    <h2>Deseja realmente excluir este aluno?</h2>
    <p>
      <strong>Código:</strong><?php echo $aluno['id_alunoct']; ?>
    </p>
    <p>
      <strong>Nome:</strong><?php echo $aluno['nome']; ?>
    </p>
    <p>
      <strong>Nota 1:</strong><?php echo $aluno['nota1']; ?>
    </p>
    <p>
      <strong>Nota 2:</strong><?php echo $aluno['nota2']; ?>
    </p>
    <p>
      <strong>Nota 3:</strong><?php echo $aluno['nota3']; ?>
    </p>
    <p>
      <strong>Nota 4:</strong><?php echo $aluno['nota4']; ?>
    </p>

    <form method="POST">
      <button type="submit">Sim, excluir aluno</button>
    </form>
    <br>

    <button onclick="window.location.href='index.php'">Cancelar</button>
  </main>
</body>
</html>