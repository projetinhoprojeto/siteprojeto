 // Alternar entre os temas claro e escuro
 document.getElementById('botao-tema').addEventListener('click', function() {
    document.body.classList.toggle('tema-escuro');
});

let tema = document.getElementById('botao-tema');

// Função para aplicar o tema com base no localStorage
function aplicarTema() {
    if (localStorage.getItem('tema') === 'escuro') {
        document.body.classList.add('tema-escuro');
        tema.innerHTML = '<i class="bi bi-brightness-high"></i>';
    } else {
        document.body.classList.remove('tema-escuro');
        tema.innerHTML = '<i class="bi bi-moon-stars"></i>';
    }
}
aplicarTema()

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