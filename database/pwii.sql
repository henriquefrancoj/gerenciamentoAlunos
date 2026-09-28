create schema `pwii`;

use pwii;

create table `alunoconcluinte` (
	id_alunoct int(11) not null auto_increment,
    nome varchar(50) not null,
    nota1 float not null,
    nota2 float not null,
    nota3 float not null,
    nota4 float not null,
    primary key(id_alunoct),
    constraint `chk_notas`
		check(
			nota1 between 0 and 10 and
			nota2 between 0 and 10 and
			nota3 between 0 and 10 and
			nota4 between 0 and 10
		)
);

-- / Povoando o banco de dados
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Bruno', 9, 8.5, 9.5, 10);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Carlos', 7.5, 6, 7, 6.5);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Diana', 10, 9.5, 10, 10);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Endrick', 8, 8, 7.5, 6.5);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Erica', 6, 7, 6.5, 6);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Andrew', 8, 7, 7, 9);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Gustavo', 6, 5, 4, 7);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Isabela', 9, 8, 9, 9.5);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Monica', 5, 6.5, 6, 5.5);
insert into `alunoconcluinte` (nome, nota1, nota2, nota3, nota4)
values('Renata', 6, 8, 7, 5.5);

create table usuarios (
	email varchar(255) not null,
	nome varchar(50) not null,
	senha varchar(255) not null,
	token_login_hash varchar(64) default null,
	token_expira DATETIME default null,
	primary key (email)
);