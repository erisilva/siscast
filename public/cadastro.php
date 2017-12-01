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
<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/estilo.css">

<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>

<script src="js/moment.min.js"></script>
<script src="js/local/pt-br.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>

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

<div class="container-fluid">

<?php
// executa o cadastro se possível
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // verifica se o token enviado é válido
    // de acordo com a sessão

    if (!isset($_SESSION['token'])){
        $erro["token"] = "Chave de acesso não encontrada. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
    }

    if (!isset($_POST['token'])){
        $erro["token"] = "Chave de acesso não encontrada. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
    }

    if ($_POST['token'] != $_SESSION['token'])
    {
        // reseta os tokens
        $_SESSION['token_time'] = nul;
        $_SESSION['token'] = null;
        $erro["token"] = "Chave de acesso inválida. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
    }

    // verifica se a vida da sessão já acabou
    $token_age = time() - $_SESSION['token_time'];
    // cada token tem uma vida de duas horas após ser criado
    if ($token_age > 7200){
        // reseta os tokens
        $_SESSION['token_time'] = null;
        $_SESSION['token'] = null;
        $erro["token"] = "Chave de acesso expirado. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
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
        $erro["token"] = "Chave de acesso inválida. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
    }
    // duas horas de vida, segunda validação
    if ($logacesso->vida > 7200){
        // reseta os tokens
        $_SESSION['token_time'] = null;
        $_SESSION['token'] = null;
        $erro["token"] = "Chave de acesso não encontrada. <a href='cadastro.php'>Clique aqui para limpar o formulário.</a>.";
    }

    // validação # nome
    $_POST['nome'] = trim($_POST['nome']);
    if(isset($_POST['nome']) && !empty($_POST['nome'])) {
        $nome = strip_tags($_POST['nome']);
    }
    else {
        $erro["nome"] = "Campo obrigatório.";
    }

    // validação # nascimento
    $_POST['nascimento'] = trim($_POST['nascimento']);
    if(isset($_POST['nascimento']) && !empty($_POST['nascimento'])) {
        $nascimento = strip_tags($_POST['nascimento']);
        if (!TCommon::valida_data_br($nascimento)) {
            $erro["nascimento"] = "Data inválida. Utilize o formato: DD/MM/AAAA.";
        }
    }
    else {
        $erro["nascimento"] = "Campo Obrigatório.";
    }

    // validação # cpf
    $_POST['cpf'] = trim($_POST['cpf']);
    if(isset($_POST['cpf']) && !empty($_POST['cpf'])) {
        $cpf = strip_tags($_POST['cpf']);
        /* validar cpf */
        if (TCommon::valida_cpf($cpf) == false) {
            $erro["cpf"] = "CPF Inválido.";
        }
    }
    else {
        $erro["cpf"] = "Campo Obrigatório.";
    }

    // validação # email
    $_POST['email'] = trim($_POST['email']);
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = strip_tags($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro["email"] = "Formato de e-mail inválido.";
        }
    }
    else {
        $erro["email"] = "Campo obrigatório.";
    }

    // validação # cep
    $_POST['cep'] = trim($_POST['cep']);
    if(isset($_POST['cep']) && !empty($_POST['cep'])) {
        $cep = strip_tags($_POST['cep']);
        $logradouro = TCommon::busca_cep_viacep_querty($cep);
        if (isset($logradouro['erro'])) {
            $erro["cep"] = "CEP inválido ou não encontrado.";
        } else {
            if ($logradouro['localidade'] != "Contagem"){
                $erro["cep"] = "Localização inválida: " . $logradouro['localidade']  . ", " . $logradouro['uf'] . ".";
            }
            // salva os valores que vierem da tabela do viacep
            $cidade = $logradouro['localidade'];
            $estado = $logradouro['uf'];
        }
    }
    else {
        $erro["cep"] = "Campo Obrigatório.";
    }

    // validação # endereco
    $_POST['endereco'] = trim($_POST['endereco']);
    if(isset($_POST['endereco']) && !empty($_POST['endereco'])) {
        $endereco = strip_tags($_POST['endereco']);
    }
    else {
        $erro["endereco"] = "Campo obrigatório.";
    }

    // validação # numero
    $_POST['numero'] = trim($_POST['numero']);
    if(isset($_POST['numero']) && !empty($_POST['numero'])) {
        $numero = strip_tags($_POST['numero']);
    }
    else {
        $erro["numero"] = "Campo obrigatório.";
    }

    // opcional #complemento
    $_POST['complemento'] = trim($_POST['complemento']);
    $complemento = strip_tags($_POST['complemento']);

    // validação # bairro
    $_POST['bairro'] = trim($_POST['bairro']);
    if(isset($_POST['bairro']) && !empty($_POST['bairro'])) {
        $bairro = strip_tags($_POST['bairro']);
    }
    else {
        $erro["bairro"] = "Campo obrigatório.";
    }

    // sem validação
    // cidade -> $logadouro['localidade']
    // sem validação
    // estado -> $logadouro['uf']
    // vide linha 241

    // validação # tel
    $_POST['tel'] = trim($_POST['tel']);
    if(isset($_POST['tel']) && !empty($_POST['tel'])) {
        $tel = strip_tags($_POST['tel']);
    }
    else {
        $erro["tel"] = "Campo obrigatório.";
    }

    // validação # cel
    $_POST['cel'] = trim($_POST['cel']);
    if(isset($_POST['cel']) && !empty($_POST['cel'])) {
        $cel = strip_tags($_POST['cel']);
    }
    else {
        $erro["cel"] = "Campo obrigatório.";
    }

    // validação # cns
    $_POST['cns'] = trim($_POST['cns']);
    if(isset($_POST['cns']) && !empty($_POST['cns'])) {
        $cns = strip_tags($_POST['cns']);
    }
    else {
        $erro["cns"] = "Campo obrigatório. <a href=\"http://cartaosus.com.br/consulta-cartao-sus/\" target=\"_blank\">Clique aqui para consultar seu cns.</a>";
    }


    // validação # beneficio
    $_POST['beneficio'] = trim($_POST['beneficio']);
    if(isset($_POST['beneficio']) && !empty($_POST['beneficio'])) {
        $beneficio = strip_tags($_POST['beneficio']);
    }
    else {
        $erro["beneficio"] = "Campo obrigatório.";
    }

    // opcional # beneficioQual
    $_POST['beneficioQual'] = trim($_POST['beneficioQual']);
    $beneficioQual = strip_tags($_POST['beneficioQual']);

    // validação # nomeAnimal
    $_POST['nomeAnimal'] = trim($_POST['nomeAnimal']);
    if(isset($_POST['nomeAnimal']) && !empty($_POST['nomeAnimal'])) {
        $nomeAnimal = strip_tags($_POST['nomeAnimal']);
    }
    else {
        $erro["nomeAnimal"] = "Campo obrigatório.";
    }

    // validação # genero
    $_POST['genero'] = trim($_POST['genero']);
    if(isset($_POST['genero']) && !empty($_POST['genero'])) {
        $genero = strip_tags($_POST['genero']);
    }
    else {
        $erro["genero"] = "Campo obrigatório.";
    }

    // validação # porte
    $_POST['porte'] = trim($_POST['porte']);
    if(isset($_POST['porte']) && !empty($_POST['porte'])) {
        $porte = strip_tags($_POST['porte']);
    }
    else {
        $erro["porte"] = "Campo obrigatório.";
    }

    // validação # idade
    $_POST['idade'] = trim($_POST['idade']);
    if(isset($_POST['idade']) && !empty($_POST['idade'])) {
        $idade = strip_tags($_POST['idade']);
        if (!is_numeric($idade)){
            $erro["idade"] = "A idade precisa ser um valor numérico.";
        }
    }
    else {
        $erro["idade"] = "Campo obrigatório.";
    }

    // validação # idadeEm
    $_POST['idadeEm'] = trim($_POST['idadeEm']);
    if(isset($_POST['idadeEm']) && !empty($_POST['idadeEm'])) {
        $idadeEm = strip_tags($_POST['idadeEm']);
    }
    else {
        $erro["idadeEm"] = "Campo obrigatório.";
    }

    // validação # idade precisa estar dentro da faixa permitida
    // validação # idade permitida >= 6 meses e <= 8 anos
    if ($idadeEm == 'mes'){
        if ($idade < 6){
            $erro["idade"] = "Idade <strong>abaixo</strong> do permitido.";
        }
    }

    if ($idadeEm == 'ano'){
        if ($idade > 8){
            $erro["idade"] = "Idade <strong>acima</strong> do permitido.";
        }
    }

    // validação # cor
    $_POST['cor'] = trim($_POST['cor']);
    if(isset($_POST['cor']) && !empty($_POST['cor'])) {
        $cor = strip_tags($_POST['cor']);
    }
    else {
        $erro["cor"] = "Campo obrigatório.";
    }

    // validação # especie
    $_POST['especie'] = trim($_POST['especie']);
    if(isset($_POST['especie']) && !empty($_POST['especie'])) {
        $especie = strip_tags($_POST['especie']);
    }
    else {
        $erro["especie"] = "Campo obrigatório.";
    }

    // validação # raca_id
    $_POST['raca_id'] = trim($_POST['raca_id']);
    if(isset($_POST['raca_id']) && !empty($_POST['raca_id'])) {
        $raca_id = strip_tags($_POST['raca_id']);
        if (!is_numeric($raca_id)){
            $erro["raca_id"] = "Precisa ser um valor númerico.";
        }
    }
    else {
        $erro["raca_id"] = "Campo obrigatório.";
    }

    // preciso da descrição da raça para colocar  no campo de seleção
    TDBConnection::prepareQuery("select * from racas where id = :id");
    TDBConnection::bindParamQuery(':id', $raca_id, PDO::PARAM_INT);
    $racaSelecionada = TDBConnection::single();

    // validação # procedencia
    $_POST['procedencia'] = trim($_POST['procedencia']);
    if(isset($_POST['procedencia']) && !empty($_POST['procedencia'])) {
        $procedencia = strip_tags($_POST['procedencia']);
    }
    else {
        $erro["procedencia"] = "Campo obrigatório.";
    }

    // validação # concordar
    $_POST['concordar'] = trim($_POST['concordar']);
    if(isset($_POST['concordar']) && !empty($_POST['concordar'])) {
        $concordar = strip_tags($_POST['concordar']);
    }
    else {
        $erro["concordar"] = "Campo obrigatório.";
    }

    echo "<pre>\n";
    print_r($_POST);
    echo "</pre>\n";

    echo "<pre>\n";
    print_r($erro);
    echo "</pre>\n";
}

?>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Fazer um Cadastro
                </div>
                <br>
                <form class="form-horizontal" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <?php
                    if (isset($erro['token'])){
                        echo "<div class=\"alert alert-danger alert-dismissable\">\n";
                        echo "  <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>\n";
                        echo "  <strong>Erro Grave!</strong> " . $erro["token"] ."\n";
                        echo "</div>\n";
                    }


                    ?>

                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                    <div class="well well text-center"><h2>Informações Sobre o Tutor</h2></div>

                    <div class="form-group <?php echo isset($erro["nome"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="nome">Nome:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nome" name="nome"
                                   placeholder="Digite seu nome completo" autofocus maxlength="140" value="<?php echo isset($nome) ? $nome : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["nome"]) ?   "<span class=\"label label-danger\">" . $erro["nome"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["nascimento"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="nascimento">Data de Nascimento:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="nascimento" name="nascimento" maxlength="10" value="<?php echo isset($nascimento) ? $nascimento : ''; ?>">
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["nascimento"]) ?   "<span class=\"label label-danger\">" . $erro["nascimento"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["cpf"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="cpf">CPF:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cpf" name="cpf" maxlength="11" value="<?php echo isset($cpf) ? $cpf : ''; ?>">
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <?php echo isset($erro["cpf"]) ?   "<span class=\"label label-danger\">" . $erro["cpf"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["email"]) ? "has-error" : ""; ?>" >
                        <label class="col-md-3 control-label" for="email">E-mail:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="Digite seu e-mail" maxlength="200" value="<?php echo isset($email) ? $email : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["email"]) ?   "<span class=\"label label-danger\">" . $erro["email"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["cep"]) ? "has-error" : ""; ?>" >
                        <label class="col-md-3 control-label" for="cep">CEP:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="cep" name="cep" maxlength="8" value="<?php echo isset($cep) ? $cep : ''; ?>">
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["cep"]) ?   "<span class=\"label label-danger\">" . $erro["cep"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Atenção!</strong> Somente serão aceitos cadastros para o municípo de Contagem, MG.
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group <?php echo isset($erro["endereco"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="endereco">Endereço:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                   value="<?php echo isset($endereco) ? $endereco : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["endereco"]) ?   "<span class=\"label label-danger\">" . $erro["endereco"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["numero"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="numero">Número:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="numero" name="numero" maxlength="20"
                                   value="<?php echo isset($numero) ? $numero : ''; ?>">
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["numero"]) ?   "<span class=\"label label-danger\">" . $erro["numero"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="complemento">Complemento:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="60"
                                   value="<?php echo isset($complemento) ? $complemento : ''; ?>">
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group <?php echo isset($erro["bairro"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="bairro">Bairro:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="bairro" name="bairro"
                                   value="<?php echo isset($bairro) ? $bairro : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["bairro"]) ?   "<span class=\"label label-danger\">" . $erro["bairro"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cidade">Cidade:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="cidade" name="cidade" disabled
                                   value="<?php echo isset($cidade) ? $cidade : ''; ?>">
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="estado">Estado:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="estado" name="estado" disabled
                                   value="<?php echo isset($estado) ? $estado : ''; ?>">
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="form-group <?php echo isset($erro["tel"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="tel">Telefone:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="tel" name="tel" maxlength="20" value="<?php echo isset($tel) ? $tel : ''; ?>">
                        </div>
                        <div class="col-md-5">
                            <?php echo isset($erro["tel"]) ?   "<span class=\"label label-danger\">" . $erro["tel"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["cel"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="cel">Celular:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="cel" name="cel" maxlength="20" value="<?php echo isset($cel) ? $cel : ''; ?>">
                        </div>
                        <div class="col-md-5">
                            <?php echo isset($erro["cel"]) ?   "<span class=\"label label-danger\">" . $erro["cel"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["cns"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="cns">Cartão Nacional de Saúde:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cns" name="cns" maxlength="25" value="<?php echo isset($cns) ? $cns : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <?php echo isset($erro["cns"]) ?   "<span class=\"label label-danger\">" . $erro["cns"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Observação!</strong> O número do cartão nacional de saúde pode ser obtido em uma unidade de saúde mais próxima de sua residência,
                                ou através do website
                                <a href="http://cartaosus.com.br/consulta-cartao-sus/" target="_blank">cartaosus.com.br</a>.
                                <br>
                                <strong>Atenção!</strong> O número do cartão nacional de saúde ou o próprio cartão deve ser apresentado no dia agendado.
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group <?php echo isset($erro["beneficio"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="beneficio">Possui benefício de algum programa social do governo?</label>
                        <div class="col-md-2">
                            <input type="radio" name="beneficio" id="beneficio" value="S" <?php echo ($beneficio == 'S') ? 'checked' : ''; ?>>Sim
                            <input type="radio" name="beneficio" id="beneficio" value="N" <?php echo ($beneficio == 'N') ? 'checked' : ''; ?>>Não
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["beneficio"]) ?   "<span class=\"label label-danger\">" . $erro["beneficio"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="beneficioQual">Se sim, qual(is)?</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="beneficioQual" name="beneficioQual" maxlength="120"
                                   value="<?php echo isset($beneficioQual) ? $beneficioQual : ''; ?>">
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="well well text-center"><h2>Informações Sobre o Animal</h2></div>

                    <div class="form-group <?php echo isset($erro["nomeAnimal"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="nomeAnimal">Nome do animal:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="nomeAnimal" name="nomeAnimal" maxlength="120"
                                   value="<?php echo isset($nomeAnimal) ? $nomeAnimal : ''; ?>">
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["nomeAnimal"]) ?   "<span class=\"label label-danger\">" . $erro["nomeAnimal"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["genero"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="genero">Gênero:</label>
                        <div class="col-md-2">
                            <input type="radio" name="genero" id="genero" value="M" <?php echo ($genero == 'M') ? 'checked' : ''; ?>>Macho
                            <input type="radio" name="genero" id="genero" value="F" <?php echo ($genero == 'F') ? 'checked' : ''; ?>>Fêmea<br><br>
                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["genero"]) ?   "<span class=\"label label-danger\">" . $erro["genero"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["porte"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="porte">Porte:</label>
                        <div class="col-md-3">
                            <input type="radio" name="porte" id="porte" value="pequeno" <?php echo ($porte == 'pequeno') ? 'checked' : ''; ?>>Pequeno
                            <input type="radio" name="porte" id="porte" value="medio" <?php echo ($porte == 'medio') ? 'checked' : ''; ?>>Médio
                            <input type="radio" name="porte" id="porte" value="grande" <?php echo ($porte == 'grande') ? 'checked' : ''; ?>>Grande<br><br>
                        </div>
                        <div class="col-md-6">
                            <?php echo isset($erro["porte"]) ?   "<span class=\"label label-danger\">" . $erro["porte"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["idade"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="idade">Idade do animal:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="idade" name="idade" value="<?php echo isset($idade) ? $idade : ''; ?>">

                        </div>
                        <div class="col-md-7">
                            <?php echo isset($erro["idade"]) ?   "<span class=\"label label-danger\">" . $erro["idade"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["idadeEm"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="idadeEm">Idade em:</label>
                            <div class="col-md-3">
                            <input type="radio" name="idadeEm" id="idadeEm" value="mes" <?php echo ($idadeEm == 'mes') ? 'checked' : ''; ?>>Mês(es)<br>
                            <input type="radio" name="idadeEm" id="idadeEm" value="ano" <?php echo ($idadeEm == 'ano') ? 'checked' : ''; ?>>Ano(s)
                        </div>
                        <div class="col-md-6">
                            <?php echo isset($erro["idadeEm"]) ?   "<span class=\"label label-danger\">" . $erro["idadeEm"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Observação!</strong> Para serem submetidos à esterilização,
                                os animais devem ter no mínimo 6 (seis) meses e no máximo 8 (oito) anos.
                                O CCZ não realiza esterilização em animais idosos.
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group <?php echo isset($erro["cor"]) ? "has-error" : ""; ?>"">
                        <label class="col-md-3 control-label" for="cor">Cor(es) do animal:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cor" name="cor" maxlength="80" value="<?php echo isset($cor) ? $cor : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <?php echo isset($erro["cor"]) ?   "<span class=\"label label-danger\">" . $erro["cor"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["especie"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="especie">Espécie:</label>
                        <div class="col-md-6">
                            <input type="radio" name="especie" id="especie" value="felino" <?php echo ($especie == 'felino') ? 'checked' : ''; ?>>Felino
                            <input type="radio" name="especie" id="especie" value="canino" <?php echo ($especie == 'canino') ? 'checked' : ''; ?>>Canino
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["especie"]) ?   "<span class=\"label label-danger\">" . $erro["especie"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["raca_id"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="raca_id">Raça:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="raca_id" id="raca_id">
                                <option value="<?php echo isset($raca_id) ? $racaSelecionada->id : ""; ?>" selected><?php echo isset($raca_id) ? "&rarr;" . $racaSelecionada->descricao : "Escolha..."; ?></option>
                                <?php
                                TDBConnection::prepareQuery("select * from racas order by descricao;");
                                $racas = TDBConnection::resultset();
                                foreach ($racas as $raca) {
                                    echo "<option value=\"$raca->id\">$raca->descricao</option>" . EOL;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["raca_id"]) ?   "<span class=\"label label-danger\">" . $erro["raca_id"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="form-group <?php echo isset($erro["procedencia"]) ? "has-error" : ""; ?>">
                        <label class="col-md-3 control-label" for="procedencia">Origem:</label>
                        <div class="col-md-6">
                            <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" <?php echo ($procedencia == 'vive na rua / comunitario') ? 'checked' : ''; ?>>vive na rua/comunitário
                            <input type="radio" name="procedencia" id="procedencia" value="resgatado" <?php echo ($procedencia == 'resgatado') ? 'checked' : ''; ?>>Resgatado
                            <input type="radio" name="procedencia" id="procedencia" value="adotado" <?php echo ($procedencia == 'adotado') ? 'checked' : ''; ?>>Adotado
                            <input type="radio" name="procedencia" id="procedencia" value="comprado" <?php echo ($procedencia == 'comprado') ? 'checked' : ''; ?>>Comprado
                            <input type="radio" name="procedencia" id="procedencia" value="ONG" <?php echo ($procedencia == 'ONG') ? 'checked' : ''; ?>>ONG<br><br>
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($erro["procedencia"]) ?   "<span class=\"label label-danger\">" . $erro["procedencia"] . "</span>" : ""; ?>
                        </div>
                    </div>

                    <div class="well well text-center"><h2>Critérios e pré-requisitos para cadastro de esterilização de animais</h2></div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div>
                                <p>O cadastro para esterilização de cães e gatos deverá ser feito mediante preenchimento e envio deste formulário eletrônico. As solicitações serão avaliadas pela equipe responsável e, se aceitas, o solicitante deverá aguardar o contato da equipe do CCZ para agendamento. O prazo de espera poderá variar de acordo com a demanda. Cabe ao solicitante acompanhar o andamento de sua solicitação no site.</p>
                            </div>

                            <div class="text-justify">
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

                            <div class="alert alert-danger">
                                <input type="checkbox" name="concordar" id="concordar" value="sim">
                                <?php echo isset($erro["concordar"]) ?   "<span class=\"label label-danger\">" . $erro["concordar"] . "</span>" : ""; ?><strong>Declaro que li, aceito os termos e condições referentes ao cadastro para esterilização de animais e que as informações declaradas neste formulário são verdadeiras.</strong>
                            </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Clique para enviar o formulário</button>
                        </div>
                    </div>
                </form>
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
