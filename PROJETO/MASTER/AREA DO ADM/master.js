let fontSize = 16; 
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

function atualizarUsuariosLogados() {
    fetch('logado.php')
        .then(response => response.json())
        .then(data => {
            const logadoDiv = document.getElementById('logado');
            logadoDiv.innerHTML = '';

            if (data.length > 0) {
                const tabela = document.createElement('table');
                tabela.innerHTML = `
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Login</th>
                            <th>Expiração</th>
                        </tr>
                    </thead>
                `;

                const corpoTabela = document.createElement('tbody');
                data.forEach(usuario => {
                    const linha = document.createElement('tr');
                    linha.innerHTML = `
                        <td>${usuario.user_name}</td>
                        <td>${usuario.data_login}</td>
                        <td>${usuario.expiracao}</td>
                    `;
                    corpoTabela.appendChild(linha);
                });

                tabela.appendChild(corpoTabela);
                logadoDiv.appendChild(tabela);
            } else {
                logadoDiv.innerHTML = '<p>Nenhum usuário logado no momento.</p>';
            }
        })
        .catch(error => console.error('Erro ao carregar os dados:', error));
}

// Atualizar automaticamente a cada 30 segundos
setInterval(atualizarUsuariosLogados, 30000);
document.addEventListener('DOMContentLoaded', atualizarUsuariosLogados);
