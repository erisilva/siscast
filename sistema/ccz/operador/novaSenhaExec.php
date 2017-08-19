<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require('../conexao/conexao.php');
$conexao = mysql_connect($local, $user, $pass) or die("Conexão não pode ser estabelecida: " . mysql_error() . $local);

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

mysql_select_db($DBName, $conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="Erivelton da Silva">
    <title>SisSAS - FAMUC</title>
    <link rel="stylesheet" type="text/css" href="../estilo/base.css">

    <body>

        <?php
        // Verifica se o usuario está logado no sistema
        if (!(isset($_SESSION['sessao_usuario_id']))) {
            mysql_close($conexao);
            ?>
            <script type="text/javascript">
                window.open('../erro/erro00.php?erro=6', '_parent');
            </script>
            <?php
            exit();
        }
        ?>

        <div class="estrutura_popup">

            <!-- Cabeçalho-->

            <div class="loading">
                <img src="../imagens/loading.gif" alt="loadinggif" class="imagem_loading"> 
            </div>


            <!--/conteúdo-->

            <div class="conteudo">
                <?php
                include('../funcao/funcao_AbrirJanela.php');

                // VAR
                $idUsuario = $_POST['idUsuario'];

                // consulta os dados do usuário
                $sql = "SELECT usuario.*, usuarionivel.descricao as nivelusuario 
                                FROM usuario
                                        inner join usuarionivel on (usuario.idUsuarioNivel = usuarionivel.idUsuarioNivel)
                        where usuario.idUsuario = $idUsuario;";

                $resultado = mysql_query($sql) or die("Query invalida: " . mysql_error() . $sql);
                $usuario = mysql_fetch_array($resultado);

                // bloqueia a utilização caso o usuário não tenha permissão
                // 1 - administrador
                // 2+ - operadores
                $sql = "select usuario.idUsuarioNivel from usuario where usuario.idusuario = " . $_SESSION['sessao_usuario_id'] . ";";
                $resultado = mysql_query($sql) or die("Query invalida: " . mysql_error() . $sql);
                $nivel = mysql_fetch_array($resultado);
                if ($nivel['idUsuarioNivel'] > 1) {
                    AbrirJanela('../erro/erro00.php?erro=9');
                    exit();
                }

                // muda a senha para 1234
                $sql = "
                        UPDATE `usuario`
                        SET
                        `senha` = '1234'
                        WHERE `idUsuario` = $idUsuario;
                         ";

                $resultado = mysql_query($sql) or die("Query invalida: " . mysql_error() . $sql);
                ?>
                <p class="FormatText4 destaque alinha">Senha alterada para 1234</p>

                <script type="text/javascript">
                    window.alert('Senha alterada para 1234');
                </script>                

                <?php
                AbrirJanela('formAlterar.php?id=' . $idUsuario);
                ?>

            </div>

            <!--/rodapé-->

            <div class="rodape">
                <br><br>
                <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398
            </div>
        </div>



    </body>
</html>
