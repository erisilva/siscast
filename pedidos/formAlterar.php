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
$loader->directories = array('libs', 'model');
$loader->register();

/*
 * valida sessão
 */
if (!isset($_SESSION['sessao_usuario_id'])) {
    session_destroy();
    header("Location: ../index.php");
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
    <title>SisCast - Alteração de Pedido</title>

    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">



    <body>
        <div class="estrutura_popup">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>SisCast - Sistema de Agenda de Castrações</h1>
            </div>


            <!--/conteúdo-->
            <div class="">

                <?php
                $id = (isset($_GET['id']) ? strip_tags(trim($_GET['id'])) : 0);

                // executa o cadastro se possível
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // recebi e formata as variáveis

                    /* dados do pedinte */
                    $idPedido = (isset($_POST['idPedido']) ? strip_tags(trim($_POST['idPedido'])) : '');
                    $nome = (isset($_POST['nome']) ? strip_tags(trim($_POST['nome'])) : '');
                    $cpf = (isset($_POST['cpf']) ? strip_tags(trim($_POST['cpf'])) : '');
                    $nascimento = (isset($_POST['nascimento']) ? $_POST['nascimento'] : '');
                    //$nascimento = (isset($_POST['nascimento']) ? date("Y-m-d", strtotime($_POST['nascimento'])) : '');

                    /* dados de endereço */
                    $endereco = (isset($_POST['endereco']) ? strip_tags(trim($_POST['endereco'])) : '');
                    $numero = (isset($_POST['numero']) ? strip_tags(trim($_POST['numero'])) : '');
                    $complemento = (isset($_POST['complemento']) ? strip_tags(trim($_POST['complemento'])) : '');
                    $bairro = (isset($_POST['bairro']) ? strip_tags(trim($_POST['bairro'])) : '');
                    $cep = (isset($_POST['cep']) ? strip_tags(trim($_POST['cep'])) : '');
                    $tel = (isset($_POST['tel']) ? strip_tags(trim($_POST['tel'])) : '');
                    $cel = (isset($_POST['cel']) ? strip_tags(trim($_POST['cel'])) : '');

                    /* informações adicionais */
                    $cns = (isset($_POST['cns']) ? strip_tags(trim($_POST['cns'])) : '');
                    $beneficio = (isset($_POST['beneficio']) ? strip_tags(trim($_POST['beneficio'])) : '');
                    $beneficioQual = (isset($_POST['beneficioQual']) ? strip_tags(trim($_POST['beneficioQual'])) : '');

                    /* informações do animal */
                    $nomeAnimal = (isset($_POST['nomeAnimal']) ? strip_tags(trim($_POST['nomeAnimal'])) : '');
                    $genero = (isset($_POST['genero']) ? strip_tags(trim($_POST['genero'])) : '');
                    $porte = (isset($_POST['porte']) ? strip_tags(trim($_POST['porte'])) : '');
                    $idade = (isset($_POST['idade']) ? strip_tags(trim($_POST['idade'])) : 0);
                    $idadeEm = (isset($_POST['idadeEm']) ? strip_tags(trim($_POST['idadeEm'])) : '');
                    $cor = (isset($_POST['cor']) ? strip_tags(trim($_POST['cor'])) : '');
                    $especie = (isset($_POST['especie']) ? strip_tags(trim($_POST['especie'])) : '');
                    $raca_id = (isset($_POST['raca_id']) ? strip_tags(trim($_POST['raca_id'])) : 0);
                    $procedencia = (isset($_POST['procedencia']) ? strip_tags(trim($_POST['procedencia'])) : '');

                    /* validação dos dados */


                    /* alteração */
                    TDBConnection::beginTransaction();
                    
                    TDBConnection::prepareQuery("UPDATE pedidos
                                                    SET
                                                    cpf = :cpf,
                                                    nome = :nome,
                                                    nascimento = :nascimento,
                                                    endereco = :endereco,
                                                    numero = :numero,
                                                    bairro = :bairro,
                                                    complemento = :complemento,
                                                    cep = :cep,
                                                    cns = :cns,
                                                    beneficio = :beneficio,
                                                    beneficioQual = :beneficioQual,
                                                    tel = :tel,
                                                    cel = :cel,
                                                    nomeAnimal = :nomeAnimal,
                                                    genero = :genero,
                                                    porte = :porte,
                                                    idade = :idade,
                                                    idadeEm = :idadeEm,
                                                    cor = :cor,
                                                    especie = :especie,
                                                    raca_id = :raca_id,
                                                    procedencia = :procedencia

                                                    WHERE id = :id;");

                    TDBConnection::bindParamQuery(':id', $idPedido, PDO::PARAM_INT);                    
                    
                    /* pessoa */
                    TDBConnection::bindParamQuery(':cpf', $cpf, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':nome', $nome, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':nascimento', $nascimento, PDO::PARAM_STR);

                    /* endereço */
                    TDBConnection::bindParamQuery(':endereco', $endereco, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':numero', $numero, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':bairro', $bairro, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':complemento', $complemento, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':cep', $cep, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':tel', $tel, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':cel', $cel, PDO::PARAM_STR);

                    /* beneficios da saúde */
                    TDBConnection::bindParamQuery(':cns', $cns, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':beneficio', $beneficio, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':beneficioQual', $beneficioQual, PDO::PARAM_STR);

                    /* animal */
                    TDBConnection::bindParamQuery(':nomeAnimal', $nomeAnimal, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':genero', $genero, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':porte', $porte, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':idade', $idade, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':idadeEm', $idadeEm, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':cor', $cor, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':especie', $especie, PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':raca_id', $raca_id, PDO::PARAM_INT);
                    TDBConnection::bindParamQuery(':procedencia', $procedencia, PDO::PARAM_STR);

                    $result = TDBConnection::execute();

                    TDBConnection::endTransaction();

                }

                TDBConnection::prepareQuery("
                        SELECT pedidos.*, 
                        date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
                        date_format(pedidos.nascimento, '%d/%m/%y') as nasci,
                        concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigoInterno,
                        racas.descricao as raca

                        from pedidos inner join racas on (pedidos.raca_id = racas.id)
                         where pedidos.id = :id;");
                TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
                $pedidos = TDBConnection::single();
                $nRows = TDBConnection::rowCount();
                ?>
                
                <fieldset>
                    <p class="destaque alinha">Código: <?php echo $pedidos->codigoInterno ?></p>
                </fieldset>

                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" >
                    <fieldset>
                        <legend>Informações sobre o tutor:</legend>
                        
                        
                        <input name="idPedido" type="hidden" id="idPedido"
                               value="<?php echo $id; ?>">

                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" maxlength="140" size="36" required autofocus value="<?php echo $pedidos->nome ?>"><br><br>

                        <label for="nascimento">Data Nascimento:</label>
                        <input type="date" name="nascimento" id="nascimento" required value="<?php echo date('Y-m-d', strtotime($pedidos->nascimento)) ?>" ><br><br>

                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" maxlength="11" size="12" required value="<?php echo $pedidos->cpf ?>"><br><br>

                        <label for="endereco">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" maxlength="255" size="36" required value="<?php echo $pedidos->endereco ?>"><br/><br/>                        

                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" maxlength="20" size="9" value="<?php echo $pedidos->numero ?>"> <br><br>

                        <label for="complemento">Complemento:</label>
                        <input type="text" name="complemento" id="complemento" maxlength="60" size="18" value="<?php echo $pedidos->complemento ?>"><br/><br/>  

                        <label for="bairro">Bairro:</label>
                        <input type="text" name="bairro" id="bairro" maxlength="140" size="20" required value="<?php echo $pedidos->bairro ?>"><br/><br/>                       

                        <label for="cep">CEP:</label>
                        <input type="text" name="cep" id="cep" maxlength="10" size="10" required value="<?php echo $pedidos->cep ?>"><br/><br/>                        

                        <label for="tel">Telefone:</label>
                        <input type="text" name="tel" id="tel" maxlength="20" size="10" required value="<?php echo $pedidos->tel ?>">  <br><br>                      

                        <label for="cel">Celular:</label>
                        <input type="text" name="cel" id="cel" maxlength="20" size="10" required value="<?php echo $pedidos->cel ?>"><br/><br/>                        

                        <label for="cns">Possui CNS:</label>
                        <input type="radio" name="cns" id="cns" value="S" required <?php echo (($pedidos->cns == 'S') ? 'checked' : '' ) ?>>Sim
                        <input type="radio" name="cns" id="cns" value="N" <?php echo (($pedidos->cns == 'N') ? 'checked' : '' ) ?>>Não<br>
                        <br>

                        <label for="beneficio">Possui Benefício:</label>
                        <input type="radio" name="beneficio" id="beneficio" value="S" required <?php echo (($pedidos->beneficio == 'S') ? 'checked' : '' ) ?>>Sim
                        <input type="radio" name="beneficio" id="beneficio" value="N" <?php echo (($pedidos->beneficio == 'N') ? 'checked' : '' ) ?>>Não<br><br>

                        <label for="beneficioQual">Qual:</label>
                        <input type="text" name="beneficioQual" id="beneficioQual" maxlength="120" size="20" value="<?php echo $pedidos->beneficioQual ?>"><br/><br/>                        

                    </fieldset>

                    <br>

                    <fieldset>
                        <legend>Informações sobre o animal:</legend>

                        <label for="nomeAnimal">Nome do animal:</label>
                        <input type="text" name="nomeAnimal" id="nomeAnimal" maxlength="120" size="20" required value="<?php echo $pedidos->nomeAnimal ?>"><br/><br/>                       


                        <label for="genero">Gênero:</label>
                        <input type="radio" name="genero" id="genero" value="M" required <?php echo (($pedidos->genero == 'M') ? 'checked' : '' ) ?>>Macho
                        <input type="radio" name="genero" id="genero" value="F" <?php echo (($pedidos->genero == 'F') ? 'checked' : '' ) ?>>Fêmea<br><br>

                        <label for="porte">Porte:</label>
                        <input type="radio" name="porte" id="porte" value="pequeno" required <?php echo (($pedidos->porte == 'pequeno') ? 'checked' : '' ) ?>>Pequeno
                        <input type="radio" name="porte" id="porte" value="medio" <?php echo (($pedidos->porte == 'medio') ? 'checked' : '' ) ?>>Médio
                        <input type="radio" name="porte" id="porte" value="grande" <?php echo (($pedidos->porte == 'grande') ? 'checked' : '' ) ?>>Grande<br><br>

                        <label for="idade">Idade:</label>
                        <input type="number" name="idade" id="idade" min="1" max="20" required value="<?php echo $pedidos->idade ?>"><span><input type="radio" name="idadeEm" id="idadeEm" value="mes" required <?php echo (($pedidos->idadeEm == 'mes') ? 'checked' : '' ) ?>>Mês(es)
                            <input type="radio" name="idadeEm" id="idadeEm" value="ano" <?php echo (($pedidos->idadeEm == 'ano') ? 'checked' : '' ) ?>>Ano(s)</span><br/><br/>


                        <label for="cor">Cor do animal:</label>
                        <input type="text" name="cor" id="cor" maxlength="80" size="20" required value="<?php echo $pedidos->cor ?>"><br/><br/>                       

                        <label for="especie">Espécie:</label>
                        <input type="radio" name="especie" id="especie" value="felino" required <?php echo (($pedidos->especie == 'felino') ? 'checked' : '' ) ?>>Felino
                        <input type="radio" name="especie" id="especie" value="canino" <?php echo (($pedidos->especie == 'canino') ? 'checked' : '' ) ?>>Canino<br><br>

                        <label for="raca_id">raça:</label>
                        <select name="raca_id" id="raca_id" required>
                            <option value="<?php echo $pedidos->raca_id ?>" selected><?php echo $pedidos->raca ?></option>
                            <?php
                            TDBConnection::prepareQuery("select * from racas order by descricao;");
                            $racas = TDBConnection::resultset();
                            foreach ($racas as $raca) {
                                echo "<option value=\"$raca->id\">$raca->descricao</option>" . EOL;
                            }
                            ?>
                        </select><br><br>  

                        <label for="procedencia">Origem:</label>
                        <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" required <?php echo (($pedidos->procedencia == 'vive na rua / comunitario') ? 'checked' : '' ) ?>>vive na rua / comunitário
                        <input type="radio" name="procedencia" id="procedencia" value="resgatado" <?php echo (($pedidos->procedencia == 'resgatado') ? 'checked' : '' ) ?>>Resgatado
                        <input type="radio" name="procedencia" id="procedencia" value="adotado" <?php echo (($pedidos->procedencia == 'adotado') ? 'checked' : '' ) ?>>Adotado
                        <input type="radio" name="procedencia" id="procedencia" value="comprado" <?php echo (($pedidos->procedencia == 'comprado') ? 'checked' : '' ) ?>>Comprado<br><br>                        

                        <br>

                    </fieldset>

                    <br>



                    <div class="alinha">
                        <input type="submit" name="Allterar" id="Allterar"
                               value="Alterar Pedido">
                    </div>


                </form>

                <br>

                <div class="alinha"> 
                    <a href="javascript:window.print();">Imprimir</a> <a href="javascript:window.close();"> Fechar</a>
                </div> 


            </div>
            <!--/rodapé-->
            <br/><br/>
            <div class="rodape">
                <p>
                    <strong>Diretória da Tecnologia da Informática</strong> - ramal: 5398
                </p>
            </div>
        </div>

        <script src="js/cadastro.js"></script>
    </body>
</html>

