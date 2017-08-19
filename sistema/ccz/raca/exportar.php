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
//$filtroDataInicio = (isset($_POST['filtroDataInicio']) ? $_POST['filtroDataInicio'] : '');
//$filtroDataFim = (isset($_POST['filtroDataFim']) ? $_POST['filtroDataFim'] : '');

/*
 * efetua a consulta 
 */
$query = "select descricao from racas order by descricao;";

TDBConnection::getConnection();
TDBConnection::prepareQuery($query);
$result = TDBConnection::resultset();
$nRows = TDBConnection::rowCount();

// é importante que a query tenha pelo menos um registro
if ($nRows > 0) {

// pega os campos em forma de uma array da primeira linha da consulta
    $fields = get_object_vars($result[0]);

// cria um array contendo apenas o nome dos atributos do objeto
    $colunas = array_keys($fields);

// monta o header
    $header = "";
    for ($index = 0; $index < count($colunas); $index++) {
        $header .= $colunas[$index] . "\t";
    }

    // debug
    // echo $header;
    
    /*
     * NOTAS: 
     * trocar ; por /t dependendo da versão do servidor php
     *       
     */    

    $data = "";
    foreach ($result as $linha) {
        $line = "";
        for ($index = 0; $index < count($colunas); $index++) {
            $value = utf8_decode($linha->$colunas[$index]);
            if ((!isset($value) ) || ( $value == "" )) {
                $value = ";";
            } else {
                $value = str_replace('"', '""', $value);
                $value = str_replace('.', ',', $value);
                $value = str_replace(';', ',', $value);
                $value = '"' . $value . '"' . ";";
            }
            $line .= $value;
        }
        $data .= trim($line) . "\n";
    }
    $data = str_replace("\r", "", $data);
    
    //debug
    //echo $data;
    
} else {
    $header = "";
    $data = "Não foi encontrado nenhum registro";
}

$filename = "Raças " . date('dmY-his') . ".xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>

