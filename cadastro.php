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
    <link rel="icon" href="img/favicon.ico">
    <title>SisCast</title>

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="estilo/navegacao.css">


    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>SisCast - Sistema de Agenda de Castrações</h1>
            </div>

            <div class="titulofuncionario">
                Funcionário : <a href="operador/alterarSenha.php"><?php echo $_SESSION['sessao_usuario_name']; ?></a>
            </div>

            <!--menuTopo-->

            <div class="menuTopo">
                <ul class="menu">                     
                    <li><a href="cadastro.php">Cadastro</a></li>
                    <li><a href="pedidos.php">Pedidos</a></li>
                    <li><a href="configuracao.php">Configurações</a></li>
                    <li><a href="relatorios.php">Relatórios</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>

            </div>

            <!--/conteúdo-->
            <div class="conteudo">

               <?php
                // limpa as variáveis de entrada
                $nome = $cpf = $endereco = $numero = $complemento = $bairro = $cep = $tel = '';
                $cel = $cns = $beneficio = $beneficioQual = $nomeAnimal = $genero = $porte = $idade = '';
                $idadeEm = $cor = $especie = $raca_id = $procedencia = $nascimento ='';

                // executa o cadastro se possível
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // recebi e formata as variáveis

                    /* dados do pedinte */
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


                    /* calculo do codigo e ano */

                    TDBConnection::beginTransaction();
                    TDBConnection::prepareQuery("select (coalesce(max(codigo), 0) + 1) as codigo, year(now()) as ano from pedidos where ano = year(now());");
                    $codigo_ano = TDBConnection::single();

                    /* inclusão */
                    TDBConnection::prepareQuery("INSERT INTO pedidos
                                                    (id,
                                                    codigo,
                                                    ano,
                                                    cpf,
                                                    nome,
                                                    nascimento,
                                                    endereco,
                                                    numero,
                                                    bairro,
                                                    complemento,
                                                    cep,
                                                    cns,
                                                    beneficio,
                                                    beneficioQual,
                                                    tel,
                                                    cel,
                                                    nomeAnimal,
                                                    genero,
                                                    porte,
                                                    idade,
                                                    idadeEm,
                                                    cor,
                                                    especie,
                                                    raca_id,
                                                    procedencia,
                                                    quando,
                                                    situacao_id)
                                                    
                                                    VALUES
                                                    
                                                    (null,
                                                    :codigo,
                                                    :ano,
                                                    :cpf,
                                                    :nome,
                                                    :nascimento,
                                                    :endereco,
                                                    :numero,
                                                    :bairro,
                                                    :complemento,
                                                    :cep,
                                                    :cns,
                                                    :beneficio,
                                                    :beneficioQual,
                                                    :tel,
                                                    :cel,
                                                    :nomeAnimal,
                                                    :genero,
                                                    :porte,
                                                    :idade,
                                                    :idadeEm,
                                                    :cor,
                                                    :especie,
                                                    :raca_id,
                                                    :procedencia,
                                                    now(),
                                                    1);

                                                    ");

                    /* código interno */
                    TDBConnection::bindParamQuery(':codigo', $codigo_ano->codigo, PDO::PARAM_INT);
                    TDBConnection::bindParamQuery(':ano', $codigo_ano->ano, PDO::PARAM_INT);

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
                    $ultimoId = TDBConnection::lastInsertId();

                    TDBConnection::endTransaction();

                    //header("Location: concluido.php");
                    //exit;
                    
                    echo "<div>";
                    echo "<p class=\"destaque alinha\">Cadastro realizado. Código " . $codigo_ano->codigo . ". Ano " . $codigo_ano->ano . ".</p>";
                    echo "</div>";
                }
                ?>


                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onSubmit="return validaForm();">
                    <fieldset>
                        <legend>Informações sobre o tutor:</legend>

                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" maxlength="140" size="36" required autofocus><br><br>

                        <label for="nascimento">Data Nascimento:</label>
                        <input type="date" name="nascimento" id="nascimento" required>

                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" maxlength="11" size="12" required><br><br>

                        <label for="endereco">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" maxlength="255" size="36" required><br/><br/>                        

                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" maxlength="20" size="9"> 

                        <label for="complemento">Complemento:</label>
                        <input type="text" name="complemento" id="complemento" maxlength="60" size="18"><br/><br/>  

                        <label for="bairro">Bairro:</label>
                        <input type="text" name="bairro" id="bairro" maxlength="140" size="20" required><br/><br/>                       

                        <label for="cep">CEP:</label>
                        <input type="text" name="cep" id="cep" maxlength="10" size="10" required><br/><br/>                        

                        <label for="tel">Telefone:</label>
                        <input type="text" name="tel" id="tel" maxlength="20" size="10" required>                        

                        <label for="cel">Celular:</label>
                        <input type="text" name="cel" id="cel" maxlength="20" size="10" required><br/><br/>                        

                        <label for="cns">Possui CNS:</label>
                        <input type="radio" name="cns" id="cns" value="S" required>Sim
                        <input type="radio" name="cns" id="cns" value="N">Não (Cartão Nacional de Saúde)<br>
                        <br>

                        <label for="beneficio">Possui Benefício:</label>
                        <input type="radio" name="beneficio" id="beneficio" value="S" required>Sim
                        <input type="radio" name="beneficio" id="beneficio" value="N">Não

                        <label for="beneficioQual">Qual:</label>
                        <input type="text" name="beneficioQual" id="beneficioQual" maxlength="120" size="20"><br/><br/>                        

                    </fieldset>

                    <br>

                    <fieldset>
                        <legend>Informações sobre o animal:</legend>

                        <label for="nomeAnimal">Nome do animal:</label>
                        <input type="text" name="nomeAnimal" id="nomeAnimal" maxlength="120" size="20" required><br/><br/>                       


                        <label for="genero">Gênero:</label>
                        <input type="radio" name="genero" id="genero" value="M" required>Macho
                        <input type="radio" name="genero" id="genero" value="F">Fêmea<br><br>

                        <label for="porte">Porte:</label>
                        <input type="radio" name="porte" id="porte" value="pequeno" required>Pequeno
                        <input type="radio" name="porte" id="porte" value="medio">Médio
                        <input type="radio" name="porte" id="porte" value="grande">Grande<br><br>

                        <label for="idade">Idade:</label>
                        <input type="number" name="idade" id="idade" min="1" max="20" required><span><input type="radio" name="idadeEm" id="idadeEm" value="mes" required>Mês(es)
                            <input type="radio" name="idadeEm" id="idadeEm" value="ano">Ano(s)</span><br/><br/>


                        <label for="cor">Cor do animal:</label>
                        <input type="text" name="cor" id="cor" maxlength="80" size="20" required><br/><br/>                       

                        <label for="especie">Espécie:</label>
                        <input type="radio" name="especie" id="especie" value="felino" required>Felino
                        <input type="radio" name="especie" id="especie" value="canino">Canino<br><br>

                        <label for="raca_id">raça:</label>
                        <select name="raca_id" id="raca_id" required>
                            <option value="" selected>Escolha...</option>
                            <?php
                            TDBConnection::prepareQuery("select * from racas order by descricao;");
                            $racas = TDBConnection::resultset();
                            foreach ($racas as $raca) {
                                echo "<option value=\"$raca->id\">$raca->descricao</option>" . EOL;
                            }
                            ?>
                        </select><br><br>  

                        <label for="procedencia">Origem:</label>
                        <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" required>vive na rua / comunitário
                        <input type="radio" name="procedencia" id="procedencia" value="resgatado">Resgatado
                        <input type="radio" name="procedencia" id="procedencia" value="adotado">Adotado
                        <input type="radio" name="procedencia" id="procedencia" value="comprado">Comprado
                        <input type="radio" name="procedencia" id="procedencia" value="ONG">ONG
                        <br><br>                        

                        <br>

                    </fieldset>

                    <br>

                   

                    <div class="alinha">
                        <input type="submit" name="Agendar" id="Agendar"
                               value="Fazer Pedido de Agenda">
                    </div>


                </form>

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

        <script src="js/cadastro.js"></script>
    </body>
</html>

