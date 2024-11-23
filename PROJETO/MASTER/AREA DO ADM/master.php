<?php

session_start();

// Verifica se o usuário está logado e é master
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'master') {
    // Redireciona para a página 404 se o usuário não for master
    header("Location: ../../ERRO 404/erro.html?NAO-AUTORIZADO");
    exit();
}

$fotoPerfil = $_SESSION['fotoperfil'];
$foto = '../../CADASTRO/' . $fotoPerfil;
$fotoPerfil = $fotoPerfil ? $fotoPerfil : '/path/to/default_avatar.png';
$date = date('Y-m-d H:i:s');


?>





<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Área do administrador</title>
    <link rel="stylesheet" href="master-atualizado.css">
    
</head>
<body>
<header class="cabecalho">
        <div class="logo">
            <img src="<?php echo htmlspecialchars($foto); ?>" alt="Perfil" height= "20">
        </div>

        <a href="../..//SITE COMPLETO/index.php">VOLTAR PARA O HOME</a>

        <div class="acessibilidade">
            <button id="botao-tema"><i class="bi bi-brightness-high"></i></button>
            <button id="aumentar-fonte">A+</button>
            <button id="diminuir-fonte">A-</button>
        </div>
        
        <form action="sair.php">
           <button class="sair" type="submit">Sair</button>
        </form>
</header>

    <div class="titulo"> 
        <h1>Área do Administrador</h1> 
    </div>



     <!--<header class="cabecalho">
        <div class="logo">
            <img src="logoborda.jpg" alt="Logo PetZone" height= "50" width = "50">
        </div>
        <nav class="menu">
            <ul>
                <li><a href="../index.html" class="home"></a></li>
            </ul>
        </nav>
        
        <div class="acessibilidade">
            <button id="botao-tema">Alterar Tema</button>
            <button id="aumentar-fonte">A+</button>
            <button id="diminuir-fonte">A-</button>
        </div>
    </header>-->
    
    

    <div class='pesquisa'>
        <label for="search">Pesquisar Usuário:</label>
        <input type="text" id="search" oninput="pesquisarUsuario()" placeholder="Digite parte do nome do usuário">
    </div>

    <ul id="lista-usuarios">
        <!-- Lista de usuários será gerada dinamicamente -->
    </ul>
    
    <section id="logado">
        <!-- apsrecerá dinamicaent via a javscripyit -->
    </section>

    <button onclick="baixarPDF()" class="baixar"> <i class="bi bi-download"></i>  Baixar Lista de Usuários em PDF</button>


    <footer>
       <p class='copy'> PetZone &copy 2024 e todos os direitos reservados </p>
    </footer>

  <!-- Modal para editar usuário -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Editar Usuário</h3>
            <button class="close-btn" onclick="fecharModal()">X</button>
        </div>
        
        <div class="modal-body">
        <!-- Nome e Email (já existentes) -->
        <label for="modal-nome">Nome:</label>
        <input type="text" id="modal-nome">
        
        <label for="modal-email">Email:</label>
        <input type="text" id="modal-email">

        <!-- Novos campos -->
        <label for="modal-cpf">CPF:</label>
        <input type="text" id="modal-cpf" placeholder="000.000.000-00">

        <label for="modal-cep">CEP:</label>
        <input type="text" id="modal-cep" placeholder="00000-000">

        <label for="modal-data-nascimento">Data de Nascimento:</label>
        <input type="date" id="modal-data-nascimento">

        <label for="modal-genero">Gênero:</label>
        <select id="modal-genero">
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outro</option>
        </select>

        <label for="modal-nome-materno">Nome Materno:</label>
        <input type="text" id="modal-nome-materno">

        <label for="modal-telefone-celular">Telefone Celular:</label>
        <input type="text" id="modal-telefone-celular" placeholder="(00) 00000-0000">

        <label for="modal-telefone-fixo">Telefone Fixo:</label>
        <input type="text" id="modal-telefone-fixo" placeholder="(00) 0000-0000">

        <input type="hidden" id="modal-id">
        
        </div>

        <div class="modal-footer">
           <button onclick="salvarEdicao()">Salvar</button>
           <button onclick="fecharModal()">Cancelar</button>
        </div>
    </div>
</div>


    <script>

document.addEventListener("DOMContentLoaded", function() {
    // Fazer uma requisição para o PHP para verificar o login
    fetch('verifica_login.php')
    .then(response => response.json())
    .then(data => {
        const userInfoDiv = document.getElementById("user-info");
        const loginUsuarioDiv = document.querySelector('.login-usuario');
        
        if (data.logado) {
            // Se o usuário estiver logado, mostra a imagem de perfil e as informações
            loginUsuarioDiv.innerHTML = `
                <img class='img-logado' src='../CADASTRO/CADASTRO/${data.fotoperfil}' alt='Imagem de perfil do usuário' height='300'>
                <div id="user-info">
                    <p>Bem-vindo, </p>
                    <p><span>${data.nome}</span>!</p>
                    <a href="perfil.php"><p>Ver Perfil..</p></a>
                    <form action="backend-sitecompleto/logout.php" method="POST">
                        <button type="submit">Sair</button>
                    </form>
                </div>
            `;
        } else {
            // Se o usuário não estiver logado, exibe o login e cadastro
            loginUsuarioDiv.innerHTML = `
                <img src='IMAGENS/login.jpg' alt='Logo PetZone' title='Logo usuario deslogado!'>
                <div id="user-info">
                    <p class="bn-v">Bem-vindo, Visitante!</p>
                    <button><a href="login.html">Faça login</button> <p>ou</p> <button><a href="cadastro.html">Cadastre-se</a></button>
                </div>
            `;
        }
    });
});


        // Função para pesquisar os usuários (usando AJAX)
function pesquisarUsuario() {
    const termo = document.getElementById("search").value;

    // Faz a requisição AJAX para o PHP
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "pesquisar_usuario.php?termo=" + termo, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Recebe a resposta do PHP e atualiza a lista de usuários
            document.getElementById("lista-usuarios").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Função que verifica se há atualizações no banco de dados a cada 10 segundos
function iniciarAtualizacaoAutomatica() {
    setInterval(function() {
        pesquisarUsuario(); // Atualiza a lista de usuários
    }, 1000); // 10 segundos
}

// Exibe todos os usuários quando a página carregar
window.onload = function() {
    pesquisarUsuario(); // Carrega a lista de usuários inicialmente
    iniciarAtualizacaoAutomatica(); // Inicia a verificação automática
};


        // Exibe todos os usuários quando a página carregar
        window.onload = function() {
            pesquisarUsuario(); // Faz a pesquisa sem termo para carregar todos
        };

        // Função para fechar o modal
        function fecharModal() {
            document.getElementById("modal").style.display = "none";
        }


        // Função para abrir o modal de edição
function abrirModal(id, nome, email, cpf, cep, dataNascimento, genero, nomeMaterno, celular, fixo) {
    document.getElementById("modal-id").value = id;
    document.getElementById("modal-nome").value = nome;
    document.getElementById("modal-email").value = email;
    document.getElementById("modal-cpf").value = cpf;
    document.getElementById("modal-cep").value = cep;
    document.getElementById("modal-data-nascimento").value = dataNascimento;
    document.getElementById("modal-genero").value = genero;
    document.getElementById("modal-nome-materno").value = nomeMaterno;
    document.getElementById("modal-telefone-celular").value = celular;
    document.getElementById("modal-telefone-fixo").value = fixo;

    document.getElementById("modal").style.display = "flex";
}

// Função para salvar a edição e enviar os dados ao PHP
function salvarEdicao() {
    const id = document.getElementById("modal-id").value;
    const nome = document.getElementById("modal-nome").value;
    const email = document.getElementById("modal-email").value;
    const cpf = document.getElementById("modal-cpf").value;
    const cep = document.getElementById("modal-cep").value;
    const dataNascimento = document.getElementById("modal-data-nascimento").value;
    const genero = document.getElementById("modal-genero").value;
    const nomeMaterno = document.getElementById("modal-nome-materno").value;
    const celular = document.getElementById("modal-telefone-celular").value;
    const fixo = document.getElementById("modal-telefone-fixo").value;

    // Faz a requisição AJAX para salvar as alterações no banco de dados
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "editar_usuario.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Usuário atualizado com sucesso!");
            fecharModal();
            pesquisarUsuario(); // Atualiza a lista de usuários após a edição
        }
    };
    xhr.send(`id=${id}&nome=${nome}&email=${email}&cpf=${cpf}&cep=${cep}&dataNascimento=${dataNascimento}&genero=${genero}&nomeMaterno=${nomeMaterno}&celular=${celular}&fixo=${fixo}`);
}


        // Função para excluir usuário
        function excluirUsuario(id) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "excluir_usuario.php?id=" + id, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        pesquisarUsuario(); // Atualiza a lista após exclusão
                    }
                };
                xhr.send();
            }
        }

        function baixarPDF() {
            window.location.href = "gerar_pdf_dompdf.php";
        }

        function alterarPerfil(userId, novoPerfil) {
        fetch('alterar_perfil.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${userId}&perfil=${novoPerfil}`
        })
        .then(response => response.text())
        .then(data => {
        alert(data); // Alerta de confirmação
    })
    .catch(error => console.error('Erro ao atualizar perfil no servidor BD'));
}

    </script>
    <script src="master.js"></script>
</body>
</html>
