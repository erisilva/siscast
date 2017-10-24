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
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../img/favicon.ico">
    <title>SisCast</title>

    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/navegacao.css">


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
                    <li><a href="../cadastro.php">Cadastro</a></li>
                    <li><a href="../pedidos.php">Pedidos</a></li>
                    <li><a href="../configuracao.php">Configurações</a></li>
                    <li><a href="../relatorios.php">Relatórios</a></li>
                    <li><a href="../logout.php">Sair</a></li>
                </ul>
            </div>  

            <!--/conteúdo-->

            <div class="conteudo">
                <div class="subtitulo">
                    Monitoramento de requisições feitas ao formulário web
                </div>

                <div class="atencao alinha">
                    Somente consulta
                </div>

                <?php
                include_once('../grade/grade.php');

                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                if ($page <= 0)
                    $page = 1;

                $per_page = 15; // quantidade de registros por página

                $startpoint = ($page * $per_page) - $per_page;

                $statement = " logacesso
                                    order by logacesso.id desc";

                $query = "SELECT logacesso.ip, 
                                date_format(logacesso.description, '%d/%m/%y %H:%i') as quando
                            FROM  {$statement} LIMIT {$startpoint} , {$per_page}";

                TDBConnection::getConnection();
                TDBConnection::prepareQuery($query);
                $result = TDBConnection::resultset();
                $nRows = TDBConnection::rowCount();

                if ($nRows != 0) {
                    echo "\n";
                    echo "\n";
                    echo "<table>\n";
                    echo "<thead>\n";
                    echo "<tr>\n";
                    //cabeçalho da tabela
                    echo "<th>Data/Hora</th>\n";
                    echo "<th>Origem</th>\n";
                    echo "</tr>\n";
                    echo "</thead>\n";
                    echo "<tbody>\n";

                    foreach ($result as $temp) {
                        echo "<tr>\n";

                        echo "<td>\n";
                        echo $temp->quando . "\n";
                        echo "</td>\n";

                        echo "<td>\n";
                        echo $temp->ip . "\n";
                        echo "</td>\n";

                        echo "</tr>\n";
                    }
                    echo "</tbody>\n";
                    echo "</table>\n";
                } else {
                    echo "Nenhum registro foi encontrado.";
                }

                // mostrando o conjunto de páginas.
                echo pagination($statement, $per_page, $page, $url = '?');
                ?>                

                <div class="menuTopo">
                    <ul class="submenu">
                        <li><a  id="erivelton" href="../configuracao.php">Menu Configurar</a></li>
                        <li>Novo Cadastro</li>
                        <li><a href="#">Exportar</a></li>
                        <li><a href="javascript:location.reload();">Atualizar Página</a></li>
                    </ul>
                </div>            
            </div>
            <!--/rodapé-->
            <br/><br/>
            <div class="rodape">
                <p>
                    <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398
                </p>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
        <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>');</script>
        <!-- scripts da página -->
        <script src="../js/operadores.js"></script>
        <script src="../js/lib.js"></script>
    </body>
</html>

