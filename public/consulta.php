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

/*
 * segurança
 * para toda requisição é feita a criação de um token aleatorio
 * se não existir nenhum token de sessao ao se solicitar
 * a pagina é criado um token
 */
if (!isset($_SESSION['token'])){
    date_default_timezone_set('America/Sao_Paulo');
    $token = md5(uniqid(rand(), TRUE));
    $quando = date("Y-m-d H:i:s");
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();

    /* captura o e-mail da origem da requisição dessa página */     
    $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    /* Grava o logacesso com o ip origem da requisição, juntamente com token com a data/hora */
    /* ERRO MEU: eu chamei o campo de data/hora de description em vez de quando como uso. Vou arrumar algum dia.*/
    TDBConnection::beginTransaction();
    TDBConnection::prepareQuery("INSERT INTO logacesso VALUES (null, :token, :ip, :description);");
    TDBConnection::bindParamQuery(':token', $token, PDO::PARAM_STR);
    TDBConnection::bindParamQuery(':ip', $ip, PDO::PARAM_STR);
    TDBConnection::bindParamQuery(':description', $quando, PDO::PARAM_STR);
    TDBConnection::execute();
    TDBConnection::endTransaction();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="author" content="EriSilva, erisilva.net, www.erisilva.net, erivelton.contagem@gmail.com">
    <meta name="description" content="Levantamento e Cadastro de Pedidos para Esterilização de Animais no Município de Contagem-MG, Brasil.">
    <meta name="keywords" content="pedidos, esterilização, animais, pets, cadastro, levantamento, saúde, contagem">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
    <link rel="icon" href="img/favicon.png">

    <title>SisCast - Pedidos de Agendamento Público</title>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand" >
                        <img src="img/logo.png" class="img-rounded" alt="Logotipo Contagem" height="60">
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Início</a></li>
                        <li><a href="cadastro.php"><span class="glyphicon glyphicon-plus-sign"></span>Fazer um Cadastro</a></li>
                        <li><a href="consulta.php"><span class="glyphicon glyphicon-search"></span>Consultar Cadastro</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <h1 class="text-center">Cadastro para Esterilização de Cães e Gatos</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Consultar Cadastro
                        </div>
                        <br>
                        <form class="form-horizontal" method="post"
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="cpf">CPF:</label>
                                <div class="col-md-6">
                                    <input type="cpf" class="form-control" id="cpf" name="cpf" placeholder="Digite aqui seu cpf">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                                </div>
                            </div>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $_POST['cpf'] = trim($_POST['cpf']);
                            if (isset($_POST['cpf']) && !empty($_POST['cpf'])) {
                                $cpf = strip_tags($_POST['cpf']);
                            } else {
                                $cpf = '';
                            }

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
                            $pedidos = TDBConnection::resultset();
                            $pedidosResultadoTotal = TDBConnection::rowCount();

                            echo "<br>\n";

                            if ($pedidosResultadoTotal != 0) {

                                echo "<div class=\"container\">\n";
                                echo "<h3>Pedidos Realizados para o cpf $cpf:</h3>\n";
                                echo "</div>\n";
                                echo "\n";
                                echo "\n";
                                echo "<div class=\"table-responsive\">\n";
                                echo "<table class=\"table table-striped\">\n";
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

                                foreach ($pedidos as $pedido) {
                                    echo "<tr>\n";

                                    echo "<td>\n";
                                    echo $pedido->quandoFormatado . "\n";
                                    echo "</td>\n";

                                    echo "<td>\n";
                                    echo $pedido->nomeAnimal . "\n";
                                    echo "</td>\n";

                                    echo "<td>\n";
                                    echo $pedido->situacao . "\n";
                                    echo "</td>\n";

                                    echo "<td>\n";
                                    echo $pedido->agendaQuando . "\n";
                                    echo "</td>\n";

                                    echo "<td>\n";
                                    echo $pedido->agendaTurno . "\n";
                                    echo "</td>\n";

                                    echo "</tr>\n";
                                }
                                echo "</tbody>\n";
                                echo "</table>\n";
                                echo "</div>\n";
                            } else {

                                echo "<div class=\"alert alert-success alert-dismissable\">\n";
                                echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>\n";
                                echo "<strong>Atenção!</strong> Não existem pedidos relacionados ao cpf $cpf.\n";
                                echo "</div>\n";

                            }


                        }



                        ?>
                    </div>
                </div>
            </div>
        </div>


        <footer class="container-fluid text-center">
            <p>
                <strong>Centro de Controle de Zoonoses</strong><br>
                Telefones: 3351-3751 / 3361-7703<br>
                E-mail: cczcontagem@yahoo.com.br
            </p>
        </footer>
    </body>
</html>

