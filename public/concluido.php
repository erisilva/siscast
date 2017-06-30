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
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../img/favicon.ico">
    <title>SisCast - Conclusão de Pedido</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Agenda de Castrações</h1>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">

                <p>Pedido enviado - definir qual mensagem ficará aqui</p>

                <!--/rodapé-->
                <br/><br/>
                <div class="rodape">
                    <p>
                        <strong>Central de Controle de Zoonoses</strong><br>
                        Telefone: 1111-1111<br>
                        E-mail: email@email.com.br
                    </p>
                </div>
            </div>

            <!-- scripts da página -->
        </div>    
    </body>
</html>

