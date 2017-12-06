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
                <?php
                TDBConnection::prepareQuery("select (YEAR(CURDATE()) - YEAR(nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(nascimento,5)) AS age, 
                                                  cep, id, cidade from pedidos where situacao_id = 1;");
                $pedidos = TDBConnection::resultset();
                foreach ($pedidos as $pedido){

                    $erro = "";

                    if ($pedido->age < 18) {
                        $erro = "Não é aceito cadastro de menores de idade. idade " . $pedido->age . " anos.";
                    }

                    if (!isset($pedido->cidade)) {

                        $cep = strip_tags( trim( filter_var($pedido->cep, FILTER_SANITIZE_NUMBER_INT) ));


                        $logradouro = TCommon::busca_cep_viacep_querty($cep);

                        if (isset($logradouro['erro'])) {
                            $erro .= " CEP inválido ou não encontrado.";
                            TDBConnection::prepareQuery("update pedidos set cidade = :cidade, estado = :estado where id = :id;");
                            TDBConnection::bindParamQuery(':cidade', 'Não cadastrado', PDO::PARAM_STR);
                            TDBConnection::bindParamQuery(':estado', 'NO', PDO::PARAM_STR);
                            TDBConnection::bindParamQuery(':id', $pedido->id, PDO::PARAM_INT);
                            TDBConnection::execute();
                        } else {
                            if ($logradouro['localidade'] != "Contagem"){
                                $erro .= "Localização inválida: " . $logradouro['localidade']  . ", " . $logradouro['uf'] . ".";
                            }
                            // salva os valores que vierem da tabela do viacep
                            TDBConnection::prepareQuery("update pedidos set cidade = :cidade, estado = :estado where id = :id;");
                            TDBConnection::bindParamQuery(':cidade', $logradouro['localidade'], PDO::PARAM_STR);
                            TDBConnection::bindParamQuery(':estado', $logradouro['uf'], PDO::PARAM_STR);
                            TDBConnection::bindParamQuery(':id', $pedido->id, PDO::PARAM_INT);
                            TDBConnection::execute();
                        }

                        $erro .= " Sem cidade cadastrada. $cep. Localidade do cep: " . $logradouro['localidade'];

                    }

/*                    if (!isset($pedido->cidade)) {
                        $cep = strip_tags( trim( $pedido->cep ));
                        if (isset($cep) && !empty($cep)) {
                            $logradouro = TCommon::busca_cep_viacep_querty($cep);

                            echo $logradouro['localidade'] . "<br>";

                            if (isset($logradouro['erro'])) {
                                $erro .= " CEP inválido ou não encontrado.";
                            } else {
                                if ($logradouro['localidade'] != "Contagem"){
                                    $erro .= "Localização inválida: " . $logradouro['localidade']  . ", " . $logradouro['uf'] . ".";
                                }
                                // salva os valores que vierem da tabela do viacep
                                TDBConnection::prepareQuery("update pedidos set cidade = :cidade, estado = :estado where id = :id;");
                                TDBConnection::bindParamQuery(':cidade', $logradouro['localidade'], PDO::PARAM_STR);
                                TDBConnection::bindParamQuery(':estado', $logradouro['uf'], PDO::PARAM_STR);
                                TDBConnection::bindParamQuery(':id', $_POST['token'], PDO::PARAM_INT);
                                TDBConnection::execute();
                            }
                        } else {
                            $erro .= " Cep não foi prenchido.";
                        }
                    }*/



                    if ($erro != "") {
                        echo "<p>" . $pedido->id ."   $erro</p>";
                    }

                }
                ?>
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

    <script>

        $(document).ready(function() {
            setInterval(function() {
                cache_clear()
            }, 60000);
        });

        function cache_clear() {
            window.location.reload(true);
            // window.location.reload(); use this if you do not remove cache
        }

    </script>
</html>

