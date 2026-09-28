<?php
// recebe o texto pesquisa pelo GET, com o ?? definindo um valor vazio se o search não for enviado
$pesquisaAluno = $_GET['search'] ?? '';

// conexão com o banco de dados e proteção contra usuarios não-logdos
require_once "protecao.php";
require_once "conexao.php";

// o resultado de pesquisa começa vazio e verifica se o usuário digitou algo
$result = null;
if ($pesquisaAluno != ''){
  // adiciona curingas para encontrar qualquer parte do nome e substitui pelo ?
  $pesquisaTermo = "%" . $pesquisaAluno . "%"; 
  $sql = "SELECT * FROM alunoconcluinte 
  WHERE nome LIKE ?";
  
  // prepara a consulta usando prepared statement, para evitar SQL Injection
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $pesquisaTermo); // envia o termo pesquisado para ?, com s indicando uam string
  $stmt->execute();
  $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados da Pesquisa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Pesquisa de Alunos</h1>
  </header>
  <main>
    <!-- formulario de pesquisa  -->
    <div>
      <p><strong>Pesquisar aluno</strong></p>
      <form action="busca.php" method="GET">
        <input type="text" name="search" placeholder="Pesquisar aluno" value="<?php echo htmlspecialchars($pesquisaAluno); ?>">
        <button type="submit">Pesquisar</button>
      </form>
    </div>
    <div>

    </div>
    <br>
    <?php if ($pesquisaAluno != ''){ // verifica se teve uma pesquisa e se encontrou um aluno
      if ($result->num_rows > 0) {
        echo "<h2>Resultados da pesquisa para: " . htmlspecialchars($pesquisaAluno) . "</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Código do Aluno</th>";
        echo "<th>Nome</th>";
        echo "<th>Nota 1</th>";
        echo "<th>Nota 2</th>";
        echo "<th>Nota 3</th>";
        echo "<th>Nota 4</th>";
        echo "<th>Média</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        // exibe os resultados da pesquisa, enquanto calcula a média de cada aluno
        while ($row = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $row['id_alunoct'] . '</td>';
          echo '<td>' . $row['nome'] . '</td>';
          echo '<td>' . $row['nota1'] . '</td>';
          echo '<td>' . $row['nota2'] . '</td>';
          echo '<td>' . $row['nota3'] . '</td>';
          echo '<td>' . $row['nota4'] . '</td>';
          // calcula e mostra a media com 1 casa decimal
          $media = ($row['nota1'] + $row['nota2'] + $row['nota3'] + $row['nota4'])/4;
          echo '<td>' . number_format($media, 1) . '</td>';
          echo '</tr>';
        }
        echo "</tbody>";
        echo "</table>";
      } else {
        // se não encontrar nenhum aluno, exibe a seguinte mensagem
        echo "<p><strong>Nenhum aluno encontrado.</strong></p>";
      }
    }
    
    $conn->close();
    ?>
    <br>
    <button type="button" onclick="window.location.href='index.php'">
      Voltar
    </button>
  </main>
</body>
</html>

