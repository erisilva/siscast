<?php
session_start();
/*
 * constants
 */
require_once 'config/TConfig.php';

/*
 *  autoload
 */
require_once 'libs/Autoloader.php';
$loader = new Autoloader();
$loader->directories = array('libs', 'model');
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
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="img/favicon.ico">
    <title>SisCast</title>

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">    


    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="img/logo.png" alt="logoContagem" class="imagem_logo"> 
            </div>

            <div class="titulosuperior"> 
                <h1>SisCast - Sistema de Agenda de Castrações</h1>
            </div>

            <div class="titulofuncionario"> 
                Funcionário : <a href="operador/alterarSenha.php"><?php echo $_SESSION['sessao_usuario_name']; ?></a>
            </div>

            <!--menuTopo-->

            <div class="menuTopo">
                <ul class="menu">                     
                    <li><a href="cadastro.php">Cadastro</a></li>
                    <li><a href="pedidos.php">Pedidos</a></li>
                    <li><a href="configuracao.php">Configurações</a></li>
                    <li><a href="relatorios.php">Relatórios</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>

            </div>           

            <!--/conteúdo-->
            
            <div class="conteudo">
                
                <!-- em desenvolvimento/
                <p class="sistema">Planilhas</p>
                <ul class="listaRelatoriosplanilha">
                    <li><a href="#">Listagem #1.</a></li>
                    <li><a href="#">Listagem #2.</a></li>
                </ul> 
                -->

                <p class="sistema">Relatórios</p>
                <ul class="listaRelatoriosimp">
                    <li><a href="relatorios/relatorio001/relatorio.php">Listagem Geral de Pedidos Por Período e Situação.</a></li>
                </ul>

                <p class="sistema">Gestão</p>
                <ul class="listaAcesso">
                    <li><a href="monitora/pedido.php">Monitoramento de Pedidos.</a></li>
                    <li><a href="monitora/acesso.php">Monitoramento de Acessos ao Cadastro Público.</a></li>
                </ul>

                <br><br>

            </div>

            <!--/rodapé-->
            <br/><br/>
            <div class="rodape">
                <p>
                    <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398  
                </p>
            </div>
        </div>

    </body>
</html>                

