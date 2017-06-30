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
    <title>SisCast - Alteração de Pedidos</title>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">    
    <link rel="stylesheet" type="text/css" href="../estilo/navegacao.css">    
    <body>
        <div class="estrutura_popup">


            <!--/conteúdo-->
            <?php
            $id = (isset($_GET['id']) ? $_GET['id'] : NULL);

            TDBConnection::prepareQuery("
                        SELECT pedidos.*, 
                        date_format(pedidos.quando, '%d/%m/%y %H:%i') as quandoFormatado 

                        from pedidos
                         where pedidos.id = :id;");
            TDBConnection::bindParamQuery(':id', $id, PDO::PARAM_INT);
            $result = TDBConnection::single();
            $nRows = TDBConnection::rowCount();
            ?>


            <div class="estrutura_popup">

              <form name="formAlterarExec" id="formExec" method="post"
                    action="alterarExec.php" onSubmit="return validaForm();">
                    <fieldset>
                        
                        <input type="hidden" name="id" value="<?php echo $result->id ?>">
                        
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" maxlength="140" size="36" required autofocus value="<?php echo $result->nome ?>"><br><br>

                        <label for="cpf">CPF:</label>
                        <input type="text" name="cpf" id="cpf" maxlength="11" size="12" required value="<?php echo $result->cpf ?>"><br><br>

                        <label for="endereco">Endereço:</label>
                        <input type="text" name="endereco" id="endereco" maxlength="255" size="36" required value="<?php echo $result->endereco ?>"><br/><br/>                        

                        <label for="numero">Número:</label>
                        <input type="text" name="numero" id="numero" maxlength="20" size="9" value="<?php echo $result->numero ?>"><br/><br/>  

                        <label for="complemento">Complemento:</label>
                        <input type="text" name="complemento" id="complemento" maxlength="60" size="18" value="<?php echo $result->complemento ?>"><br/><br/>  

                        <label for="bairro">Bairro:</label>
                        <input type="text" name="bairro" id="bairro" maxlength="140" size="20" required value="<?php echo $result->bairro ?>"><br/><br/>                       

                        <label for="cep">CEP:</label>
                        <input type="text" name="cep" id="cep" maxlength="10" size="10" required value="<?php echo $result->cep ?>"><br/><br/>                        

                        <label for="tel">Telefone:</label>
                        <input type="text" name="tel" id="tel" maxlength="20" size="10" required value="<?php echo $result->tel ?>"><br/><br/>                         

                        <label for="cel">Celular:</label>
                        <input type="text" name="cel" id="cel" maxlength="20" size="10" required value="<?php echo $result->cel ?>"><br/><br/>                        

                        <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" maxlength="180" size="36" required value="<?php echo $result->email ?>"><br/><br/><br/>                       

                        <label for="nomeAnimal">Nome do animal:</label>
                        <input type="text" name="nomeAnimal" id="nomeAnimal" maxlength="120" size="20" required value="<?php echo $result->nomeAnimal ?>"><br/><br/>                       


                        <label for="genero">Gênero:</label>
                        <input type="radio" name="genero" id="genero" value="M" <?php echo (($result->genero == 'M') ? 'checked' : '' )?>>Macho
                        <input type="radio" name="genero" id="genero" value="F" <?php echo (($result->genero == 'F') ? 'checked' : '' )?>>Fêmea<br><br>

                        <label for="porte">Porte:</label>
                        <input type="radio" name="porte" id="porte" value="pequeno" <?php echo (($result->porte == 'pequeno') ? 'checked' : '' )?>>Pequeno
                        <input type="radio" name="porte" id="porte" value="medio" <?php echo (($result->porte == 'medio') ? 'checked' : '' )?>>Médio
                        <input type="radio" name="porte" id="porte" value="grande" <?php echo (($result->porte == 'grande') ? 'checked' : '' )?>>Grande<br><br>

                        <label for="idade">Idade:</label>
                        <input type="number" name="idade" id="idade" min="1" max="20" required value="<?php echo $result->idade ?>"><br/><br/> 


                        <label for="cor">Cor do animal:</label>
                        <input type="text" name="cor" id="cor" maxlength="80" size="20" required value="<?php echo $result->cor ?>"><br/><br/>                       

                        <label for="especie">Espécie:</label>
                        <input type="radio" name="especie" id="especie" value="gato"  <?php echo (($result->especie == 'gato') ? 'checked' : '' )?>>Gato
                        <input type="radio" name="especie" id="especie" value="cachorro" <?php echo (($result->especie == 'cachorro') ? 'checked' : '' )?>>Cachorro<br><br>

                        <label for="raca">Raça:</label>
                        <input type="text" name="raca" id="raca" maxlength="120" size="20" required value="<?php echo $result->raca ?>"><br/><br/>                       

                        <label for="procedencia">Origem:</label>
                        <input type="radio" name="procedencia" id="procedencia" value="vive na rua / comunitario"  <?php echo (($result->procedencia == 'vive na rua / comunitario') ? 'checked' : '' )?>>vive na rua / comunitário
                        <input type="radio" name="procedencia" id="procedencia" value="resgatado" <?php echo (($result->procedencia == 'resgatado') ? 'checked' : '' )?>>Resgatado
                        <input type="radio" name="procedencia" id="procedencia" value="adotado" <?php echo (($result->procedencia == 'adotado') ? 'checked' : '' )?>>Adotado
                        <input type="radio" name="procedencia" id="procedencia" value="comprado" <?php echo (($result->procedencia == 'comprado') ? 'checked' : '' )?>>Comprado<br><br>                        

                        <div class="alinha">
                            <input type="submit" name="Agendar" id="Agendar"
                                   value="Alterar Pedido de Agenda">
                        </div>

                    </fieldset>
                </form>

                <br>


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
        <script src="alterar.js"></script>
    </body>
</html>

