function validaForm() {

    var f = document.formAlterarSenha;

    if (f.senhaAtual.value.length < 4)
    {
        alert("Sua senha atual tem mais de 4 caracteres.");
        f.senhaAtual.focus();
        return false;
    }

    if (f.novaSenha.value !== f.novaSenhaRepetir.value)
    {
        alert("Sua nova senha não foi confirmada corretamente.");
        f.novaSenhaRepetir.focus();
        return false;
    }

    if (f.novaSenha.value.length < 4)
    {
        alert("Sua nova senha deve ter no mínimo 4 caractéres.");
        f.novaSenha.focus();
        return false;
    }

    return true;
}


