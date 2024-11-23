 document.addEventListener('DOMContentLoaded', function() {
    var tentativas = 0; // Contador de tentativas de login

    document.getElementById('formLogin').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        var email = document.getElementById('email').value;
        var senha = document.getElementById('senha').value;

        // Verifica se os campos não estão vazios
        if (email === '' || senha === '') {
            document.getElementById('mensagem').innerText = 'Preencha todos os campos!';
            return;
        }

        // Cria uma requisição AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Processa a resposta do PHP (esperando JSON)
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var resposta = JSON.parse(xhr.responseText);

                    // Se o login foi bem-sucedido, redireciona para a página principal
                    if (resposta.sucesso) {
                        window.location.href = resposta.redirecionar;
                    } else {
                        // Incrementa o número de tentativas
                        tentativas++;
                        document.getElementById('mensagem').innerText = resposta.mensagem;

                        // Verifica se o número de tentativas excedeu 5
                        if (tentativas >= 5) {
                            document.getElementById('mensagem').style.color = 'red'; // Deixa a mensagem em vermelho
                            document.getElementById('mensagem').innerText = 'Muitas tentativas de login falhadas! Volte mais tarde...';

                            // Aguarda 10 segundos e redireciona para a página de recuperação de senha
                            setTimeout(function() {
                                window.location.href = '../SENHA/ESQUECI SENHA/esquecisenha.html';
                            }, 10000); // 10 segundos = 10000 milissegundos
                        }
                    }
                } catch (e) {
                    document.getElementById('mensagem').innerText = 'Tarde demais ao processar a resposta.';
                }
            } else {
                document.getElementById('mensagem').innerText = 'Erro ao processar a solicitação.';
            }
        };

        // Envia os dados do formulário para o PHP
        xhr.send('email=' + encodeURIComponent(email) + '&senha=' + encodeURIComponent(senha));
    });
});



let fontSize = 18; 
document.getElementById('aumentar-fonte').addEventListener('click', function() {
    if (fontSize < 30) { 
    fontSize += 2;
    document.body.style.fontSize = fontSize + 'px';
    }
});

document.getElementById('diminuir-fonte').addEventListener('click', function() {
    if (fontSize > 10) { 
        fontSize -= 2;
        document.body.style.fontSize = fontSize + 'px';
    }
});

// Seleciona o botão de tema e o corpo do documento
let tema = document.getElementById('botao-tema');

// Função para aplicar o tema com base no localStorage
function aplicarTema() {
    if (localStorage.getItem('tema') === 'escuro') {
        document.body.classList.add('tema-escuro');
        tema.innerHTML = '<i class="bi bi-moon-stars"></i>';
    } else {
        document.body.classList.remove('tema-escuro');
        tema.innerHTML = '<i class="bi bi-brightness-high"></i>';
    }
}


aplicarTema();


tema.addEventListener('click', function () {
    document.body.classList.toggle('tema-escuro');
    
    
    if (document.body.classList.contains('tema-escuro')) {
        tema.innerHTML = '<i class="bi bi-moon-stars"></i>';
        localStorage.setItem('tema', 'escuro');  // Salva o tema escuro no localStorage
    } else {
        tema.innerHTML = '<i class="bi bi-brightness-high"></i>';
        localStorage.setItem('tema', 'claro');  // Salva o tema claro no localStorage
    }
});