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
    <script type="text/javascript" src="alterarSenha.js"></script>
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
                Funcionário : <a href="alterarSenha.php"><?php echo $_SESSION['sessao_usuario_name']; ?></a>
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
                    Operador do Sistema :: Alterar Senha
                </div>

                <?php
                $id = (isset($_SESSION['sessao_usuario_id']) ? $_SESSION['sessao_usuario_id'] : NULL);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $novaSenha = (isset($_POST['novaSenha']) ? $_POST['novaSenha'] : '123');

                    // Faz a alteração
                    TDBConnection::beginTransaction();
                    TDBConnection::prepareQuery("update user set password = :password where id = :id;");
                    TDBConnection::bindParamQuery(':id', $_SESSION['sessao_usuario_id'], PDO::PARAM_INT);
                    TDBConnection::bindParamQuery(':password', $novaSenha, PDO::PARAM_STR);
                    $result = TDBConnection::execute();
                    TDBConnection::endTransaction();

                    header("Location: alterarSenha.php");
                    exit;
                }
                
                /*
                 * guarda as informações do usuário
                 */
                TDBConnection::prepareQuery("
                            SELECT user.*, userprofile.description as profile FROM user
                            inner join userprofile on (user.userProfile_id = userprofile.id)
                            where user.id = :id
                ");
                TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
                $result = TDBConnection::single();
                $nRows = TDBConnection::rowCount();
                ?>

                <form name="formAlterarSenha" id="formExec" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  onSubmit="return validaForm();">
                    <fieldset>

                        <label for="nomeusuario">Nome:</label>
                        <input type="text" name="nomeusuario" id="nomeusuario"
                               maxlength="180" size="36" readonly
                               value="<?php echo (isset($result->name) ? $result->name : ""); ?>"><br><br>

                        <label for="senhaAtual">Senha atual:</label>
                        <input type="password" name="senhaAtual" id="senhaAtual"
                               maxlength="10" size="20" required pattern=".{4,10}"
                               value=""><br><br>

                        <label for="novaSenha">Nova senha:</label>
                        <input type="password" name="novaSenha" id="novaSenha"
                               maxlength="10" size="20" required pattern=".{4,10}"
                               value="">Mínimo 4 caracteres<br><br>

                        <label for="novaSenhaRepetir">Nova senha(repetir):</label>
                        <input type="password" name="novaSenhaRepetir" id="novaSenhaRepetir"
                               maxlength="10" size="20" required pattern=".{4,10}"
                               value=""><br><br>

                        <br><br>

                        <div class="alinha">
                            <input type="submit" name="cadastrar" id="cadastrar" value="Salvar Nova Senha">
                        </div>

                    </fieldset>
                </form>
                <div class="menuTopo">
                    <ul class="submenuAlterar">
                        <li><a href="../configuracao.php">Fechar</a></li>
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

