<?php
/*
 * inicia a sessão
 */
session_start();

/*
 * constants
 */
require_once '../../config/TConfig.php';

/*
 *  autoload
 */
require_once '../../libs/Autoloader.php';
$loader = new Autoloader();
$loader->directories = array('../../libs', '../../model');
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
 * variáveis externas
 */
$idUnidade = (isset($_POST['idUnidade']) ? strip_tags( trim( $_POST['idUnidade']) ) : 0); 
$idDistrito = (isset($_POST['idDistrito']) ? strip_tags( trim( $_POST['idDistrito']) ) : 0); 

require('../FPDF/fpdf.php');

class PDF extends FPDF {

    function Header() {

        // w h text border ln (0 = ln(0)) fill= false para transparente

        $this->Cell( 40, 50, $this->Image('../../img/logo.jpg', $this->GetX(), $this->GetY(), 33.78), 0, 0, 'L', false );

        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(255, 255, 255);
        $this->SetFont('Arial', '', 14);
        $this->Cell(0, 7, utf8_decode('SisCast - Pedidos de Agendamento Público'), 1, 1, 'L', 1);
 
        $this->Ln(4);

        $this->SetFillColor(200);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 5, utf8_decode('Relatório de Pedidos'), 1, 1, 'C', 1);
        
        $this->Ln(2);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 11);
        $this->Cell(0, 1, '', 'T', 1, 'L');
        $this->Cell(93, 5, date('d/m/Y H:m:s'), 0, 0, 'L');
        $this->Cell(93, 5, utf8_decode('Página ' . $this->PageNo() . ' de {nb}'), 0, 0, 'R');
    }

}
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(15, 15, 15);
$pdf->SetFont('Arial', '', 14);

$query = "SELECT 
	pedidos.id,
	concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigoInterno,
	date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
	pedidos.nome,
    pedidos.cpf,
    date_format(pedidos.nascimento, '%d/%m/%y') as dataNascimento,
	concat(pedidos.endereco, ' nº', pedidos.numero, ' ', pedidos.complemento, ' bairro:', pedidos.bairro, ' ', pedidos.cep, ' ') as logradouro,
    
    pedidos.nomeAnimal,
	pedidos.especie,
	pedidos.genero,
	pedidos.porte,
    racas.descricao as raca,
        
    coalesce(pedidos.primeiraTentativa, 'Não realizada') as primeiraTentativa,
    date_format(pedidos.primeiraTentativaQuando, '%d/%m/%y') as primeiraTentativaQuando,
    pedidos.primeiraTentativaHora,
    
    coalesce(pedidos.segundaTentativa, 'Não realizada') as segundaTentativa,
    date_format(pedidos.segundaTentativaQuando, '%d/%m/%y') as segundaTentativaQuando,
    pedidos.segundaTentativaHora,
    
    situacoes.nome as situacao
from pedidos
	inner join situacoes on (pedidos.situacao_id = situacoes.id)
    inner join racas on (racas.id = pedidos.raca_id)
    
where 1=1

order by pedidos.id;";

TDBConnection::prepareQuery($query);

// DBConnection::bindParamQuery(':idUnidade', $idUnidade, PDO::PARAM_INT);
// TDBConnection::bindParamQuery(':idDistrito', $idDistrito, PDO::PARAM_INT);
$pedidos = TDBConnection::resultset();

    $pdf->SetFont('Arial', '', 11);
    $pdf->AddPage();

foreach ($pedidos as $pedido) {
    

    
    $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode('Data/hora'), 1, 0, 'L');
    $pdf->Cell(126, 6, utf8_decode('Nome'), 1, 0, 'L');
    $pdf->Ln();    
    $pdf->Cell(30, 6, utf8_decode($pedido->codigoInterno), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode($pedido->quandoFormatado), 1, 0, 'L');
    $pdf->Cell(126, 6, utf8_decode($pedido->nome), 1, 0, 'L');
    $pdf->Ln();
    
    $pdf->Cell(126, 6, utf8_decode('Endereço'), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode('Nascimento'), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode('CPF'), 1, 0, 'L');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(126, 6, utf8_decode($pedido->logradouro), 1, 0, 'L');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(30, 6, utf8_decode($pedido->dataNascimento), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode($pedido->cpf), 1, 0, 'L');
    $pdf->Ln();
    
    $pdf->Cell(100, 6, utf8_decode('Nome do Animal'), 1, 0, 'L');
    $pdf->Cell(36, 6, utf8_decode('Raça'), 1, 0, 'L');
    $pdf->Cell(20, 6, utf8_decode('Espécie'), 1, 0, 'L');
    $pdf->Cell(10, 6, utf8_decode('G'), 1, 0, 'L');
    $pdf->Cell(20, 6, utf8_decode('Porte'), 1, 0, 'L');
    $pdf->Ln();
    $pdf->Cell(100, 6, utf8_decode($pedido->nomeAnimal), 1, 0, 'L');
    $pdf->Cell(36, 6, utf8_decode($pedido->raca), 1, 0, 'L');
    $pdf->Cell(20, 6, utf8_decode($pedido->especie), 1, 0, 'L');
    $pdf->Cell(10, 6, utf8_decode($pedido->genero), 1, 0, 'L');
    $pdf->Cell(20, 6, utf8_decode($pedido->porte), 1, 0, 'L');
    $pdf->Ln();
    
    $pdf->Cell(80, 6, utf8_decode('Primeira Tentativa: ' . $pedido->primeiraTentativa), 1, 0, 'L');
    $pdf->Cell(53, 6, utf8_decode('Data: ' . $pedido->primeiraTentativaQuando), 1, 0, 'L');
    $pdf->Cell(53, 6, utf8_decode('Hora:'  . $pedido->primeiraTentativaHora), 1, 0, 'L');
    $pdf->Ln();
    
    $pdf->Cell(80, 6, utf8_decode('Segunda Tentativa: ' . $pedido->segundaTentativa), 1, 0, 'L');
    $pdf->Cell(53, 6, utf8_decode('Data: ' . $pedido->segundaTentativaQuando), 1, 0, 'L');
    $pdf->Cell(53, 6, utf8_decode('Hora:'  . $pedido->segundaTentativaHora), 1, 0, 'L');
    $pdf->Ln();
    
    $pdf->Cell(186, 6, utf8_decode('Situação: ' . $pedido->situacao), 1, 0, 'L');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln(); 

}

$pdf->Output('Relatório de Pedidos ' . date('d-m-Y G:i:s') . '.pdf', 'D');
?>