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
    <link rel="stylesheet" type="text/css" href="../estilo/navegacao.css">    
    <body>
        <div class="estrutura">

            <!--/conteúdo-->

            <div class="conteudo">

                <div class="loading">
                    <img src="../img/loading.gif" alt="loadinggif" class="imagem_loading"> 
                </div>

            </div>

        </div>

    </body>
</html>

<?php
$nome = (isset($_POST['nome']) ? $_POST['nome'] : '');
$cpf = (isset($_POST['cpf']) ? $_POST['cpf'] : '');
$endereco = (isset($_POST['endereco']) ? $_POST['endereco'] : '');
$numero = (isset($_POST['numero']) ? $_POST['numero'] : '');
$complemento = (isset($_POST['complemento']) ? $_POST['complemento'] : '');
$bairro = (isset($_POST['bairro']) ? $_POST['bairro'] : '');
$cep = (isset($_POST['cep']) ? $_POST['cep'] : '');
$tel = (isset($_POST['tel']) ? $_POST['tel'] : '');
$cel = (isset($_POST['cel']) ? $_POST['cel'] : '');
$email = (isset($_POST['email']) ? $_POST['email'] : '');
$nomeAnimal = (isset($_POST['nomeAnimal']) ? $_POST['nomeAnimal'] : '');
$genero = (isset($_POST['genero']) ? $_POST['genero'] : '');
$porte = (isset($_POST['porte']) ? $_POST['porte'] : '');
$idade = (isset($_POST['idade']) ? $_POST['idade'] : '');
$cor = (isset($_POST['cor']) ? $_POST['cor'] : '');
$especie = (isset($_POST['especie']) ? $_POST['especie'] : '');
$raca = (isset($_POST['raca']) ? $_POST['raca'] : '');
$procedencia = (isset($_POST['procedencia']) ? $_POST['procedencia'] : '');


TDBConnection::beginTransaction();
TDBConnection::prepareQuery("INSERT INTO pedidos
(id,
cpf,
nome,
endereco,
numero,
bairro,
complemento,
cep,
tel,
cel,
email,
nomeAnimal,
genero,
porte,
idade,
cor,
especie,
raca,
procedencia,
quando)
VALUES
(null,
:cpf,
:nome,
:endereco,
:numero,
:bairro,
:complemento,
:cep,
:tel,
:cel,
:email,
:nomeAnimal,
:genero,
:porte,
:idade,
:cor,
:especie,
:raca,
:procedencia,
now());");
TDBConnection::bindParamQuery(':cpf', $cpf, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':nome', $nome, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':endereco', $endereco, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':numero', $numero, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':bairro', $bairro, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':complemento', $complemento, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':cep', $cep, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':tel', $tel, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':cel', $cel, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':email', $email, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':nomeAnimal', $nomeAnimal, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':genero', $genero, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':porte', $porte, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':idade', $idade, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':cor', $cor, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':especie', $especie, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':raca', $raca, PDO::PARAM_STR);
TDBConnection::bindParamQuery(':procedencia', $procedencia, PDO::PARAM_STR);

$result = TDBConnection::execute();
TDBConnection::endTransaction();



header("Location: ..\cadastro.php");
exit;
?>





