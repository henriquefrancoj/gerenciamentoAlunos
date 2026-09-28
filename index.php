<?php

// conexão com o banco de dados e proteção contra usuarios não-logdos
require_once "protecao.php";
require_once "conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunos Concluintes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Alunos Concluintes</h1>
    <button onclick="window.location.href='logout.php'">Sair</button>
  </header>
  <main>
    <div>
      <!-- formulário para pesquisar um aluno -->
      <!-- O GET envia o texto pela URL, e a página busca.php recebe e realiza a pesquisa -->
      <div>
        <p><strong>Pesquisar aluno</strong></p>
        <form action="busca.php" method="GET">
          <input type="text" name="search" placeholder="Pesquisar">
          <button type="submit">Buscar</button>
        </form>
      </div>
      <div>
        <h2>Lista de alunos concluintes</h2>
      </div> 
      <table>
        <thead>
          <tr>
            <!-- permite acesso ao codigo JavaScript para ordenar os dados ao clicar na coluna específica -->
            <th onclick="rankTable(0)">Código do Aluno</th>
            <th onclick="rankTable(1)">Nome</th>
            <th onclick="rankTable(2)">Nota 1</th>
            <th onclick="rankTable(3)">Nota 2</th>
            <th onclick="rankTable(4)">Nota 3</th>
            <th onclick="rankTable(5)">Nota 4</th>
            <th onclick="rankTable(6)">Média</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // acesso ao banco de dados MySQL para mostrar os alunos e o executa
            $sql = "select * from alunoconcluinte";
            $result = $conn->query($sql);

            // verifica se a consulta retornou algum resultado
            if($result != null) {
              // verifica se existe pelo menos 1 aluno cadastrado
              if ($result->num_rows > 0){
                // percorre a lista de alunos e cria as linhas para inserção dos dados
                while($row = $result->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>' . $row['id_alunoct'] . '</td>';
                  echo '<td>' . $row['nome'] . '</td>';
                  echo '<td>' . $row['nota1'] . '</td>';
                  echo '<td>' . $row['nota2'] . '</td>';
                  echo '<td>' . $row['nota3'] . '</td>';
                  echo '<td>' . $row['nota4'] . '</td>';
                  // media mostrara apenas 1 casa decimal
                  $media = ($row['nota1'] + $row['nota2'] + $row['nota3'] + $row['nota4'])/4;
                  echo '<td>' . number_format($media, 1) . '</td>';
                  // botão para editar aluno
                  echo '<td>';
                  echo '<button onclick="window.location.href=\'edit.php?id=' . $row['id_alunoct'] . '\'">Editar</button>';
                  echo '<button onclick="window.location.href=\'delete.php?id=' . $row['id_alunoct'] . '\'">Excluir</button>';
                  echo '</td>';
                  echo '</tr>';
                }
              }
            } 

            $conn->close();
          ?>
        </tbody>
      </table>
      <div>
        <!-- botões para cadastrar / excluir um aluno -->
        <button onclick="window.location.href='add.php'">Adicionar Aluno</button>
        <!-- <button onclick="window.location.href='delete.php'">Excluir Aluno</button> -->
      </div>
    </div>
  </main>
  <script>
    // código JavaScript para ordenar de forma crescente/decrescente da tabela com base na coluna clicada
    let aColumn = -1;
    let upOrder = true;

    function rankTable(column){
      let tables = document.querySelector("tbody");
      let tableLines = Array.from(tables.querySelectorAll("tr"));

      // condição para ordenar as colunas em crescente ou decrescente ao clicar
      if(aColumn == column) {
        upOrder = !upOrder;
      } else {
        aColumn = column;
        upOrder = true;
      }
      
      // organização das linhas da tabela 
      tableLines.sort(function(a,b){
        let valueA = a.cells[column].textContent;
        let valueB = b.cells[column].textContent;
        // realiza comparação de texto se a coluna for o nome
        if (column == 1) {
          if (upOrder) {
            return valueA.localeCompare(valueB);
          } else {
            return valueB.localeCompare(valueA);
          }
        }
        // converte os valores das notas / medias para numeros
        valueA = parseFloat(valueA.replace(",", "."));
        valueB = parseFloat(valueB.replace(",", "."));

        // inverte de acordo com a ordem atual
        if(upOrder) {
          return valueA - valueB;
        } else {
          return valueB - valueA;
        }
      });
      // reorganiza as linhas na tabela an nova ordem
      tableLines.forEach(function(tableLine){
        tables.appendChild(tableLine);
      });
    }
  </script>
</body>
</html>