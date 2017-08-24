<?php
/*
 * inicia a sessão
 */
session_start();

/*
 * constants
 */
require_once '../../config/TConfig.php';

/*
 *  autoload
 */
require_once '../../libs/Autoloader.php';
$loader = new Autoloader();
$loader->directories = array('../../libs', '../../model');
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
    <link rel="icon" href="../../img/favicon.ico">
    <title>SisCast - Pedidos de Agendamento Público</title>
    <link rel="stylesheet" type="text/css" href="../../estilo/estilo.css">
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../../img/logo.png" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Cadastro para Esterilização de Animais</h1>
            </div>

            <div class="titulofuncionario">
                Funcionário : <a href="../../operador/alterarSenha.php"><?php echo $_SESSION['sessao_usuario_name']; ?></a>
            </div>

            <!--menuTopo-->

            <div class="menuTopo">
                <ul class="menu">                     
                    <li><a href="../../cadastro.php">Cadastro</a></li>
                    <li><a href="../../pedidos.php">Pedidos</a></li>
                    <li><a href="../../configuracao.php">Configurações</a></li>
                    <li><a href="../../relatorios.php">Relatórios</a></li>
                    <li><a href="../../logout.php">Sair</a></li>
                </ul>
            </div>  

            <!--/conteúdo-->

            <div class="conteudo">
                <div class="subtitulo">
                    Relatório de Pedidos
                </div>

                <form name="formExec" id="formExec" method="post"
                      action="relatorioExec.php">
                    <fieldset>
                        
                        Entre:<input type="date" name="dta_inicio" required>à<input type="date" name="dta_fim" required>

                        <select name="idSituacao" id="idUnidade">
                        <option value="0" selected>Mostrar Todas Situações do Pedido</option>
                        <?php
                        TDBConnection::prepareQuery("select * from situacoes order by nome;");
                        $situacoes = TDBConnection::resultset();
                        foreach ($situacoes as $situacao) {
                            echo "<option value=\"$situacao->id\">$situacao->nome</option>" . EOL;
                        }
                        ?>
                        </select>

                        <br>
                        <div class="alinha">
                            <input type="submit" name="cadastrar" id="cadastrar"
                                   value="Imprimir">
                        </div>

                    </fieldset>
                </form>

                <br>

                <div class="menuTopo">
                    <ul class="submenuAlterar">
                        <li><a href="../../relatorios.php">Fechar</a></li>
                    </ul>
                </div>

                <!--/rodapé-->
                <br/><br/>
                <div class="rodape">
                    <p>
                        <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398
                    </p>
                </div>
            </div>
        </div>    
            <!-- scripts da página -->
    </body>
</html>

