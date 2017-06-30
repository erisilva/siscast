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
TDBConnection::prepareQuery("SELECT user.*, userprofile.description as profile FROM user inner join userprofile on (user.userProfile_id = userprofile.id)");
$result = TDBConnection::resultset();
$nRows = TDBConnection::rowCount();


$header  .= "Nome" . "\t";
$header  .= "Login" . "\t";
$header  .= "E-mail" . "\t";
$header  .= "Bloqueado?" . "\t";



$filename = "Operadores " . date('dmY-his') . ".xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>

