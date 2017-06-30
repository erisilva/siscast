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
    <title>SisCast - Pedidos de Agendamento Público</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <script type="text/javascript" src="cpf.js"></script>
    <body>
        <div class="estrutura_popup">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1 class="alinha">Pedido de Castrações</h1>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">

                <!--/ banner-->
                <div>
                    <img src="../img/banner.jpg" alt="logoContagem">
                </div>
                <br>

                <!--/ fazer um novo pedido-->
                <div>
                    <form name="cadastrar" id="cadastrar" method="post" action="cadastro.php">
                        <fieldset>

                            <div class="alinha">
                                <input type="submit" name="botao_cadastro" id="botao_cadastro" value="Fazer um Pedido de Agendamento">
                            </div>

                        </fieldset>
                    </form>  
                </div>
                <br>              

                <!--/ quantitativo de agendas-->
                <br>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Ano</th>
                                <th>Mês</th>
                                <th class="alinha_direita">Agendados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2017</td>
                                <td>Junho</td>
                                <td class="alinha_direita">0</td>
                            </tr>

                            <tr>
                                <td>2017</td>
                                <td>Julho</td>
                                <td class="alinha_direita">0</td>
                            </tr>                            
                        </tbody>
                    </table>
                    <p class="alinha">Total de agendas realizadas: 0000</p>
                </div>

                <!--/rodapé-->
                <br/>
                <div class="rodape">
                    <p>
                        <strong>Central de Controle de Zoonoses</strong><br>
                        Telefone: 1111-1111<br>
                        E-mail: email@email.com.br
                    </p>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
            <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
            <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
            <!-- scripts da página -->
    </body>
</html>

