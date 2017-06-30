<?php

/*
 * inicia a sessão
 */
session_start();

/*
 * constants
 */
require_once '../config/TConfig.php';

/*
 *  autoload
 */
require_once '../libs/Autoloader.php';
$loader = new Autoloader();
$loader->directories = array('../libs', '../model');
$loader->register();

/*
 * valida sessão
 */
if (!isset($_SESSION['sessao_usuario_id'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

/*
 * header page
 */
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/log/log.txt');
ini_set('error_reporting', E_ALL ^ E_NOTICE);
/*
 * se conecta
 */
TDBConnection::getConnection();

/*
 * recebe os parametros de filtragem 
 */
$filtroDataInicio = (isset($_POST['filtroDataInicio']) ? $_POST['filtroDataInicio'] : '');
$filtroDataFim = (isset($_POST['filtroDataFim']) ? $_POST['filtroDataFim'] : '');

/*
 * efetua a consulta 
 */
$query = " SELECT 
                    protocolo.*,
                concat(lpad(protocolo.sequenciaCodigo, 5, '0'), '-', DATE_FORMAT(protocolo.sequenciaData,'%d/%m/%y') ) as codigoInterno,
                tipoProtocolo.descricao as tipoProtocolo,
                situacaoProtocolo.descricao as situacaoProtocolo,
                user.name as nomeOperador,
                user.email as emailOperador,
                funcionario.nome as nomeFuncionario,
                funcionario.matricula as matriculaFuncionario,
                funcionario.email as emailFuncionario,
                setor.descricao as setorFuncionario,
                date_format(protocolo.quando, '%d/%m/%y %H:%i') as quandoFormatado

            FROM protocolo
                    inner join tipoProtocolo on (protocolo.tipoProtocolo_id = tipoProtocolo.id)
                inner join situacaoProtocolo on (protocolo.situacaoProtocolo_id = situacaoProtocolo.id)
                inner join user on (protocolo.user_id = user.id)
                inner join funcionario on (protocolo.funcionario_id = funcionario.id)
                inner join setor on (funcionario.setor_id = setor.id)

             where 1 = 1

             order by protocolo.quando desc;";

TDBConnection::getConnection();
TDBConnection::prepareQuery($query);
$result = TDBConnection::resultset();
$nRows = TDBConnection::rowCount();

// pega os campos em forma de uma array da primeira linha da consulta
// é importante que a query tenha pelo menos um registro
$fields = get_object_vars($result[0]);

// cria um array contendo apenas o nome dos atributos do objeto
$colunas = array_keys($fields);

// lista na tela
for ($index = 0; $index < count($colunas); $index++) {
    echo $colunas[$index] . "<br>";
}

?>

