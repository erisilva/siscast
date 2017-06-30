<?php
/*
 *  session stuff and auload class
 */
session_start();
/*
 * constants
 */
require_once '/config/TConfig.php';

/*
 *  autoload
 */
require_once 'libs/Autoloader.php';

$loader = new Autoloader();
$loader->directories = array('libs', 'gui');
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
 * constants
 */
require_once './config/TConfig.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="Sistema para controle dos protocolos para o Recursos Humanos da FAMUC">
    <meta name="keywords" content="mvc2, Sistema de informação,protocolos,recursos humanos, prefeitura muncipal de contagem, mg, secretaria de saúde, gestão de protocolos, FAMUC">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="img/favicon.ico">

    <title>SisCast</title>

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">    


    <body>
        <div class="estrutura_popup">

            <div class="logotipo">
                <img src="img/logo.jpg" alt="logoContagem" class="imagem_logo"> 
            </div>

            <div class="titulosuperior"> 
                <h1>SisCast - Sistema de Agenda de Castrações</h1>
            </div>

            <!--/conteúdo-->
                            
            <fieldset>
                <legend>Entrar no sistema</legend>

                <form name="formEntrar" id="formEntrar">
                    
                    
                    <label for="loginusuario">Login:</label>
                    <input type="text" name="loginusuario" id="loginusuario" maxlength="80" required autofocus><br/><br/>

                    <label for="senhausuario">Senha:</label>
                    <input type="password" name="senhausuario" id="senhausuario" maxlength="40" required><br/>

                    <p class="alinha"> 
                        <input type="submit" name="logar" value="Entrar no sistema">
                    </p>

                </form>

            </fieldset>
        </div>        
        
        

        <!--/rodapé-->
        <br/><br/>
        <div class="rodape">
            <p>
                <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398 
            </p>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
        <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>');</script>
        <!-- scripts da página -->
        <script src="js/index.js"></script>

    </body>
</html>
