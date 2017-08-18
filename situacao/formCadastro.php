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
    <title>SisCast</title>
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
                    Situações do Pedido :: Configurar um novo cadastro
                </div>
                
                <div class="atencao alinha">
                    Inserir uma nova situação para o pedido.
                </div>                


                <?php
                $nome = $descricao = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $descricao = (isset($_POST['descricao']) ? strip_tags( trim( $_POST['descricao']) ) : '');
                    $nome = (isset($_POST['nome']) ? strip_tags( trim( $_POST['nome']) ) : '');

                    TDBConnection::beginTransaction();
                    TDBConnection::prepareQuery("insert into situacoes values ( null, :nome, :descricao)");
                    TDBConnection::bindParamQuery(':descricao', $descricao, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':nome', $nome, PDO::PARAM_STR);
                    $result = TDBConnection::execute();
                    $ultimoId = TDBConnection::lastInsertId();
                    TDBConnection::endTransaction();

                    header("Location: formAlterar.php?id=$ultimoId");
                    exit;
                }
                ?>

                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <fieldset>
                        <label for="nome">Situação:</label>
                        <input type="text" name="nome" id="nome"
                               maxlength="170" size="35" required autofocus
                               value=""><br><br>
                        
                        <label for="descricao">Breve Descrição:</label>
                        <input type="text" name="descricao" id="descricao"
                               maxlength="170" size="50" required
                               value=""><br><br>

                        <div class="alinha">
                            <input type="submit" name="cadastrar" id="cadastrar"
                                   value="Cadastrar">
                        </div>

                    </fieldset>
                </form>

                <br>

                <div class="menuTopo">
                    <ul class="submenuAlterar">
                        <li><a href="busca.php">Fechar</a></li>
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

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
            <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
            <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
            <!-- scripts da página -->
    </body>
</html>

