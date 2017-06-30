<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title> TreinaWeb Cursos - jQuery </title>
        <link rel="stylesheet" type="text/css" href="padrao.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <!-- se o CDN não for ativo faz o carregamento da jquery diretamente -->
        <script>window.jQuery || document.write('<script src="./js/jquery.min.js"><\/script>');</script>
        <script type="text/javascript" src="padrao.js" ></script>
    </head>
    <body>
        <div id="titulo" class="titulo">
            <h2> jQuery - Projeto Final </h2>
            <p> Formulário para preenchimento de dados pessoais e preferências </p>
        </div>
        <form name="formulario" id="formulario" class="formulario">
            <div id="dados_pessoais" class="grupo">
                <span><label for="nome">Nome</label><input type="text" id="nome" name="nome" /></span><br />
                <span><label for="sobrenome">Sobrenome</label><input type="text" id="sobrenome" name="sobrenome" /></span><br />
                <span><label for="apelido">Apelido</label><input type="text" id="apelido" name="apelido" /></span><br />
                <span><label for="datanascimento">Data de Nascimento</label><input type="text" id="datanascimento" name="datanascimento" /></span><br />
                <span>Gênero</span><br />
                <span><input type="radio" name="genero" id="masculino" /> Masculino </span><br />
                <span><input type="radio" name="genero" id="feminino" /> Feminino </span><br />
            </div>
            <div id="acesso" class="grupo">
                <span><label for="usuario">Usuário</label><input type="text" id="usuario" name="usuario" /></span><br />
                <span><label for="senha">Senha</label><input type="password" id="senha" name="senha" /></span><br />
                <span><input type="checkbox" name="exibirsenha" id="exibirsenha" /> Exibir senha </span><br />
            </div>
            <div id="contato" class="grupo">
                <span><label for="endereco">Endereço</label><input type="text" id="endereco" name="endereco" /></span><br />
                <span><label for="telefone">Telefone</label><input type="text" id="telefone" name="telefone" /></span><br />
                <span><label for="email">E-mail</label><input type="text" id="email" name="email" /></span><br />
            </div>
            <div id="preferencias" class="grupo">
                <span>Sistemas Operacionais</span><br />
                <span><input type="checkbox" name="windows" id="windows" /> Windows </span><br />
                <span><input type="checkbox" name="linux" id="linux" /> GNU Linux </span><br />
                <span><input type="checkbox" name="mac" id="mac" /> MacOS </span><br />
                <span><input type="checkbox" name="outro" id="outro" /> Outro </span><br />
                <span>Linguagens de Programação</span><br />
                <span><input type="checkbox" name="javascript" id="javascript" /> JavaScript </span><br />
                <span><input type="checkbox" name="php" id="php" /> PHP </span><br />
                <span><input type="checkbox" name="java" id="java" /> JAVA </span><br />
                <span><input type="checkbox" name="outra" id="outra" /> Outra </span><br />
                <span>Bibliotecas</span><br />
                <span><input type="checkbox" name="jquery" id="jquery" /> jQuery </span><br />
                <span><input type="checkbox" name="jqueryui" id="jqueryui" /> jQuery UI </span><br />
                <span><input type="checkbox" name="qunit" id="qunit" /> QUnit </span><br />
                <span><input type="checkbox" name="nenhuma" id="nenhuma" /> Nenhuma </span><br />
            </div>
            <div id="observacoes" class="grupo">
                <span>Observações</span><br />
                <span><textarea id="obs" name="obs" cols="50" rows="10"></textarea></span><br />
            </div>
            <div id="botoes" class="grupo">
                <span><button id="ok" name="ok">OK</button><button id="limpar" name="limpar">Limpar</button></span><br />
            </div>
        </form>
    </body>
</html>

