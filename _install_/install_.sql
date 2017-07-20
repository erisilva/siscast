/* SCRIPT PARA CRIAÇÃO DO BANCO DE DADOS PADRÃO */

/*
*
* funcao de criptografia usada para passwords: MD5( CONCAT('erivelton', 'password_aqui', MD5('login_aqui') ) )
* não mude meu nome erivelton. sim, sou narcisista.
*
* padrão para definir nomes de chaves estrangeira:
* [tabela origem da chave]_id
* padrão para apelidar chaves estrangeiras
* [tabela origem]_[tabela filha]_fk

utf8mb4


CREATE DATABASE helpspot_db2
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;


*/

DROP DATABASE `siscast`;

/*DEFINA O BANCO DE DADOS A SER CRIADO PELO SCRIPT*/
CREATE DATABASE `siscast` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE `siscast`;

/*******************************************************************************
*
* 
*
*******************************************************************************/


/*
*
* tabela : userProfile
*
*/
CREATE TABLE `userProfile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(40)  DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `userProfile` (`id`, `description`) VALUES (1, "gerente");
INSERT INTO `userProfile` (`id`, `description`) VALUES (2, "operador");
INSERT INTO `userProfile` (`id`, `description`) VALUES (3, "consulta");


/*
*
* table : user
* user class can be extend to have more atributes
* atributes for access
*/
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  /* private parameters */
  `userProfile_id` int(10) unsigned NOT NULL,
  `name` varchar(180)  DEFAULT NULL, /* everbody needs a name */
  `isOut` varchar(1)  DEFAULT NULL, /* Yes or Not , if yes dont let login pass*/
  `login` varchar(80)  DEFAULT NULL UNIQUE,
  `password` varchar(255)  DEFAULT NULL,
  `email` varchar(180)  DEFAULT NULL, /* email can be used for login too */
  PRIMARY KEY (`id`),

  CONSTRAINT `userProfile_user_fk` FOREIGN KEY (`userProfile_id`) REFERENCES `userProfile` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* insert the adm user */
/* change the passwor for adm here, be carefull here*/
/* password : masterkey*/
INSERT INTO `user`
  (`id`,`userProfile_id`, `name`, `isOut`, `login`, `password`, `email`)
VALUES
  (1,1,'adm', 'N','adm', MD5( CONCAT('erivelton', 'masterkey', MD5('adm') ) ),
    'adm@adm' );



CREATE TABLE `config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `param` varchar(255)  DEFAULT NULL,
  `value` varchar(255)  DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `config` (`param`, `value`) value ('Nome do Sistema', '');
insert into `config` (`param`, `value`) value ('Versão do sistema', 'alpha');
insert into `config` (`param`, `value`) value ('Suporte Telefone', '5398');
insert into `config` (`param`, `value`) value ('Suporte E-mail', 'ti.famuc@contagem.mg.gov.br');
insert into `config` (`param`, `value`) value ('Quantidade de páginas por pesquisa default', '20');
insert into `config` (`param`, `value`) value ('Expirar acesso após quantos minutos sem uso do sistema', '60');



/******************************************************************************/
/**************************************************/
/******************************************************************************/

/*
*
* tabela : racas
* onde irão ficar os pedidos de
*/

CREATE TABLE `racas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(180) DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `racas` (`descricao`) value ('Sem Raca definida');
insert into `racas` (`descricao`) value ('Beagle');
insert into `racas` (`descricao`) value ('Pug');
insert into `racas` (`descricao`) value ('Poodle');
insert into `racas` (`descricao`) value ('Boxer');
insert into `racas` (`descricao`) value ('Maltes');
insert into `racas` (`descricao`) value ('Pequines');
insert into `racas` (`descricao`) value ('Bull terrier');

/*
*
* tabela : situacao dos agendamentos
* onde irão ficar os pedidos de
*/

CREATE TABLE `situacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(170)  DEFAULT NULL,  
  `descricao` varchar(170)  DEFAULT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

insert into `situacoes` (`nome`, `descricao`) value ('Em análise', 'Em análise do pedido para agendamento');
insert into `situacoes` (`nome`, `descricao`) value ('Reprovado', 'Reprovado por falta de documentos ou não se pode ser feita a confirmação');
insert into `situacoes` (`nome`, `descricao`) value ('Agendado', 'Agendado realizado');
insert into `situacoes` (`nome`, `descricao`) value ('Conluido', 'Procedimento concluído');
insert into `situacoes` (`nome`, `descricao`) value ('Ausente', 'Não comapreceu na data e hora agendada');
insert into `situacoes` (`nome`, `descricao`) value ('Impossibilidade', 'Não foi realizado o procedimento por motivo justificado');



/*
*
* tabela : pedidos
* onde irão ficar os pedidos de
* o codigo/ano será usado para identificar os pedidos
*/


CREATE TABLE `pedidos` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

    `codigo` int(10) unsigned NOT NULL,
    `ano` int(10) unsigned NOT NULL,
    

    `cpf` varchar(11)  DEFAULT NULL,
    `nome` varchar(140)  DEFAULT NULL,
    `nascimento` DATE,

    `endereco` varchar(255)  DEFAULT NULL,
    `numero` varchar(20)  DEFAULT NULL,
    `bairro` varchar(140)  DEFAULT NULL,
    `complemento` varchar(60)  DEFAULT NULL,
    `cep` varchar(10)  DEFAULT NULL,

    `cns` ENUM ('S', 'N'),
    `beneficio` ENUM ('S', 'N'),
    `beneficioQual` varchar(120)  DEFAULT NULL,

    `tel` varchar(20)  DEFAULT NULL,
    `cel` varchar(20)  DEFAULT NULL,
    -- `email` varchar(180)  DEFAULT NULL,

    `nomeAnimal` varchar(120)  DEFAULT NULL,
    `genero` ENUM ('M', 'F'),
    `porte` ENUM ('pequeno', 'medio', 'grande') ,
    `idade` varchar(4)  DEFAULT NULL,
    `idadeEm` ENUM ('mes', 'ano'),
    `cor` varchar(80)  DEFAULT NULL,
    -- `raca` varchar(120)  DEFAULT NULL,
    `especie` ENUM ('felino', 'canino'),
    `raca_id` int(10) unsigned NOT NULL,

    `procedencia` ENUM ('vive na rua / comunitario', 'resgatado', 'adotado', 'comprado' ),
    `quando` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    

    `situacao_id` int(10) unsigned NOT NULL,

    `primeiraTentativa` ENUM ('S', 'N'),
    `primeiraTentativaQuando` DATE,
    `primeiraTentativaHora` varchar(12)  DEFAULT NULL,

    `segundaTentativa` ENUM ('S', 'N'),
    `segundaTentativaQuando` DATE,
    `segundaTentativaHora` varchar(12)  DEFAULT NULL,

    `nota` varchar(200)  DEFAULT NULL,

    `agendaQuando` DATE,
    `agendaTurno` ENUM ('manha', 'tarde'),
    `motivoNaoAgendado` varchar(120)  DEFAULT NULL,

  PRIMARY KEY (`id`),

  CONSTRAINT `racas_pedidos_id` FOREIGN KEY (`raca_id`) REFERENCES `racas` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,

  CONSTRAINT `situacoes_pedidos_id` FOREIGN KEY (`situacao_id`) REFERENCES `situacoes` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION


) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


