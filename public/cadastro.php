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
    <meta name="author" content="Erivelton da Silva">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="img/favicon.ico">
    <title>SisCast - Pedidos de Agendamento Público</title>
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css">
    
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="img/logo.png" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Cadastro para Esterilização de Animais</h1>
            </div>

            <!--/conteúdo-->

            <div class="conteudo">
                <?php
                // limpa as variáveis que receberão os valores do formulário
                $nome = $cpf = $endereco = $numero = $complemento = $bairro = $cep = $tel = '';
                $cel = $cns = $beneficio = $beneficioQual = $nomeAnimal = $genero = $porte = $idade = '';
                $idadeEm = $cor = $especie = $raca_id = $procedencia = '';

                // executa o cadastro se possível
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // função de checagem de data, para eliminar o pepino que dá no IE
                    function checarData($date) {
                        $tempDate = explode('-', $date);
                        // checkdate(month, day, year)
                        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
                    }
                    
                    // verifica se o token enviado é válido
                    // de acordo com a sessão 

                    if (!isset($_SESSION['token'])){
                        header("Location: erro104.php");
                        exit;
                    }

                    if (!isset($_POST['token'])){
                        header("Location: erro104.php");
                        exit;
                    }

                    if ($_POST['token'] != $_SESSION['token'])
                    {  
                        // reseta os tokens
                        $_SESSION['token_time'] = nul;
                        $_SESSION['token'] = null; 
                        header("Location: erro104.php");
                        exit;     
                    }

                    // verifica se a vida da sessão já acabou
                    $token_age = time() - $_SESSION['token_time'];
                    // cada token tem uma vida de duas horas após ser criado
                    if ($token_age > 7200){
                        // reseta os tokens
                        $_SESSION['token_time'] = null;
                        $_SESSION['token'] = null;
                        header("Location: erro103.php");
                        exit;
                    }
                    
                    // de acordo com o log de acesso no banco de dados
                    // parece mágica mas não é, essa simples consulta verifica se as seções existem
                    // teoricamente esse conjunto de códigos já faz toda validação
                    // se os tokens de post e sessao sao iguais
                    // se foram criados
                    // se não expiraram
                    // se existem
                    // por mim isso está funcionando como uma segunda camada
                    // de iteração com o banco de dados
                    // só que tem de ir ao banco consultas, os anteriores são processados mais rapidos
                    // essa dupla verificação permite uma segurança maior com as requisições
                    TDBConnection::prepareQuery("SELECT TIMESTAMPDIFF(SECOND,logacesso.description,now()) as vida FROM logacesso
                                                        where token = :token_post and token = :token_sessao;");
                    TDBConnection::bindParamQuery(':token_post', $_POST['token'], PDO::PARAM_STR);
                    TDBConnection::bindParamQuery(':token_sessao', $_SESSION['token'], PDO::PARAM_STR);
                    $logacesso = TDBConnection::single();

                    if (TDBConnection::rowCount() == 0 ) {
                        header("Location: erro104.php");
                        exit;
                    }
                    // duas horas de vida, segunda validação
                    if ($logacesso->vida > 7200){
                        // reseta os tokens
                        $_SESSION['token_time'] = null;
                        $_SESSION['token'] = null;
                        header("Location: erro103.php");
                        exit;
                    }

                    // validação e tratamento dos dados recebidos do formulário

                    // validação # nome
                    $_POST['nome'] = trim( $_POST['nome'] );
                    if(isset($_POST['nome']) && !empty($_POST['nome'])) {
                        $nome = strip_tags($_POST['nome']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # cpf
                    $_POST['cpf'] = trim( $_POST['cpf'] );
                    if(isset($_POST['cpf']) && !empty($_POST['cpf'])) {
                        $cpf = strip_tags($_POST['cpf']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }
                    /* validar cpf */
                    if (TCommon::valida_cpf($cpf) == false) {
                        header("Location: erro100.php");
                        exit;
                    }

                    // validação # nascimento
                    $_POST['nascimento'] = trim( $_POST['nascimento'] );
                    if(isset($_POST['nascimento']) && !empty($_POST['nascimento'])) {
                        $nascimento = strip_tags($_POST['nascimento']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }
                    /* validar a data de nascimento que dá problema no IE */
                    if(!checarData($nascimento)){
                        header("Location: erro105.php");
                        exit;
                    }

                    // validação # endereco
                    $_POST['endereco'] = trim( $_POST['endereco'] );
                    if(isset($_POST['endereco']) && !empty($_POST['endereco'])) {
                        $endereco = strip_tags($_POST['endereco']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # numero
                    $_POST['numero'] = trim( $_POST['numero'] );
                    if(isset($_POST['numero']) && !empty($_POST['numero'])) {
                        $numero = strip_tags($_POST['numero']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # complemento
                    // campo opcional
                    $complemento = (isset($_POST['complemento']) ? strip_tags(trim($_POST['complemento'])) : '');

                    // validação # bairro
                    $_POST['bairro'] = trim( $_POST['bairro'] );
                    if(isset($_POST['bairro']) && !empty($_POST['bairro'])) {
                        $bairro = strip_tags($_POST['bairro']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # cep
                    $_POST['cep'] = trim( $_POST['cep'] );
                    if(isset($_POST['cep']) && !empty($_POST['cep'])) {
                        $cep = strip_tags($_POST['cep']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # tel
                    $_POST['tel'] = trim( $_POST['tel'] );
                    if(isset($_POST['tel']) && !empty($_POST['tel'])) {
                        $tel = strip_tags($_POST['tel']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # cel
                    $_POST['cel'] = trim( $_POST['cel'] );
                    if(isset($_POST['cel']) && !empty($_POST['cel'])) {
                        $cel = strip_tags($_POST['cel']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }


                    // validação # cns
                    $_POST['cns'] = trim( $_POST['cns'] );
                    if(isset($_POST['cns']) && !empty($_POST['cns'])) {
                        $cns = strip_tags($_POST['cns']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # beneficio
                    $_POST['beneficio'] = trim( $_POST['beneficio'] );
                    if(isset($_POST['beneficio']) && !empty($_POST['beneficio'])) {
                        $beneficio = strip_tags($_POST['beneficio']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # beneficioQual
                    // campo opcional, não validar
                    $beneficio = (isset($_POST['beneficio']) ? strip_tags(trim($_POST['beneficio'])) : '');

                    // validação # nomeAnimal
                    $_POST['nomeAnimal'] = trim( $_POST['nomeAnimal'] );
                    if(isset($_POST['nomeAnimal']) && !empty($_POST['nomeAnimal'])) {
                        $nomeAnimal = strip_tags($_POST['nomeAnimal']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # genero
                    $_POST['genero'] = trim( $_POST['genero'] );
                    if(isset($_POST['genero']) && !empty($_POST['genero'])) {
                        $genero = strip_tags($_POST['genero']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # porte
                    $_POST['porte'] = trim( $_POST['porte'] );
                    if(isset($_POST['porte']) && !empty($_POST['porte'])) {
                        $porte = strip_tags($_POST['porte']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # idade
                    $_POST['idade'] = trim( $_POST['idade'] );
                    if(isset($_POST['idade']) && !empty($_POST['idade'])) {
                        $idade = strip_tags($_POST['idade']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # idadeEm
                    $_POST['idadeEm'] = trim( $_POST['idadeEm'] );
                    if(isset($_POST['idadeEm']) && !empty($_POST['idadeEm'])) {
                        $idadeEm = strip_tags($_POST['idadeEm']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # cor
                    $_POST['cor'] = trim( $_POST['cor'] );
                    if(isset($_POST['cor']) && !empty($_POST['cor'])) {
                        $cor = strip_tags($_POST['cor']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # especie
                    $_POST['especie'] = trim( $_POST['especie'] );
                    if(isset($_POST['especie']) && !empty($_POST['especie'])) {
                        $especie = strip_tags($_POST['cor']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # raca_id
                    $_POST['raca_id'] = trim( $_POST['raca_id'] );
                    if(isset($_POST['raca_id']) && !empty($_POST['raca_id']) && ($_POST['raca_id'] > 0) ){
                        $raca_id = strip_tags($_POST['raca_id']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }

                    // validação # procedencia
                    $_POST['procedencia'] = trim( $_POST['procedencia'] );
                    if(isset($_POST['procedencia']) && !empty($_POST['procedencia'])) {
                        $procedencia = strip_tags($_POST['procedencia']);
                    }
                    else {
                        header("Location: erro101.php");
                        exit;
                    }
                                        
                    /* validar número máximo de pedidos por cpf (5) */
                    /* importante */
                    /* Use a lista para definir quantos pedidos por situação podem ser cadastrados para esse cpf */
                    TDBConnection::prepareQuery("select count(*) as total from pedidos where situacao_id in (1,2,3,4,5,6) and ano = year(now()) and cpf = :cpf");
                    TDBConnection::bindParamQuery(':cpf', $cpf, PDO::PARAM_INT);
                    $totalPedidos = TDBConnection::single();
                    // definido como 5 por ano
                    if ($totalPedidos->total > 4){
                        header("Location: erro102.php");
                        exit;    
                    }

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

                    TDBConnection::endTransaction();
                    
                    // reseta os tokens de segurança
                    unset($_SESSION['token_time']);
                    unset($_SESSION['token']);

                    header("Location: concluido.php?cpf=" . $cpf);
                    exit;
                }
                ?>

                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onSubmit="return validaForm();">
                    <fieldset>
                        <legend>Informações sobre o tutor:</legend>
                        
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" maxlength="140" size="36" required autofocus><br><br>

                        <label for="nascimento">Data Nascimento:</label>
                        <input type="date" name="nascimento" id="nascimento" required><br><br>

                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" maxlength="11" size="12" required><br><br>

                        <label for="endereco">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" maxlength="255" size="36" required><br><br>                        

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
                        <input type="radio" name="beneficio" id="beneficio" value="N">Não (Bolsa familia)<br>
                        <br>  

                        <label for="beneficioQual">Qual:</label>
                        <input type="text" name="beneficioQual" id="beneficioQual" maxlength="120" size="35"><br/><br/>                        

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
                        <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" required>vive na rua/comunitário
                        <input type="radio" name="procedencia" id="procedencia" value="resgatado">Resgatado
                        <input type="radio" name="procedencia" id="procedencia" value="adotado">Adotado
                        <input type="radio" name="procedencia" id="procedencia" value="comprado">Comprado
                        <input type="radio" name="procedencia" id="procedencia" value="ONG">ONG<br><br> 

                        <br>

                    </fieldset>

                    <br>

                    <fieldset>
                        <legend>Critérios e pré-requisitos para cadastro de esterilização de animais no Centro de Controle de Zoonoses  de Contagem:</legend>
                        
                        <div>
                            <p>O cadastro para esterilização de cães e gatos deverá ser feito mediante preenchimento e envio deste formulário eletrônico. As solicitações serão avaliadas pela equipe responsável e, se aceitas, o solicitante deverá aguardar o contato da equipe do CCZ para agendamento. O prazo de espera poderá variar de acordo com a demanda. Cabe ao solicitante acompanhar o andamento de sua solicitação no site.</p>
                        </div>
                                               
                        <div>
                            <h1>Critérios quanto ao solicitante</h1>
                            <ul>
                                <li>O solicitante deve ser maior de 18 anos e residir no município de Contagem/MG.</li>
                                <li>Cada solicitante tem direito de cadastrar o limite máximo de 3 (três) animais, sendo que à medida em que as cirurgias forem realizadas, novas vagas serão disponibilizadas para cadastramento;</li>
                                <li>É de inteira responsabilidade do solicitante informar corretamente 1 (um) ou 2 (dois) contatos telefônicos.</li>
                                <li>A cada solicitação é gerado um número de cadastro para controle interno, não correspondendo à ordem de atendimento ou agendamento.</li>
                                <li>As solicitações passam por uma triagem, podendo ser aprovadas ou não. É de responsabilidade do solicitante acompanhar o andamento da sua solicitação pelo site.</li>
                                <li>Após a aprovação do cadastro, o solicitante deverá aguardar o contato telefônico do CCZ, de segunda a sexta-feira, em horário comercial, para fins de agendamento. Após 2 (duas) tentativas de contato sem sucesso, o cadastro será cancelado, podendo o solicitante realizar novo cadastro quando desejar.</li>
                                <li>No dia agendado para a cirurgia de esterilização, é obrigatória a apresentação de documento de identidade com foto e comprovante de residência (IPTU, CEMIG, COPASA) em seu nome. Em caso de impossibilidade de comparecimento no dia agendado, o solicitante poderá designar um representante através de declaração escrita e assinada a ser apresentada ao CCZ juntamente com os documentos supracitados, bem como um documento de identificação do representante;</li>
                                <li>Caso o solicitante possua Carteira Nacional de Saúde (CNS), que pode ser emitida em qualquer unidade de saúde, ou benefício do governo, é obrigatória a apresentação de documentação comprobatória no dia agendado para a cirurgia.</li>
                                <li>No dia agendado para a cirurgia de esterilização o solicitante deve chegar com 30 minutos de antecedência, sob pena de ter o atendimento cancelado.</li>
                                <li>No dia agendado para a cirurgia, o solicitante deve levar:</li>
                                <ol type="I">
                                    <li>No caso de cadela ou gata: cobertor, atadura crepom (faixa) nova e colar elisabetano ou macacão cirúrgico;</li>
                                    <li>No caso de cão: cobertor e colar elisabetano;</li>
                                    <li>No caso de gato: cobertor.</li>
                                </ol>
                                <p><b>Importante:</b> Cães e cadelas devem ser conduzidos em guias próprias. Nunca soltos. Felinos devem ser transportados em caixas de transporte próprias, nunca no colo ou em guias, devido ao risco de fugas.</p>
                                <li>Em caso de ausência no dia agendado, sem aviso prévio, a solicitação será cancelada e o interessado só terá direito a realizar novo processo de cadastramento para cirurgia de esterilização do animal decorridos 6 (seis) meses contados a partir da data agendada.</li>
                                <li>Excepcionalmente, o CCZ poderá cancelar cirurgias agendadas, ocasião em que o solicitante será comunicado por telefone com até 24 horas de antecedência e o procedimento será remarcado.</li>
                                <li>A cirurgia de esterilização só será realizada mediante leitura, preenchimento e assinatura pelo solicitante do Termo de Autorização para Realização de Cirurgia.</li>
                            </ul>
                            <h1>Critérios quanto aos cães e gatos</h1>
                            <ul>
                                <li>Para serem submetidos à esterilização, os animais devem ter no mínimo 6 (seis) meses e no máximo 8 (oito) anos. O CCZ não realiza esterilização em animais idosos.</li>
                                <li>O CCZ não realiza esterilização em animais com lesões cutâneas, epilépticos, obesos, no cio (cadelas) ou em gestação avançada (gatas ou cadelas). Se a cadela estiver no cio, deve-se aguardar pelo menos 20 dias após o término do mesmo para realizar a esterilização. Em caso de gestação  (gatas ou cadelas) recente, deve-se aguardar pelo menos 60 dias após o parto para realizar a esterilização.</li>
                                </li>
                                <li>Antes da cirurgia de esterilização, os animais poderão ser submetidos a exame clínico pelo médico veterinário do CCZ, podendo ser considerados inaptos para a cirurgia, caso sejam constatadas quaisquer alterações consideradas significativas e que impossibilitem a realização da cirurgia.</li>
                                <li>No caso de caninos, o solicitante pode apresentar exame recente (menos de 6 meses) de leishmaniose ou submeter o animal, no CCZ, ao teste rápido para Leishmaniose Visceral no dia agendado. Em caso de resultado negativo a cirurgia poderá ser realizada imediatamente. Em caso de resultado positivo, a cirurgia não poderá ser realizada imediatamente e o solicitante deverá aguardar o resultado do exame sorológico ELISA confirmatório para Leishmaniose Visceral.</li>
                                <li>Só serão esterilizados animais com exame positivo para Leishmaniose visceral ou que estejam em tratamento veterinário de qualquer tipo, mediante laudo de médico veterinário responsável pelo tratamento, autorizando a cirurgia de esterilização.</li>
                                <li>O CCZ não realiza exames de risco cirúrgico, sendo altamente recomendado que o solicitante o faça por conta própria.</li>
                                <li>Cães e gatos comunitários ou abandonados recolhidos pelo CCZ são atendidos prioritariamente, assim como cães e gatos pertencentes a imóveis ou regiões do município onde seja constatada a necessidade de atendimento imediato, em face da superpopulação de animais, alto risco epidemiológico, calamidades e/ou outros casos específicos mediante avaliação do corpo técnico do CCZ.</li>
                                <li>Cães e gatos comunitários ou abandonados recolhidos por organizações da sociedade civil poderão ser atendidos segundo critérios específicos, objetivando a cooperação mútua, controle populacional ético, guarda responsável e/ou adoção dos animais, mediante celebração de convênios.</li>                                
                            </ul>
                            
                            <p>No dia do procedimento o solicitante deverá assinar um termo de autorização que pode ser acessado nesse <a href="doc/termo_autorizacao_cirurgia.pdf" target="new_window">link</a>.</p>
                        </div>

                        <input type="checkbox" name="concordar" id="concordar" value="sim" required>
                        <span class="destaque">Declaro que li, aceito os termos e condições referentes ao cadastro para esterilização de animais e que as informações declaradas neste formulário são verdadeiras. </span><br><br>  

                    </fieldset>

                    <div class="alinha">
                        <input type="submit" name="Agendar" id="Agendar"
                               value="Fazer Pedido de Agenda">
                    </div>


                </form>

                <br>

                <!--/rodapé-->
                <br/><br/>
                <div class="rodape">
                    <p>
                        <strong>Centro de Controle de Zoonoses</strong><br>
                        Telefones: 3351-3751 / 3361-7703<br>
                        E-mail: cczcontagem@yahoo.com.br
                    </p>
                </div>
            </div>

            <!-- scripts da página -->
            <script src="cadastro.js"></script>
        </div>    
    </body>
</html>

