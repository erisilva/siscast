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
    <title>SisCast - Erro100</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.png" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Cadastro para Esterilização de Animais</h1>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">

                <p class="atencao alinha"><strong>Erro:</strong>Existem campos não preenchidos.</p>
                
                <p>Recomenda-se a utilização desse formulário nos seguintes navegadores: Microsoft Edge, Google Chrome, Mozzila Firefox ou Opera</p>
                
                <p class="atencao">Incompátivel com Internet Explorer</p>
                
                <br>

                <p class="alinha"><a href="javascript:history.go(-1)">[Voltar]</a></p>

                <!--/rodapé-->
                <br/><br/>
                <div class="rodape">
                    <p>
                        <strong>Centro de Controle de Zoonoses</strong><br>
                        Telefones: 3351-3751 / 3361-7703<br>
                        E-mail: cczcontagem@yahoo.com.br
                    </p>
                </div>
            </div>

            <!-- scripts da página -->

        </div>    
    </body>
</html>

