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
                <div class="panel-heading">Fazer um Cadastro
                </div>
                <br>
                <form class="form-horizontal" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

                    <div class="well well text-center"><h2>Informações Sobre o Tutor</h2></div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nome">Nome:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nome" name="nome"
                                   placeholder="Digite seu nome completo" autofocus required maxlength="140">
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cpf">CPF:</label>
                        <div class="col-md-3">
                            <input type="number" class="form-control" id="cpf" name="cpf" required>
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">E-mail:</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Digite seu e-mail" required maxlength="200">
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cep">CEP:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="cep" name="cep" required maxlength="8">
                        </div>
                        <div class="col-md-7"></div>
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

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="endereco">Endereço:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="endereco" name="endereco" required disabled>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="bairro">Bairro:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="bairro" name="bairro" required disabled>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cidade">Cidade:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="cidade" name="cidade" required disabled>
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="estado">Estado:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="estado" name="estado" required disabled>
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="numero">Número:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="numero" name="numero" required maxlength="20">
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="complemento">Complemento:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="60">
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="telefone">Telefone:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="telefone" name="telefone" required maxlength="20">
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="celular">Celular:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="celular" name="celular" required maxlength="20">
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cns">Cartão Nacional de Saúde:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cns" name="cns" required maxlength="20">
                        </div>
                        <div class="col-md-6"></div>
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

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="beneficio">Possui benefício de algum programa social do governo?</label>
                        <div class="col-md-6">
                            <input type="radio" name="beneficio" id="beneficio" value="S" required>Sim
                            <input type="radio" name="beneficio" id="beneficio" value="N">Não
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="beneficioQual">Se sim, qual(is)?</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="beneficioQual" name="beneficioQual" maxlength="120">
                        </div>
                        <div class="col-md-5"></div>
                    </div>

                    <div class="well well text-center"><h2>Informações Sobre o Animal</h2></div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nomeAnimal">Nome do animal:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="nomeAnimal" name="nomeAnimal" required maxlength="120">
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="genero">Gênero:</label>
                        <div class="col-md-6">
                            <input type="radio" name="genero" id="genero" value="M" required>Macho
                            <input type="radio" name="genero" id="genero" value="F">Fêmea<br><br>
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="porte">Porte:</label>
                        <div class="col-md-6">
                            <input type="radio" name="porte" id="porte" value="pequeno" required>Pequeno
                            <input type="radio" name="porte" id="porte" value="medio">Médio
                            <input type="radio" name="porte" id="porte" value="grande">Grande<br><br>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="idade">Idade do animal:</label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" id="idade" name="idade" required>
                            <span><input type="radio" name="idadeEm" id="idadeEm" value="mes" required>Mês(es)
                            <input type="radio" name="idadeEm" id="idadeEm" value="ano">Ano(s)</span>
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong>Observação!</strong>Para serem submetidos à esterilização,
                                os animais devem ter no mínimo 6 (seis) meses e no máximo 8 (oito) anos.
                                O CCZ não realiza esterilização em animais idosos.
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="cor">Cor(es) do animal:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cor" name="cor" required maxlength="80">
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="especie">Espécie:</label>
                        <div class="col-md-6">
                            <input type="radio" name="especie" id="especie" value="felino" required>Felino
                            <input type="radio" name="especie" id="especie" value="canino">Canino
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="raca_id">Raça:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="raca_id" id="raca_id" required>
                                <option value="" selected>Escolha...</option>
                                <?php
                                TDBConnection::prepareQuery("select * from racas order by descricao;");
                                $racas = TDBConnection::resultset();
                                foreach ($racas as $raca) {
                                    echo "<option value=\"$raca->id\">$raca->descricao</option>" . EOL;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="procedencia">Origem:</label>
                        <div class="col-md-6">
                            <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" required>vive na rua/comunitário
                            <input type="radio" name="procedencia" id="procedencia" value="resgatado">Resgatado
                            <input type="radio" name="procedencia" id="procedencia" value="adotado">Adotado
                            <input type="radio" name="procedencia" id="procedencia" value="comprado">Comprado
                            <input type="radio" name="procedencia" id="procedencia" value="ONG">ONG<br><br>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="well well text-center"><h2>Critérios e pré-requisitos para cadastro de esterilização de animais</h2></div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
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
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
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
