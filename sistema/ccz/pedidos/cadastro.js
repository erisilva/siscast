function validaForm() {

    var f = document.formExec;


    if (f.nome.value === "")
    {
        alert("Digite seu nome no campo.");
        f.nome.focus();
        return false;
    }

    if (f.cpf.value === "")
    {
        alert("Digite seu cpf no campo.");
        f.cpf.focus();
        return false;
    }

    if (f.endereco.value === "")
    {
        alert("Digite seu endereço.");
        f.endereco.focus();
        return false;
    }

    if (f.bairro.value === "")
    {
        alert("Digite o seu bairro.");
        f.bairro.focus();
        return false;
    }

    if (vercpf(f.cpf.value) === false)
    {
        alert("CPF Inválido.");
        f.cpf.focus();
        return false;
    }
    

    if (f.cep.value === "")
    {
        alert("Digite o seu CEP.");
        f.cep.focus();
        return false;
    }
    

    if (f.tel.value === "")
    {
        alert("Digite o número de seu telefone.");
        f.tel.focus();
        return false;
    }
    

    if (f.cel.value === "")
    {
        alert("Digite o número do seu celular.");
        f.cel.focus();
        return false;
    }
    

    if (f.email.value === "")
    {
        alert("Digite deu e-mail.");
        f.email.focus();
        return false;
    }    
    
    
    if (f.nomeAnimal.value === "")
    {
        alert("Digite o nome do animal.");
        f.nomeAnimal.focus();
        return false;
    } 
    
    if (f.genero.value === "")
    {
        alert("Escolha o genero do animal.");
        f.nome.focus();
        return false;
    } 


    if (f.porte.value === "")
    {
        alert("Escolha o porte do animal.");
        f.nome.focus();
        return false;
    } 
    
    if (f.idade.value === "")
    {
        alert("Preencha a idade do animal.");
        f.idade.focus();
        return false;
    } 
    
    if (f.cor.value === "")
    {
        alert("Digite a cor do animal.");
        f.cor.focus();
        return false;
    }     

    if (f.especie.value === "")
    {
        alert("Escolha a espécie do animal.");
        f.nome.focus();
        return false;
    }     
    
    
    if (f.raca.value === "")
    {
        alert("Digite a raça do animal.");
        f.raca.focus();
        return false;
    }     
    
    
    if (f.procedencia.value === "")
    {
        alert("Escolha a procedencia do animal.");
        f.nome.focus();
        return false;
    }     
     
    
    return true;
}


function vercpf(cpf)
{
    if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
        return false;

    add = 0;

    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    //alert('O CPF INFORMADO É VÁLIDO.');
    return true;
}