<?php
/*
 * inicia a sessão
 */
session_start();

/*
 * constants
 */
require_once 'config/TConfig.php';

/*
 *  autoload
 */
require_once 'libs/Autoloader.php';
$loader = new Autoloader();
$loader->directories = array('libs', 'model');
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
<link rel="icon" href="img/favicon.ico">
<title>SisCast - Pedidos de Agendamento Público</title>
<link rel="stylesheet" type="text/css" href="estilo/estilo.css">
<script type="text/javascript" src="cpf.js"></script>
<body>
<div class="estrutura_popup">
    <div class="conteudo">
        <div>
            <img src="img/banner.png" alt="Banner">
        </div>
        <br>
        <!--/ fazer um novo pedido-->
        <div>

            <fieldset>

                <p class="alinha"><a href="cadastro.php" style="font-size: 24px;">Clique Aqui para Fazer seu Cadastro</a></p>

                <?php
                TDBConnection::prepareQuery("SELECT mediaEspera, totalAgendados FROM estatistica ORDER BY id DESC LIMIT 1;");
                $estatistica = TDBConnection::single();

                // retorna um array

                function busca_cep($cep){
                    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');

                    if(!$resultado){
                        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
                    }
                    parse_str($resultado, $retorno);
                    return $retorno;
                }


                /*
                 * Exemplo de utilização
                 */

                //Vamos buscar o CEP 90020022
                $resultado_busca = busca_cep('32223-130');

                echo "<pre> Array Retornada: ".print_r($resultado_busca, true)."</pre>";


                ?>

<!--                <p class="alinha">Tempo médio de espera: --><?php //echo  $estatistica->mediaEspera; ?><!-- dia(s).</p>-->

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
                                        coalesce(date_format(pedidos.agendaquando, '%d/%m/%y'), '(não marcado)') as agendaQuando,
                                        coalesce(pedidos.agendaTurno, '(não marcado)') as agendaTurno,
                                        pedidos.motivoNaoAgendado


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
            echo "<h1 class=\"destaque\">Cadastros Realizados para o CPF $cpf</h1>\n";
            echo "</div>\n";

            if ($nRows != 0) {
                foreach ($result as $temp) {
                    echo "<div class=\"pedidos\">\n";
                    echo "<h1>Nome do Animal: " . $temp->nomeAnimal . "</h1>\n";
                    echo "<p>Data/Hora do Cadastro: " . $temp->quandoFormatado . "</p>\n";
                    echo "<p class=\"atencao destaque\">Situação:" . $temp->situacao . "</p>\n";
                    echo "<p>Agendado para: " . $temp->agendaQuando . "   Turno: " . $temp->agendaTurno . "</p>\n";
                    echo "<p>Observações: " . $temp->motivoNaoAgendado . "</p>\n";
                    echo "</div>\n";
                    echo "<br>\n";
                }
            } else {
                echo "Nenhum cadastro foi realizado para esse cpf.";
            }
        }
        ?>

        <!--/ quantitativo de agendas-->
        <br>

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

