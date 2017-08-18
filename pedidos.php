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
                <img src="img/logo.png" alt="logoContagem" class="imagem_logo"> 
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
            <?php
            // recebe variáveis pelo metodo de post, passagem por formulário
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $filtroNome = (!isset($_POST["filtroNome"]) ? "%" : $_POST["filtroNome"]);
                $filtroCPF = (!isset($_POST["filtroCPF"]) ? "%" : $_POST["filtroCPF"]);
                $filtroEspecie = (!isset($_POST["filtroEspecie"]) ? "%" : $_POST["filtroEspecie"]);
                $filtroGenero = (!isset($_POST["filtroGenero"]) ? "" : $_POST["filtroGenero"]);
                $filtroPorte = (!isset($_POST["filtroPorte"]) ? "" : $_POST["filtroPorte"]);
                $situacaoFiltro = (!isset($_POST["situacaoFiltro"]) ? "" : $_POST["situacaoFiltro"]);
                $ordem = (!isset($_POST["ordem"]) ? 1 : $_POST["ordem"]);
                
            } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
                // recebe as variaveis pelo metodo de GET, passagem por link
                // usado para paginar o resultado das consultas  
                $filtroNome = (!isset($_GET["filtroNome"]) ? "%" : $_GET["filtroNome"]);
                $filtroCPF = (!isset($_GET["filtroCPF"]) ? "%" : $_GET["filtroCPF"]);
                $filtroEspecie = (!isset($_GET["filtroEspecie"]) ? "" : $_GET["filtroEspecie"]);
                $filtroGenero = (!isset($_GET["filtroGenero"]) ? "" : $_GET["filtroGenero"]);
                $filtroPorte = (!isset($_GET["filtroPorte"]) ? "" : $_GET["filtroPorte"]);
                $situacaoFiltro = (!isset($_GET["situacaoFiltro"]) ? "" : $_GET["situacaoFiltro"]);
                $ordem = (!isset($_GET["ordem"]) ? 1 : $_GET["ordem"]);
                
            } else {
                $filtroNome = "";
                $filtroCPF = "";
                $filtroEspecie = "";
                $filtroGenero = "";
                $filtroPorte = "";
                $situacaoFiltro = "";
                $ordem = 1;
            }
            
            /* ajusta os filtros */
            $filtroNomeFormatado = TCommon::FormataNomeFiltro($filtroNome);
            $filtroCPFFormatado = TCommon::FormataNomeFiltro($filtroCPF);
            ?>            

            <div class="conteudo">
                <div class="subtitulo">
                    <form name="formFiltro" id="formFiltro" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <fieldset>
                            <legend>Pedidos :: Consultar/Alterar</legend>

                            Nome:<input type="text" name="filtroNome" id="filtroNome"
                                        maxlength="160" size="15" autofocus>

                            CPF:<input type="text" name="filtroCPF" id="filtroCPF"
                                       maxlength="11" size="10">
                            
                            <br><br>

                            <select name="filtroEspecie" id="filtroEspecie">
                                <option value="" selected>Espécie</option>
                                <option value="canino">Canino</option>
                                <option value="felino">Felino</option>
                            </select>
                            
                            <select name="filtroGenero" id="filtroGenero">
                                <option value="" selected>Gênero</option>
                                <option value="F">Fêmea</option>
                                <option value="M">Macho</option>
                            </select>
                            
                            <select name="filtroPorte" id="filtroPorte">
                                <option value="" selected>Porte</option>
                                <option value="pequeno">Pequeno</option>
                                <option value="medio">Médio</option>
                                <option value="grande">Grande</option>
                            </select>                            

                            <select name="situacaoFiltro" id="situacaoFiltro">
                            <option value="" selected>Situação</option>
                            <?php
                            TDBConnection::prepareQuery("select * from situacoes order by nome;");
                            $situacoes = TDBConnection::resultset();
                            foreach ($situacoes as $situacao) {
                                echo "<option value=\"$situacao->id\">$situacao->nome</option>" . EOL;
                            }
                            ?>
                            </select>

                            <select name="ordem" id="ordem">
                                <option value="1" selected>Mostrar pedidos mais recentes</option>
                                <option value="2">Mostrar pedidos mais antigos</option>
                                <option value="3">Ordenar pelo nome do tutor</option>
                            </select>
                            
                            <br>

                            <input type="submit" name="procurar" id="procurar"
                                   value="Buscar">

                            <input type="reset" name="limpar" id="limpar"
                                   value="Limpar">
                        </fieldset>
                    </form>
                    <br>
                </div>                

<?php
include_once('grade/grade.php');

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

if ($page <= 0)
    $page = 1;

$per_page = 15; // quantidade de registros por página

$startpoint = ($page * $per_page) - $per_page;

$statement = " pedidos
                                inner join situacoes on (pedidos.situacao_id = situacoes.id) ";

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
                                concat(lpad(pedidos.codigo, 6, '0'), '/', pedidos.ano ) as codigoInterno,
                                date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado,
                            pedidos.nome,
                            pedidos.nomeAnimal,
                            pedidos.especie,
                            pedidos.genero,
                            pedidos.porte,
                            situacoes.nome as situacao "
        . "from {$statement} LIMIT {$startpoint} , {$per_page}";

//echo $query;

TDBConnection::getConnection();
TDBConnection::prepareQuery($query);
$result = TDBConnection::resultset();
$nRows = TDBConnection::rowCount();

if ($nRows != 0) {
    echo "\n";
    echo "\n";
    echo "<table>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    //cabeçalho da tabela
    echo "<th class=\"alinha_direita\">Código</th>\n";
    echo "<th>Data/Hora</th>\n";
    echo "<th>Tutor</th>\n";
    echo "<th>Animal</th>\n";
    echo "<th>Espécie</th>\n";
    echo "<th>G.</th>\n";
    echo "<th>Porte</th>\n";
    echo "<th>Situação</th>\n";
    echo "<th class=\"alinha_direita\">...</th>\n";
    echo "<th class=\"alinha\">...</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";

    foreach ($result as $temp) {
        echo "<tr>\n";

        echo "<td class=\"alinha_direita\">\n";
        echo $temp->codigoInterno . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->quandoFormatado . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->nome . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->nomeAnimal . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->especie . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->genero . "\n";
        echo "</td>\n";


        echo "<td>\n";
        echo $temp->porte . "\n";
        echo "</td>\n";

        echo "<td>\n";
        echo $temp->situacao . "\n";
        echo "</td>\n";

        echo "<td class=\"alinha_direita\">\n";
        echo "<a href=\" javascript:abrir('pedidos/agendar.php?id=" . $temp->id . "') \">Agendar</a>\n";
        echo "</td>\n";

        echo "<td>\n";
        echo "<a href=\" javascript:abrir('pedidos/formAlterar.php?id=" . $temp->id . "') \">Alterar</a>\n";
        echo "</td>\n";

        echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
} else {
    echo "Nenhum registro foi encontrado.";
}

// mostrando o conjunto de páginas.
// salvando o filtro de consulta
$filtroConsulta = "filtroNome=" . $filtroNome . "&";
$filtroConsulta .= "filtroCPF=" . $filtroCPF . "&";
$filtroConsulta .= "filtroEspecie=" . $filtroEspecie . "&";
$filtroConsulta .= "filtroGenero=" . $filtroGenero . "&";
$filtroConsulta .= "filtroPorte=" . $filtroPorte . "&";
$filtroConsulta .= "situacaoFiltro=" . $situacaoFiltro . "&";
$filtroConsulta .= "ordem=" . $ordem . "&";

echo pagination($statement, $per_page, $page, $url = '?' . $filtroConsulta);
?>

                <div class="menuTopo">
                    <ul class="submenu">
                        <li><a  id="erivelton" href="pedidos.php">Limpar Filtros</a></li>
                        <li><a href="cadastro.php">Novo Cadastro</a></li>
                        <li><a href="pedidos/exportar.php?<?php echo $filtroConsulta. "t=1"  ?>">Exportar</a></li>
                        <li><a href="javascript:location.reload();">Atualizar Página</a></li>
                    </ul>
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


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
        <script>window.jQuery || document.write('<script src="/mvc2/js/jquery.min.js"><\/script>');</script>        
        <!-- scripts da página -->
        <script src="js/protocolo.js"></script>
        <script src="js/lib.js"></script>
    </body>
</html>                

