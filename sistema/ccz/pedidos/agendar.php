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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // recebi e formata as variáveis

                /* dados do pedinte */
                $idPedido = (isset($_POST['idPedido']) ? strip_tags(trim($_POST['idPedido'])) : '');
                $situacao_id = (isset($_POST['situacao_id']) ? strip_tags(trim($_POST['situacao_id'])) : '');
                $primeiraTentativa = (isset($_POST['primeiraTentativa']) ? strip_tags(trim($_POST['primeiraTentativa'])) : 'N');
                $primeiraTentativaQuando = (isset($_POST['primeiraTentativaQuando']) ? strip_tags(trim($_POST['primeiraTentativaQuando'])) : null);
                $primeiraTentativaHora = (isset($_POST['primeiraTentativaHora']) ? strip_tags(trim($_POST['primeiraTentativaHora'])) : '');
                $segundaTentativa = (isset($_POST['segundaTentativa']) ? strip_tags(trim($_POST['segundaTentativa'])) : 'N');
                $segundaTentativaQuando = (isset($_POST['segundaTentativaQuando']) ? strip_tags(trim($_POST['segundaTentativaQuando'])) : null);
                $segundaTentativaHora = (isset($_POST['segundaTentativaHora']) ? strip_tags(trim($_POST['segundaTentativaHora'])) : '');
                $nota = (isset($_POST['nota']) ? strip_tags(trim($_POST['nota'])) : '');
                $agendaQuando = (isset($_POST['agendaQuando']) ? strip_tags(trim($_POST['agendaQuando'])) : null);
                $motivoNaoAgendado = (isset($_POST['motivoNaoAgendado']) ? strip_tags(trim($_POST['motivoNaoAgendado'])) : '');
                $agendaTurno = (isset($_POST['agendaTurno']) ? strip_tags(trim($_POST['agendaTurno'])) : null);


                if ($primeiraTentativaQuando == '') {
                    $primeiraTentativaQuando = '0000-00-00 00:00:00';
                }

                if ($segundaTentativaQuando == '') {
                    $segundaTentativaQuando = '0000-00-00 00:00:00';
                }

                if ($agendaQuando == '') {
                    $agendaQuando = '0000-00-00 00:00:00';
                }

                /* validação dos dados */


                /* alteração */
                TDBConnection::beginTransaction();

                TDBConnection::prepareQuery("
                                                    UPDATE pedidos
                                                    SET
                                                    situacao_id = :situacao_id,
                                                    primeiraTentativa = :primeiraTentativa,
                                                    primeiraTentativaQuando = :primeiraTentativaQuando,
                                                    primeiraTentativaHora = :primeiraTentativaHora,
                                                    segundaTentativa = :segundaTentativa,
                                                    segundaTentativaQuando = :segundaTentativaQuando,
                                                    segundaTentativaHora = :segundaTentativaHora,
                                                    nota = :nota,
                                                    agendaQuando = :agendaQuando,
                                                    agendaTurno = :agendaTurno,
                                                    motivoNaoAgendado = :motivoNaoAgendado
                                                    WHERE id = :id;");

                TDBConnection::bindParamQuery(':id', $idPedido, PDO::PARAM_INT);
                TDBConnection::bindParamQuery(':situacao_id', $situacao_id, PDO::PARAM_INT);
                TDBConnection::bindParamQuery(':primeiraTentativa', $primeiraTentativa, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':primeiraTentativaQuando', $primeiraTentativaQuando, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':primeiraTentativaHora', $primeiraTentativaHora, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':segundaTentativa', $segundaTentativa, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':segundaTentativaQuando', $segundaTentativaQuando, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':segundaTentativaHora', $segundaTentativaHora, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':nota', $nota, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':agendaQuando', $agendaQuando, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':agendaTurno', $agendaTurno, PDO::PARAM_STR);
                TDBConnection::bindParamQuery(':motivoNaoAgendado', $motivoNaoAgendado, PDO::PARAM_STR);

                $result = TDBConnection::execute();

                TDBConnection::endTransaction();
            }

            TDBConnection::prepareQuery("
                        SELECT pedidos.*,
                        date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
                        date_format(pedidos.nascimento, '%d/%m/%y') as nasci,
                        concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigoInterno,
                        racas.descricao as raca,
                        situacoes.nome as situacao

                        from pedidos inner join racas on (pedidos.raca_id = racas.id)
                                     inner join situacoes on (pedidos.situacao_id = situacoes.id)
                         where pedidos.id = :id;");
            TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
            $pedido = TDBConnection::single();
            $nRows = TDBConnection::rowCount();
            ?>


            <div class="conteudo">


                <div class="codprotocolo">
                    Código: <?php echo $pedido->codigoInterno ?>
                </div>


                <fieldset>
                    <div class="subtitulo">
                        Data: <?php echo $pedido->quandoFormatado ?> - Tutor: <strong><?php echo $pedido->nome ?></strong>
                    </div>

                    <div>
                        Endereço : <?php echo $pedido->endereco ?>, Nº <?php echo $pedido->numero ?> Bairro <?php echo $pedido->bairro ?> Complemento <?php echo $pedido->complemento ?> - CEP: <?php echo $pedido->cep ?>. <?php echo $pedido->cidade ?>, <?php echo $pedido->estado ?>
                        <br>Tel: <?php echo $pedido->tel ?>/Cel <?php echo $pedido->cel ?>. E-mail:<?php echo $pedido->email ?><br>
                        Nome do animal: <strong><?php echo $pedido->nomeAnimal ?></strong>
                        Genero: <?php echo $pedido->genero ?>, Porte: <?php echo $pedido->porte ?>, Idade: <?php echo $pedido->idade ?> <?php echo $pedido->idadeEm ?>(s) , Cor: <?php echo $pedido->cor ?>, Espécie: <?php echo $pedido->especie ?>, Raça: <?php echo $pedido->raca ?>, Procedência: <?php echo $pedido->procedencia ?>.
                    </div>
                </fieldset>

                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" >

                    <input name="idPedido" type="hidden" id="idPedido"
                           value="<?php echo $id; ?>">

                    <fieldset>
                        <legend>Situação do Pedido:</legend>

                        <label for="situacao_id">Situação:</label>
                        <select name="situacao_id" id="situacao_id">
                            <option value="<?php echo $pedido->situacao_id ?>" selected>&rarr;<?php echo $pedido->situacao ?></option>
                            <?php
                            TDBConnection::prepareQuery("select * from situacoes order by nome;");
                            $situacoes = TDBConnection::resultset();
                            foreach ($situacoes as $situacao) {
                                echo "<option value=\"$situacao->id\">$situacao->nome</option>" . EOL;
                            }
                            ?>
                        </select>

                    </fieldset>

                    <fieldset>
                        <legend>1º Tentativa:</legend>

                        <input type="checkbox" name="primeiraTentativa" value="S" <?php echo (($pedido->primeiraTentativa == 'S') ? 'checked' : '' ) ?>>

                        <input type="date" name="primeiraTentativaQuando" id="primeiraTentativaQuando" value="<?php echo ( strtotime($pedido->primeiraTentativaQuando) != 0 ? date('Y-m-d', strtotime($pedido->primeiraTentativaQuando)) : '') ?>">

                        Horário:<input type="text" name="primeiraTentativaHora" id="primeiraTentativaHora" maxlength="12" size="10" value="<?php echo $pedido->primeiraTentativaHora ?>">
                    </fieldset>

                    <fieldset>
                        <legend>2º Tentativa:</legend>

                        <input type="checkbox" name="segundaTentativa" value="S" <?php echo (($pedido->segundaTentativa == 'S') ? 'checked' : '' ) ?>>

                        <input type="date" name="segundaTentativaQuando" id="segundaTentativaQuando" value="<?php echo ( strtotime($pedido->segundaTentativaQuando) != 0 ? date('Y-m-d', strtotime($pedido->segundaTentativaQuando)) : '') ?>">

                        Horário:<input type="text" name="segundaTentativaHora" id="segundaTentativaHora" maxlength="12" size="10" value="<?php echo $pedido->segundaTentativaHora ?>">
                    </fieldset>


                    <fieldset>
                        <legend>Agendar:</legend>

                        <input type="date" name="agendaQuando" id="agendaQuando" value="<?php echo ( strtotime($pedido->agendaQuando) != 0 ? date('Y-m-d', strtotime($pedido->agendaQuando)) : '') ?>">
                        <input type="radio" name="agendaTurno" value="manha" <?php echo (($pedido->agendaTurno == 'manha') ? 'checked' : '' ) ?>>Manhã
                        <input type="radio" name="agendaTurno" value="tarde" <?php echo (($pedido->agendaTurno == 'tarde') ? 'checked' : '' ) ?>>Tarde
                    </fieldset>

                    <fieldset>
                        <legend>Observações:</legend>

                        <label for="nota">Notas:</label>
                        <input type="text" name="nota" id="nota" maxlength="200" size="36" value="<?php echo $pedido->nota ?>"><br><br>

                        <label for="motivoNaoAgendado">Motivo:</label>
                        <input type="text" name="motivoNaoAgendado" id="motivoNaoAgendado" maxlength="120" size="36" value="<?php echo $pedido->motivoNaoAgendado ?>">

                    </fieldset>

                    <div class="alinha">
                        <input type="submit" name="Allterar" id="Allterar"
                               value="Alterar Pedido">
                    </div>


                </form>

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

