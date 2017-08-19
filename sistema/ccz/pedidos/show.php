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
    <title>SisCast - Impressão de Pedido</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">    
    <link rel="stylesheet" type="text/css" href="../estilo/navegacao.css">    
    <body>
        <div class="estrutura_popup">


            <!--/conteúdo-->
            <?php
            $id = (isset($_GET['id']) ? $_GET['id'] : NULL);

            TDBConnection::prepareQuery("
                        SELECT pedidos.*, 
                        date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado 

                        from pedidos
                         where pedidos.id = :id;");
            TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
            $result = TDBConnection::single();
            $nRows = TDBConnection::rowCount();
            ?>


            <div class="conteudo">

                <div class="subtitulo">
                    Nº: <?php echo $result->id ?> Data: <?php echo $result->quandoFormatado ?> - Nome: <?php echo $result->nome ?>
                </div>
                
                <div>
                    <p>CPF : <?php echo $result->cpf ?></p>
                    <p>Endereço : <?php echo $result->endereco ?>, Nº <?php echo $result->numero ?> Bairro <?php echo $result->bairro ?> Complemento <?php echo $result->complemento ?> - CEP: <?php echo $result->cep ?></p>
                    <p>Tel: <?php echo $result->tel ?>/Cel <?php echo $result->cel ?></p>
                    <p>E-mail: <?php echo $result->email ?></p>
                    <p>Nome do animal: <?php echo $result->nomeAnimal ?></p>
                    <p>Genero: <?php echo $result->genero ?>, Porte: <?php echo $result->porte ?>, Idade: <?php echo $result->idade ?>, Cor: <?php echo $result->cor ?>, Espécie: <?php echo $result->especie ?>, Raça: <?php echo $result->raca ?>, Procedência: <?php echo $result->procedencia ?>.</p>
                </div>


            </div>
            <!--/rodapé-->

            <div>
                <a href="javascript:window.print();">Imprimir</a> <a href="javascript:window.close();"> fechar</a>
            </div>            
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
        <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
        <!-- scripts da página -->
    </body>
</html>

