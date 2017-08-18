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
                <img src="../img/logo.png" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1 class="alinha">Cadastro para Esterilização de Animais</h1>
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
 
                        <fieldset>

                            <p class="alinha"><a href="cadastro.php">Fazer Cadastro para Esterilização de Animais</a></p>

                            <?php 
                            TDBConnection::prepareQuery("SELECT mediaEspera, totalAgendados FROM estatistica ORDER BY id DESC LIMIT 1;");                            
                            $estatistica = TDBConnection::single();
                            ?>
                            
                            <p class="alinha">Tempo médio de espera: <?php echo  $estatistica->mediaEspera; ?> dia(s).</p>

                        </fieldset>
 
                </div>
                
                <br> 

                <div>
                    <form name="formConsulta" id="formConsulta" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <fieldset>
                        <legend>Consultar Cadastro:</legend>
                        CPF:<input type="text" name="cpf" id="cpf" maxlength="11" size="8" required>
                        <input type="submit" name="Agendar" id="Agendar" value="consultar">
                     </fieldset>
                   </form>   
                </div>



                <?php


                if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                    $cpf = (isset($_POST['cpf']) ? strip_tags(trim($_POST['cpf'])) : '');

                    $query = "SELECT 
                                        date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
                                        pedidos.nomeAnimal,
                                        pedidos.especie,
                                        situacoes.nome as situacao,
                                        coalesce(date_format(pedidos.agendaquando, '%d/%m/%y'), '-') as agendaQuando,
                                        coalesce(pedidos.agendaTurno, '-') as agendaTurno


                                from pedidos
                                        inner join situacoes on (pedidos.situacao_id = situacoes.id)

                                    where pedidos.cpf = :cpf

                                    order by pedidos.quando desc;";


                    TDBConnection::getConnection();
                    TDBConnection::prepareQuery($query);
                    TDBConnection::bindParamQuery(':cpf', $cpf, PDO::PARAM_INT);
                    $result = TDBConnection::resultset();
                    $nRows = TDBConnection::rowCount();


                    echo "<br>\n";
                    echo "<div class=\"alinha\">\n";
                    echo "<p class=\"destaque\">Pedidos Realizados</p>\n";
                    echo "</div>\n";

                    if ($nRows != 0) {
                        echo "\n";
                        echo "\n";
                        echo "<table>\n";
                        echo "<thead>\n";
                        echo "<tr>\n";
                        //cabeçalho da tabela
                        echo "<th>Data/Hora</th>\n";
                        echo "<th>Nome</th>\n";
                        echo "<th>Situação</th>\n";
                        echo "<th>Agendado para</th>\n";
                        echo "<th>Turno</th>\n";
                        echo "</tr>\n";
                        echo "</thead>\n";
                        echo "<tbody>\n";

                        foreach ($result as $temp) {
                            echo "<tr>\n";

                            echo "<td>\n";
                            echo $temp->quandoFormatado . "\n";
                            echo "</td>\n";

                            echo "<td>\n";
                            echo $temp->nomeAnimal . "\n";
                            echo "</td>\n";

                            echo "<td>\n";
                            echo $temp->situacao . "\n";
                            echo "</td>\n";

                            echo "<td>\n";
                            echo $temp->agendaQuando . "\n";
                            echo "</td>\n";

                            echo "<td>\n";
                            echo $temp->agendaTurno . "\n";
                            echo "</td>\n";

                            echo "</tr>\n";
                        }
                        echo "</tbody>\n";
                        echo "</table>\n";
                    } else {
                        echo "Nenhum pedido foi encontrado para esse cpf.";
                    }
                }    
                ?>                  

                <!--/ quantitativo de agendas-->
                <br>
                <div>
                    <p class="alinha">Total de agendas realizadas: <?php echo  $estatistica->totalAgendados; ?></p>
                </div>

                <!--/rodapé-->
                <br/>
                <div class="rodape">
                    <p>
                        <strong>Centro de Controle de Zoonoses</strong><br>
                        Telefones: 3351-3751 / 3361-7703<br>
                        E-mail: cczcontagem@yahoo.com.br
                    </p>
                </div>
            </div>
            <!-- scripts da página -->
    </body>
</html>

