# Sistema de Gerenciamento de Alunos Concluintes

Aplicação web em PHP para cadastrar e acompanhar alunos concluintes. Os dados são armazenados em MySQL; a aplicação permite consultar alunos, editar ou excluir seus registros e visualizar a média das quatro notas.

## Funcionalidades

- Cadastro de usuários e autenticação por email e senha.
- Senhas armazenadas com hash usando `password_hash` e verificadas com `password_verify`.
- Proteção das páginas de alunos para usuários autenticados, com sessão de 30 minutos e opção de manter o login.
- Listagem de alunos com código, nome, quatro notas e média calculada.
- Pesquisa de alunos pelo nome.
- Cadastro, edição e exclusão de alunos.
- Ordenação da listagem ao clicar nos cabeçalhos das colunas.

## Tecnologias

- PHP com extensão MySQLi.
- MySQL.
- HTML, CSS e JavaScript.
- XAMPP para executar o Apache e o MySQL localmente e gerenciar o banco pelo phpMyAdmin.

## Requisitos

- XAMPP instalado.
- Apache e MySQL iniciados pelo painel de controle do XAMPP.
- Navegador web.

## Configurar o banco de dados

1. Inicie o Apache e o MySQL no painel do XAMPP.
2. Acesse [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Abra a aba **SQL** e execute o script abaixo para criar o banco e as tabelas esperadas pela aplicação:

## Banco de dados

O arquivo SQL está localizado em:

`database/pwii.sql`

Ele contém a criação do banco de dados e das tabelas utilizadas
pelo sistema.

A conexão em `conexao.php` está configurada para `localhost`, usuário `root`, senha vazia e banco `pwii`, que são os valores padrão comuns do XAMPP. Se as credenciais locais forem diferentes, atualize esse arquivo.

## Executar a aplicação

1. Coloque a pasta `alunosConcluintes` dentro do diretório `htdocs` do XAMPP.
2. Confirme que Apache e MySQL estão em execução.
3. Abra [http://localhost/alunosConcluintes/cadastro_usuario.php](http://localhost/alunosConcluintes/cadastro_usuario.php) para criar uma conta.
4. Entre em [http://localhost/alunosConcluintes/login.php](http://localhost/alunosConcluintes/login.php) e faça login.
5. Use a página inicial para listar, pesquisar, adicionar, editar e excluir alunos.

## Arquivos principais

- `index.php`: página inicial, listagem, cálculo de médias e ordenação dos alunos.
- `add.php`, `edit.php` e `delete.php`: cadastro, edição e exclusão de alunos.
- `busca.php`: pesquisa de alunos pelo nome.
- `cadastro_usuario.php`, `login.php` e `logout.php`: cadastro de usuários, autenticação e encerramento de sessão.
- `protecao.php`: controle de acesso às páginas protegidas.
- `conexao.php`: configuração e abertura da conexão com o MySQL.
- `style.css`: estilos da aplicação.
- `database/pwii.sql`: criação do banco de dados e das tabelas.
- `apresentacao/ppt_alunos.pptx`: apresentação do projeto.
