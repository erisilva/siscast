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

/*
 * recebe os parametros de filtragem 
 */
//$filtroDataInicio = (isset($_POST['filtroDataInicio']) ? $_POST['filtroDataInicio'] : '');
//$filtroDataFim = (isset($_POST['filtroDataFim']) ? $_POST['filtroDataFim'] : '');

$filtroNome = (!isset($_GET["filtroNome"]) ? "%" : $_GET["filtroNome"]);
$filtroCPF = (!isset($_GET["filtroCPF"]) ? "%" : $_GET["filtroCPF"]);
$filtroEspecie = (!isset($_GET["filtroEspecie"]) ? "" : $_GET["filtroEspecie"]);
$filtroGenero = (!isset($_GET["filtroGenero"]) ? "" : $_GET["filtroGenero"]);
$filtroPorte = (!isset($_GET["filtroPorte"]) ? "" : $_GET["filtroPorte"]);
$situacaoFiltro = (!isset($_GET["situacaoFiltro"]) ? "" : $_GET["situacaoFiltro"]);
$ordem = (!isset($_GET["ordem"]) ? 1 : $_GET["ordem"]);

$filtroNomeFormatado = TCommon::FormataNomeFiltro($filtroNome);
$filtroCPFFormatado = TCommon::FormataNomeFiltro($filtroCPF);

/*
 * efetua a consulta 
 */


$statement = " pedidos
                                inner join situacoes on (pedidos.situacao_id = situacoes.id) 
                                inner join racas on (pedidos.raca_id = racas.id)";

/* configurando os filtros */
if ($filtroNome != "") {
    $statement .= " and pedidos.nome like '" . $filtroNomeFormatado . "' ";
}

if ($filtroCPF != "") {
    $statement .= " and pedidos.cpf like '" . $filtroCPFFormatado . "' ";
}

if ($filtroEspecie != "") {
    $statement .= " and pedidos.especie = '" . $filtroEspecie . "' ";
}

if ($filtroGenero != "") {
    $statement .= " and pedidos.genero = '" . $filtroGenero . "' ";
}

if ($filtroPorte != "") {
    $statement .= " and pedidos.porte = '" . $filtroPorte. "' ";
}

if ($situacaoFiltro != "") {
    $statement .= " and pedidos.situacao_id = " . $situacaoFiltro. "";
}


/* configuração da ordenação*/
if ($ordem == 1){
    $statement .= " order by pedidos.id desc";    
} elseif ($ordem == 2) {
    $statement .= " order by pedidos.id asc";
} else {
    $statement .= " order by pedidos.nome";
}


$query = "SELECT 
                                pedidos.id,
                                concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigo_pedido,
                                date_format(pedidos.quando, '%d/%m/%y %H:%i') as data_pedido,
                            pedidos.nome,
                            pedidos.cpf,
                            date_format(pedidos.nascimento, '%d/%m/%y') as nascimento,
                            pedidos.endereco,
                            pedidos.numero,
                            pedidos.bairro,
                            pedidos.complemento,
                            pedidos.cep,
                            pedidos.cns,
                            pedidos.beneficio,
                            pedidos.beneficioQual,
                            pedidos.tel,
                            pedidos.cel,
                            
                            pedidos.nomeAnimal,
                            pedidos.especie,
                            pedidos.genero,
                            pedidos.porte,
                            pedidos.idade,
                            pedidos.idadeEm,
                            pedidos.cor,
                            racas.descricao as raca,
                            pedidos.procedencia,

                            situacoes.nome as situacao "
        . "from {$statement}";

TDBConnection::getConnection();
TDBConnection::prepareQuery($query);
$result = TDBConnection::resultset();
$nRows = TDBConnection::rowCount();

// é importante que a query tenha pelo menos um registro
if ($nRows > 0) {

// pega os campos em forma de uma array da primeira linha da consulta
    $fields = get_object_vars($result[0]);

// cria um array contendo apenas o nome dos atributos do objeto
    $colunas = array_keys($fields);

// monta o header
    $header = "";
    for ($index = 0; $index < count($colunas); $index++) {
        $header .= $colunas[$index] . "\t";
    }

    // debug
    // echo $header;

    $data = "";
    foreach ($result as $linha) {
        $line = "";
        for ($index = 0; $index < count($colunas); $index++) {
            $value = utf8_decode($linha->$colunas[$index]);
            if ((!isset($value) ) || ( $value == "" )) {
                $value = "\t";
            } else {
                $value = str_replace('"', '""', $value);
                $value = str_replace('.', ',', $value);
                $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;
        }
        $data .= trim($line) . "\n";
    }
    $data = str_replace("\r", "", $data);

    //debug
    //echo $data;
} else {
    $header = "";
    $data = "Não foi encontrado nenhum registro";
}

$filename = "Pedidos " . date('dmY-his') . ".xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
?>

