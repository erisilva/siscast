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
                    Operadores do Sistema :: Alterar
                </div>

                <?php
                $id = (isset($_GET['id']) ? $_GET['id'] : 0);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nomeusuario = (isset($_POST['nomeusuario']) ? strip_tags( trim( $_POST['nomeusuario']) ) : '');
                    $emailusuario = (isset($_POST['emailusuario']) ? strip_tags( trim( $_POST['emailusuario']) ) : '');
                    $isOut = (isset($_POST['isOut']) ? strip_tags( trim( $_POST['isOut']) ) : '');
                    $userProfile_id = (isset($_POST['userProfile_id']) ? strip_tags( trim( $_POST['userProfile_id']) ) : '');
                    $idUsuario = (isset($_POST['idUsuario']) ? strip_tags( trim( $_POST['idUsuario']) ) : '');
                    // Faz a alteração
                    TDBConnection::beginTransaction();
                    TDBConnection::prepareQuery("UPDATE user SET "
                            . "     userProfile_id = :userProfile_id, "
                            . "     name = :name, isOut = :isOut, "
                            . "     email = :email WHERE id = :id;");
                    TDBConnection::bindParamQuery(':userProfile_id', $userProfile_id, PDO::PARAM_INT);
                    TDBConnection::bindParamQuery(':name', $nomeusuario, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':isOut', $isOut, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':id', $idUsuario, PDO::PARAM_INT);
                    TDBConnection::bindParamQuery(':email', $emailusuario, PDO::PARAM_STR);
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

                <form name="formExec" id="formExec" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <fieldset>
                        <input name="idUsuario" type="hidden" id="idUsuario"
                               value="<?php echo (isset($result->id) ? $result->id : "0"); ?>">

                        <label for="nomeusuario">Nome:</label>
                        <input type="text" name="nomeusuario" id="nomeusuario"
                               maxlength="180" size="36" required autofocus
                               value="<?php echo (isset($result->name) ? $result->name : ""); ?>"><br><br>

                        <label for="loginusuario">Login:</label>
                        <input type="text" name="loginusuario" id="loginusuario"
                               maxlength="60" size="36" readonly
                               value="<?php echo (isset($result->login) ? $result->login : ""); ?>"><br><br>

                        <label for="emailusuario">E-mail:</label>
                        <input type="email" name="emailusuario" id="emailusuario"
                               maxlength="120" size="25" required
                               value="<?php echo (isset($result->email) ? $result->email : ""); ?>"><br/><br/>

                        <label for="isOut">Bloqueado</label>
                        <input type="radio" name="isOut" id="isOut" value="S" <?php echo ($result->isOut == 'S') ? 'checked' : ''; ?>/> Sim
                        <input type="radio" name="isOut" value="N" <?php echo ($result->isOut == 'N') ? 'checked' : ''; ?>/> Não<br><br>

                        <label for="userProfile_id">Nível:</label>
                        <select name="userProfile_id" id="userProfile_id">

                            <option value="<?php echo $result->userProfile_id ?>" selected><?php echo $result->profile ?></option>

                            <?php
                            TDBConnection::prepareQuery("select * from userprofile;");
                            $resultTemp = TDBConnection::resultset();
                            foreach ($resultTemp as $userprofile) {
                                echo "<option value=\"$userprofile->id\">$userprofile->description</option>";
                            }
                            ?>

                        </select>
                        <br><br>

                        <div class="alinha">
                            <input type="submit" name="cadastrar" id="cadastrar" value="Salvar Alterações">
                        </div>

                        <ul>
                            <li><a href="novaSenha.php?id=<?php echo (isset($result->id) ? $result->id : "0"); ?>">Criar nova senha para esse operador.</a></li>
                        </ul>

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

