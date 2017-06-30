/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Ao carregar o documento ...
$(document).ready(function () {

    // Delega o evento
    // classe é um ponto .
    // id é um jogo da velha #

    $(".subtitulo").click(function () {

        // Exibe o alerta
        alert("Você clicou no título outra vez.");
        
        
        // colore de vermelho os elementos com classe frontend
        $("#cursos .frontend").css("color", "red");

    });

    // Altera o estilo do elemento
    // $("#cursos").css("border", "solid 1px gray");
    
    // $("#cursos .frontend").css("color", "green");
    
    // nesse caso colore-se somente os elementos da lista
    // na ordem impar
    $("#cursos li:even").css("color", "green");

});

