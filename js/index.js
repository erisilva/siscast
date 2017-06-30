/* 
 * 
 * 
 * 
 */
$(document).ready(function(){
	
	$('#formEntrar').submit(function(){ 	//Ao submeter formulário
		var login=$('#loginusuario').val();	//Pega valor do campo email
		var senha=$('#senhausuario').val();	//Pega valor do campo senha
		$.ajax({			//Função AJAX
			url:"login.php",			//Arquivo php
			type:"post",				//Método de envio
			data: "loginusuario="+login+"&senhausuario="+senha,	//Dados
   			success: function (result){			//Sucesso no AJAX
                		if(result==1){ 
                			location.href='cadastro.php'	//Redireciona
                		}else{                                                                                
                                        alert('Login ou senha incorretos!'); //Informa o erro
                		}
            		}
		})
		return false;	//Evita que a página seja atualizada
	})
});



