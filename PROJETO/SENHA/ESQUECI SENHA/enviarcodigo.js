
$(document).ready(function() {
    $('#formEsqueciSenha').on('submit', function(e) {
        e.preventDefault(); // Previne o envio do formulário tradicional
        
        var email = $('#email').val(); // Obtém o valor do campo de e-mail
        
        // Envia a requisição AJAX para o PHP
        $.ajax({
            type: 'POST',
            url: 'backend/email.php',
            data: { email: email },
            success: function(response) {
                if (response === 'success') {
                    // Redireciona para altersenha.html se o e-mail for válido
                    window.location.href = '2fa/2fa.html';
                } else {
                    // Exibe a mensagem de erro se o e-mail não estiver registrado
                    $('#mensagem').html('E-mail não registrado').css('color', 'red');
                }
            }
        });
    });
})
