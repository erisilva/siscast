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
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../img/favicon.ico">
    <title>SisCast - Cadastro de Operadores</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.png" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>SisCast - Sistema de Agenda de Castrações</h1>
            </div>

            <div class="titulofuncionario">
                Funcionário : <a href="../operador/alterarSenha.php"><?php echo $_SESSION['sessao_usuario_name']; ?></a>
            </div>

            <!--menuTopo-->

            <div class="menuTopo">
                <ul class="menu">                     
                    <li><a href="../atendimento.php">Atendimento</a></li>
                    <li><a href="../protocolo.php">Protocolo</a></li>
                    <li><a href="../configuracao.php">Configurações</a></li>
                    <li><a href="../relatorios.php">Relatórios</a></li>
                    <li><a href="../logout.php">Sair</a></li>
                </ul>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">
                <div class="subtitulo">
                    Protocolo :: Cadastrar Novo
                </div>

                <div id="cursos">
                    <h2>Cursos</h2>
                    <ul>
                        <li class="frontend">Curso de CSS3 Básico</li>
                        <li class="backend">Curso de PHP</li>
                        <li class="frontend">Curso de HTML5</li>
                        <li class="backend">Curso de Java</li>
                        <li class="frontend">Curso de JavaScript</li>
                        <li class="frontend">Curso de jQuery</li>
                    </ul>
                </div>


            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
            <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
            <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
            <!-- scripts da página -->
            <script src="teste001.js"></script>
    </body>
</html>



