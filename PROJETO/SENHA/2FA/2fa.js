let tentativas = 0; 
const maxTentativas = 3; 
let perguntaAtual = "";  // Para armazenar a pergunta atual que será enviada para o backend

// Função para obter pergunta aleatória
function obterPerguntaAleatoria() {
    const perguntas = [
        { pergunta: "Qual o nome da sua mãe?", chave: "nome_materno" },
        { pergunta: "Qual a data do seu nascimento?", chave: "data_nascimento" },
        { pergunta: "Qual o CEP do seu endereço?", chave: "cep" }
    ];

    const indiceAleatorio = Math.floor(Math.random() * perguntas.length);
    return perguntas[indiceAleatorio];
}

// Função para exibir pergunta aleatória
function exibirPergunta() {
    const perguntaObj = obterPerguntaAleatoria();
    perguntaAtual = perguntaObj.chave;  // Armazena a chave da pergunta para enviar ao backend

    let perguntaFormatada = perguntaObj.pergunta;

    if (perguntaAtual === "cep") {
        perguntaFormatada = "Qual o CEP do seu endereço? (Formato: 25070-200)";
    } else if (perguntaAtual === "data_nascimento") {
        perguntaFormatada = "Qual a data do seu nascimento? (Formato: YYYY-MM-DD)";
    }

    document.getElementById('container-pergunta').innerText = perguntaFormatada;
}

// Função para formatar CEP
function formatarCEP(cep) {
    cep = cep.replace(/\D/g, '');
    return cep.replace(/^(\d{5})(\d{0,3})$/, "$1-$2");
}

// Função para formatar Data
function formatarData(data) {
    data = data.replace(/\D/g, '');
    return data.replace(/^(\d{0,4})(\d{2})(\d{2})$/, "$1-$2-$3");
}

// Função para tratar envio de resposta
function tratarEnvio(evento) {
    evento.preventDefault(); 
    let respostaUsuario = document.getElementById('resposta').value.trim();

    if (respostaUsuario === "") {
        exibirMensagem("Por favor, preencha a resposta.");
        return;
    }

    const respostaUsuarioLimpa = respostaUsuario.replace(/\D/g, '');

    // Validações específicas
    if (perguntaAtual === "cep" && respostaUsuarioLimpa.length !== 8) {
        exibirMensagem("O CEP deve ter exatamente 8 dígitos.");
        return;
    } else if (perguntaAtual === "data_nascimento" && respostaUsuarioLimpa.length > 8) {
        exibirMensagem("A data deve conter no máximo 8 dígitos.");
        return;
    }

    // Envio da resposta e pergunta ao backend via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '2fa.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            const resposta = JSON.parse(xhr.responseText);
            if (resposta.sucesso) {
                exibirMensagem("Autenticação bem-sucedida!");
                window.location.href = '../../ALTERAR SENHA/alterarsenha.html';
                document.getElementById('container').style.backgroundColor = 'green';
            } else {
                tentativas++;
                if (tentativas >= maxTentativas) {
                    exibirMensagem("3 tentativas sem sucesso! Favor realizar login novamente.");
                    setTimeout(() => window.location.href = '../../LOGIN/login.html', 3000);
                    document.getElementById('container').style.backgroundColor = 'red';
                    document.getElementsByClass('.cabecalho').style.backgroundColor = 'red';
                } else {
                    exibirMensagem(`Resposta incorreta. Você tem mais ${maxTentativas - tentativas} tentativa(s).`);
                }
            }
        }
    };

    // Envia a pergunta atual e a resposta digitada
    xhr.send(`pergunta=${encodeURIComponent(perguntaAtual)}&resposta=${encodeURIComponent(respostaUsuario)}`);
}

// Função para exibir mensagem de erro ou sucesso
function exibirMensagem(mensagem) {
    document.getElementById('mensagem').innerText = mensagem;
}

// Função para formatar a entrada de CEP ou Data conforme a pergunta
function formatarEntrada(evento) {
    const campoResposta = evento.target;
    let valor = campoResposta.value;
    const pergunta = document.getElementById('container-pergunta').innerText;

    valor = valor.replace(/\D/g, '');  // Remove caracteres não numéricos

    if (pergunta.includes("CEP")) {
        campoResposta.value = formatarCEP(valor);
    } else if (pergunta.includes("data")) {
        campoResposta.value = formatarData(valor);
    }
}

// Adicionar eventos aos elementos do DOM
document.getElementById('formulario-auth').addEventListener('submit', tratarEnvio);
document.getElementById('resposta').addEventListener('input', formatarEntrada);
window.onload = exibirPergunta;

// Controle de fonte para acessibilidade
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
        document.body.style.fontSize = fontSize + 'px';
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
