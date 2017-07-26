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
    <title>SisCast - Pedidos de Agendamento Público</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    
    <body>
        <div class="estrutura">

            <!-- Cabeçalho-->

            <div class="logotipo">
                <img src="../img/logo.jpg" alt="logoContagem" class="imagem_logo">
            </div>

            <div class="titulosuperior">
                <h1>Cadastro para Esterilização de Animais</h1>
            </div>


            <!--/conteúdo-->

            <div class="conteudo">
                <?php
                // limpa as variáveis de entrada
                $nome = $cpf = $endereco = $numero = $complemento = $bairro = $cep = $tel = '';
                $cel = $cns = $beneficio = $beneficioQual = $nomeAnimal = $genero = $porte = $idade = '';
                $idadeEm = $cor = $especie = $raca_id = $procedencia = '';

                // executa o cadastro se possível
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // recebi e formata as variáveis

                    /* dados do pedinte */
                    $nome = (isset($_POST['nome']) ? strip_tags(trim($_POST['nome'])) : '');
                    $cpf = (isset($_POST['cpf']) ? strip_tags(trim($_POST['cpf'])) : '');
                    $nascimento = (isset($_POST['nascimento']) ? strip_tags(trim($_POST['nascimento'])) : '');

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
                    
                    /* validar cpf */
                    if (TCommon::valida_cpf($cpf) == false) {
                        header("Location: erro100.php");
                        exit;
                    }
                    
                    /* validar entradas vazias - não testado*/
                    if (($nome == '') || ($nascimento == '') || ($endereco == '')
                            || ($numero == '') || ($bairro == '') || ($cep == '')
                            || ($genero == '') || ($cel == '') || ($nomeAnimal == '')
                            || ($porte == '') || ($idade == 0) || ($idadeEm == '')
                            || ($cor == '')|| ($raca_id == 0)|| ($procedencia == '')){
                        header("Location: erro101.php");
                        exit;                        
                    }
                                        
                    /* validar número máximo de pedidos por cpf (5) */
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

                    header("Location: concluido.php?cpf=" . $cpf);
                    exit;
                }
                ?>

                <form name="formExec" id="formExec" method="post"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onSubmit="return validaForm();">
                    <fieldset>
                        <legend>Informações sobre o tutor:</legend>

                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" maxlength="140" size="36" required autofocus><br><br>

                        <label for="nascimento">Data Nascimento:</label>
                        <input type="date" name="nascimento" id="nascimento" required><br/><br/>

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
                        <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario" required>vive na rua / comunitário
                        <input type="radio" name="procedencia" id="procedencia" value="resgatado">Resgatado
                        <input type="radio" name="procedencia" id="procedencia" value="adotado">Adotado
                        <input type="radio" name="procedencia" id="procedencia" value="comprado">Comprado<br><br>                        

                        <br>

                    </fieldset>

                    <br>

                    <fieldset>
                        <legend>Critérios e pré-requisitos para cadastro e esterilização de animais no Centro de Controle de Zoonoses  de Contagem:</legend>
                        
                        <div>
                            <p>O cadastro para esterilização de cães e gatos deverá ser feito mediante preenchimento e envio do formulário eletrônico disponível no site oficial da Prefeitura Municipal de Contagem. Após o preenchimento e envio do formulário, as solicitações serão avaliadas pela equipe responsável e, se aceitas, o solicitante deverá aguardar o contato da equipe do CCZ para agendamento. O prazo para agendamento poderá variar de acordo com a demanda. Cabe ao solicitante acompanhar o andamento de sua solicitação no site.</p>
                            <p>O solicitante deverá atender a todos critérios e  pré-requisitos a seguir.</p>
                        </div>
                        
                        

                        <div>
                            <h1>Critérios quanto ao solicitante</h1>
                            <ul>
                                <li>O solicitante deve ser maior de 18 anos e residir no município de Contagem/MG.</li>
                                <li>Cada solicitante tem direito de cadastrar o limite máximo de 3 (três) animais, sendo que à medida em que as cirurgias forem realizadas, novas vagas serão disponibilizadas para cadastramento;</li>
                                <li>É de inteira responsabilidade do solicitante informar corretamente 1 (um) ou 2 (dois) contatos telefônicos.</li>
                                <li>A cada solicitação é gerado um número de cadastro para controle interno, não correspondendo à ordem de atendimento ou agendamento.</li>
                                <li>As solicitações passam por uma triagem, podendo ser aprovadas ou não. É de responsabilidade do solicitante acompanhar o andamento da sua solicitação pelo site.</li>
                                <li>Após a aprovação do cadastro, o solicitante deverá aguardar o contato telefônico do CCZ, de segunda a sexta-feira, em horário comercial, para fins de agendamento. Após 3 (três) tentativas de contato sem sucesso, o cadastro será cancelado, podendo o solicitante realizar novo cadastro quando desejar.</li>
                                <li>No dia agendado para a cirurgia de esterilização, é obrigatória a apresentação de documento de identidade com foto e comprovante de residência (IPTU, CEMIG, COPASA) em seu nome. Em caso de impossibilidade de comparecimento no dia agendado, o solicitante poderá designar um representante através de declaração escrita e assinada a ser apresentada ao CCZ juntamente com os documentos supracitados, bem como um documento de identificação do representante;</li>
                                <li>Caso o solicitante possua Carteira Nacional de Saúde (CNS), que pode ser emitida em qualquer unidade de saúde, ou benefício do governo, é obrigatória a apresentação de documentação comprobatória no dia agendado para a cirurgia.</li>
                                <li>No dia agendado para a cirurgia de esterilização o solicitante deve chegar com 30 minutos de antecedência, sob pena de ter o atendimento cancelado.</li>
                                <li>No dia agendado para a cirurgia, o solicitante deve: I) levar cobertor para o animal (felinos e caninos); II) levar atadura crepom (faixa) nova e colar elisabetano ou macacão cirúrgico (fêmeas); III) levar colar elisabetano (cães machos); IV) conduzir o animal em guia própria (caninos) ou em caixa de transporte própria (felinos). Importante: gatos não devem ser conduzidos no colo ou em guias, devido ao risco de fugas.</li>
                                <li>Na impossibilidade de comparecimento com o animal no dia agendado, o solicitante deverá entrar em contato por telefone com até 24 horas de antecedência, para desmarcar.</li>
                                <li>Em caso de ausência no dia agendado, sem aviso prévio, a solicitação será cancelada e o interessado só terá direito a realizar novo processo de cadastramento para cirurgia de esterilização do animal decorridos 6 (seis) meses contados a partir da data agendada.</li>
                                <li>Excepcionalmente, o CCZ poderá cancelar cirurgias agendadas, ocasião em que o solicitante será comunicado por telefone com até 24 horas de antecedência e o procedimento será remarcado.</li>
                                <li>A cirurgia de esterilização só será realizada mediante leitura, preenchimento e assinatura pelo solicitante do Termo de Autorização para Realização de Cirurgia.</li>
                            </ul>
                            <h1>Critérios quanto aos cães e gatos</h1>
                            <ul>
                                <li>Para serem submetidos à esterilização, os animais devem ter no mínimo 6 (seis) meses e no máximo 8 (oito) anos. O CCZ não realiza esterilização em animais idosos.</li>
                                <li>O CCZ não realiza esterilização em animais com lesões cutâneas, epilépticos, obesos, no cio (cadelas) ou em gestação avançada (gatas ou cadelas). Se a cadela estiver no cio, deve-se aguardar pelo menos 20 dias após o término do mesmo para realizar a esterilização. Em caso de gestação  (gatas ou cadelas) recente, deve-se aguardar pelo menos 60 dias após o parto para realizar a esterilização.</li>
                                <li>Cadelas só podem ser submetidas à cirurgia de esterilização decorridos pelo menos 20 dias do final do cio.</li>
                                <li>Gatas e cadelas só podem ser submetidas à cirurgia de esterilização decorridos pelo menos 60 dias após o parto.</li>
                                <li>Antes da cirurgia de esterilização, os animais são submetidos a exame clínico pelo médico veterinário do CCZ,  podendo ser considerados inaptos para a cirurgia, caso sejam constatadas quaisquer alterações consideradas significativas e que impossibilitem a realização da cirurgia.</li>
                                <li>No caso de caninos, o solicitante pode apresentar exame recente (menos de 6 meses) de leishmaniose ou submeter o animal, no CCZ, ao teste rápido para Leishmaniose Visceral no dia agendado. Em caso de resultado negativo a cirurgia poderá ser realizada imediatamente. Em caso de resultado positivo, a cirurgia não poderá ser realizada imediatamente e o solicitante deverá aguardar o resultado de um segundo exame sorológico confirmatório para Leishmaniose Visceral.</li>
                                <li>Só serão esterilizados animais com exame positivo para Leishmaniose visceral ou que estejam em tratamento veterinário de qualquer tipo, mediante laudo de médico veterinário responsável pelo tratamento, autorizando a cirurgia de esterilização.</li>
                                <li>O CCZ não realiza exames de risco cirúrgico, sendo altamente recomendado que o solicitante o faça por conta própria.</li>
                                <li>Cães e gatos comunitários ou abandonados recolhidos pelo CCZ são atendidos prioritariamente, assim como cães e gatos pertencentes a imóveis ou regiões do município onde seja constatada a necessidade de atendimento imediato, em face da superpopulação de animais, alto risco epidemiológico, calamidades e/ou outros casos específicos mediante avaliação do corpo técnico do CCZ.</li>
                                <li>Cães e gatos comunitários ou abandonados recolhidos por organizações da sociedade civil poderão ser atendidos segundo critérios específicos, objetivando a cooperação mútua, controle populacional ético, guarda responsável e/ou adoção dos animais, mediante celebração de convênios.</li>                                
                            </ul>
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
                        <strong>Central de Controle de Zoonoses</strong><br>
                        Telefones: 3351-3751 / 3361-7703<br>
                        E-mail: cczcontagem@gmail.com
                    </p>
                </div>
            </div>

            <!-- scripts da página -->
            <script src="cadastro.js"></script>
        </div>    
    </body>
</html>

