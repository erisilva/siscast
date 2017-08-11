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
    <title>SisCast - Conclusão de Pedido</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Cadastro para Esterilização de Animais</h1>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">

                <div>

                    <fieldset>

                        <p class="destaque">Seu pedido foi enviado com sucesso.</p>

                    </fieldset>                    

                </div>

                <br>
                <div class="alinha">
                    <p>Pedidos realizados</p>
                </div>
                <?php
                $cpf = (isset($_GET['cpf']) ? strip_tags(trim($_GET['cpf'])) : '');

                $query = "SELECT 
                                    pedidos.id,
                                    concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigoInterno,
                                    date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
                                    pedidos.nomeAnimal,
                                    pedidos.especie,
                                    pedidos.genero,
                                    pedidos.porte,
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

                if ($nRows != 0) {
                    echo "\n";
                    echo "\n";
                    echo "<table>\n";
                    echo "<thead>\n";
                    echo "<tr>\n";
                    //cabeçalho da tabela
                    echo "<th class=\"alinha_direita\">Código</th>\n";
                    echo "<th>Data/Hora</th>\n";
                    echo "<th>Animal</th>\n";
                    echo "<th>Espécie</th>\n";
                    echo "<th>Gênero</th>\n";
                    echo "<th>Situação</th>\n";
                    echo "<th>Agendado para</th>\n";
                    echo "<th>Turno</th>\n";
                    echo "</tr>\n";
                    echo "</thead>\n";
                    echo "<tbody>\n";

                    foreach ($result as $temp) {
                        echo "<tr>\n";

                        echo "<td class=\"alinha_direita\">\n";
                        echo $temp->codigoInterno . "\n";
                        echo "</td>\n";

                        echo "<td>\n";
                        echo $temp->quandoFormatado . "\n";
                        echo "</td>\n";

                        echo "<td>\n";
                        echo $temp->nomeAnimal . "\n";
                        echo "</td>\n";

                        echo "<td>\n";
                        echo $temp->especie . "\n";
                        echo "</td>\n";

                        echo "<td>\n";                       
                        $genero_temp = ($temp->genero == 'M') ? 'Macho' : 'Fêmea'; 
                        echo $genero_temp . "\n";
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
                    echo "Nenhum registro foi encontrado.";
                }
                ?>  

                <br>               

                <div class="alinha">
                    <a href="index.php">Voltar</a>
                </div>

                <!--/rodapé-->
                <br/><br/>
                <div class="rodape">
                    <p>
                        <strong>Centro de Controle de Zoonoses</strong><br>
                        Telefones: 3351-3751 / 3361-7703<br>
                        E-mail: cczcontagem@yahoo.com.br
                    </p>
                </div>
            </div>

            <!-- scripts da página -->
        </div>    
    </body>
</html>

