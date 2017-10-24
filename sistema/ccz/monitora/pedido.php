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
            Monitoramento de Pedidos
        </div>

        <div>
            <?php
            TDBConnection::getConnection();

            TDBConnection::prepareQuery("select situacoes.nome, situacoes.descricao,
                                                (select count(*) from pedidos where pedidos.situacao_id = situacoes.id) as total_por_situacao
                                            from situacoes order by situacoes.nome;");
            $pedidosGeral = TDBConnection::resultset();

            TDBConnection::prepareQuery("select count(*) as total from pedidos;");
            $pedidosTotalGeral = TDBConnection::single();

            TDBConnection::prepareQuery("select date_format(max(pedidos.quando), '%d/%m/%y') as maximo, date_format(min(pedidos.quando), '%d/%m/%y') as minimo from pedidos;");
            $pedidosPeriodoGeral = TDBConnection::single();

            echo "\n";
            echo "\n";
            echo "<p class='destaque alinha'>Total Geral(Entre " . $pedidosPeriodoGeral->minimo . " e " . $pedidosPeriodoGeral->maximo . ")</p>";
            echo "<table>\n";
            echo "<thead>\n";
            echo "    <tr>\n";
            echo "        <th>Situação</th>\n";
            echo "        <th>Descrição</th>\n";
            echo "        <th class=\"alinha\">Total</th>\n";
            echo "    </tr>\n";
            echo "</thead>\n";
            echo "<tfoot>\n";
            echo "    <tr>\n";
            echo "        <th>Total Geral</th>\n";
            echo "        <th></th>\n";
            echo "        <th>" . $pedidosTotalGeral->total .  "</th>\n";
            echo "    </tr>\n";
            echo "</tfoot>\n";
            echo "<tbody>\n";

            foreach ($pedidosGeral as $pedidosGeralItem) {

                echo "<tr>\n";

                echo "<td>\n";
                echo $pedidosGeralItem->nome . "\n";
                echo "</td>\n";

                echo "<td class='fontpequena'>\n";
                echo $pedidosGeralItem->descricao . "\n";
                echo "</td>\n";

                echo "<td class=\"alinha\">\n";
                echo $pedidosGeralItem->total_por_situacao . "\n";
                echo "</td>\n";

                echo "</tr>\n";
            }

            echo "</tbody>\n";
            echo "</table>\n";
            ?>
        </div>

        <br><br>

        <div>
            <form name="formFiltro" id="formFiltro" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <fieldset>
                    <legend>Pedidos :: Consulta Mensal</legend>

                    <select name="mes" id="mes">
                        <option value="0" selected>Selecione um mês</option>
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>

                    Ano:<input type="number" name="ano" id="ano" min="2000" max="2100" value="<?php echo date('Y'); ?>">

                    <input type="submit" name="procurar" id="procurar"
                           value="Buscar">

                    <input type="reset" name="limpar" id="limpar"
                           value="Limpar">
                </fieldset>
            </form>
            <br>
        </div>

        <div>
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ano = (!isset($_POST["ano"]) ? "2017" : $_POST["ano"]);
                $mes = (!isset($_POST["mes"]) ? 1 : $_POST["mes"]);

                echo "\n";
                echo "\n";
                echo "<table>\n";
                echo "<caption><strong>" . TCommon::mes_extensao($mes) . "/" . $ano ."</strong></caption>";
                echo "<thead>\n";
                echo "    <tr>\n";
                echo "        <th>Dia</th>\n";
                echo "        <th></th>\n";
                echo "        <th class=\"alinha_direita\">Em análise</th>\n";
                echo "        <th class=\"alinha_direita\">Reprovado</th>\n";
                echo "        <th class=\"alinha_direita\">Agendado</th>\n";
                echo "        <th class=\"alinha_direita\">Conluido</th>\n";
                echo "        <th class=\"alinha_direita\">Ausente</th>\n";
                echo "        <th class=\"alinha_direita\">Impossibilidade</th>\n";
                echo "        <th class=\"alinha_direita\">Total/Dia</th>\n";
                echo "    </tr>\n";
                echo "</thead>\n";

                TDBConnection::prepareQuery("select situacoes.id,
                                                (select count(*) from 
                                                    pedidos 
                                                    where 
                                                        pedidos.situacao_id = situacoes.id            
                                                        and month(pedidos.quando) = :m and year(pedidos.quando) = :y            
                                                        ) as total_por_situacao
                                            from situacoes order by situacoes.id;
                                            ");
                TDBConnection::bindParamQuery(':m', $mes, PDO::PARAM_INT);
                TDBConnection::bindParamQuery(':y', $ano, PDO::PARAM_INT);
                $pedidosTotalMes = TDBConnection::resultset();

                echo "<tfoot>\n";
                echo "    <tr>\n";
                echo "        <th>Total/Mês</th>\n";
                echo "        <th></th>\n";

                foreach ($pedidosTotalMes as $pedidosTotalMesItem){
                    echo "        <th class=\"alinha_direita\">" . $pedidosTotalMesItem->total_por_situacao . "</th>\n";
                }

                TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    month(pedidos.quando) = :m and year(pedidos.quando) = :y");
                TDBConnection::bindParamQuery(':m', $mes, PDO::PARAM_INT);
                TDBConnection::bindParamQuery(':y', $ano, PDO::PARAM_INT);
                $pedidosTemp = TDBConnection::single();

                echo "        <th class=\"alinha_direita\">" . $pedidosTemp->total . "</th>\n";
                echo "    </tr>\n";
                echo "</tfoot>\n";
                echo "<tbody>\n";

                $month = $mes;
                $year = $ano;

                for($d=1; $d<=31; $d++)
                {
                    $time=mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time)==$month){
                        echo "<tr>\n";

                        echo "<td>\n";
                        echo date('d', $time) . "\n";
                        echo "</td>\n";

                        echo "<td>\n";
                        echo  "<strong>" . TCommon::dia_semana(date('w', mktime(12, 0, 0, $month, $d, $year)) + 1) . "</strong>\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 1");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 2");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 3");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 4");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 5");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y
                                    and pedidos.situacao_id = 6");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        // total de pedidos feitos por dia
                        TDBConnection::prepareQuery("select count(*) as total from pedidos
                                    where 
                                    day(pedidos.quando) = :d and month(pedidos.quando) = :m and year(pedidos.quando) = :y");
                        TDBConnection::bindParamQuery(':d', $d, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':m', $month, PDO::PARAM_INT);
                        TDBConnection::bindParamQuery(':y', $year, PDO::PARAM_INT);
                        $pedidosTemp = TDBConnection::single();
                        echo "<td class=\"alinha_direita\">\n";
                        echo $pedidosTemp->total . "\n";
                        echo "</td>\n";

                        echo "</tr>\n";

                    }
                }

                echo "</tbody>\n";
                echo "</table>\n";
            }
            ?>
        </div>

        <br>
        <br>


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

