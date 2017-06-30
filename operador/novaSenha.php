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
    <script type="text/javascript" src="novaSenha.js"></script>
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
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
                    Operadores do Sistema :: Criar nova Senha
                </div>

                <?php
                $id = (isset($_GET['id']) ? $_GET['id'] : NULL);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $novasenha = (isset($_POST['novasenha']) ? $_POST['novasenha'] : '');
                    $idUsuario = (isset($_POST['idUsuario']) ? $_POST['idUsuario'] : '');
                    // Faz a alteração
                    TDBConnection::beginTransaction();
                    TDBConnection::prepareQuery("update user set password = MD5( CONCAT('erivelton', :senha, MD5(login) ) ) where id = :id");
                    TDBConnection::bindParamQuery(':senha', $novasenha, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':id', $idUsuario, PDO::PARAM_INT);
                    $result = TDBConnection::execute();
                    TDBConnection::endTransaction();

                    header("Location: formAlterar.php?id=$idUsuario");
                    exit;
                }

                TDBConnection::prepareQuery("
                            SELECT user.*, userprofile.description as profile FROM user
                            inner join userprofile on (user.userProfile_id = userprofile.id)
                            where user.id = :id
                ");
                TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
                $result = TDBConnection::single();
                $nRows = TDBConnection::rowCount();
                ?>

                <form name="formExec" id="formExec" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onSubmit="return validaForm();">
                    <fieldset>
                        <input name="idUsuario" type="hidden" id="idUsuario"
                               value="<?php echo (isset($result->id) ? $result->id : "0"); ?>">

                        <label for="novasenha">Nome:</label>
                        <input type="text" name="novasenha" id="novasenha"
                               maxlength="20" size="36" required autofocus
                               value="123456"><br><br>


                        <div class="alinha">
                            <input type="submit" name="cadastrar" id="cadastrar" value="criar nova senha">
                        </div>


                    </fieldset>
                </form>
                <div class="menuTopo">
                    <ul class="submenuAlterar">
                        <li><a href="busca.php">Fechar</a></li>
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
        <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
        <!-- scripts da página -->
    </body>
</html>

