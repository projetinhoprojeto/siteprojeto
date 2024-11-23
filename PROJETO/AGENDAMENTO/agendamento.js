function mostrarCampoOutroAnimal() {
    const tipoPet = document.getElementById("tipoPet").value;
    const outroAnimalContainer = document.getElementById("outroAnimalContainer");
    const outroAnimalInput = document.getElementById("outroAnimal");

    if (tipoPet === "outro") {
        outroAnimalContainer.style.display = "block"; 
        outroAnimalInput.setAttribute('required', 'required'); 
    } else {
        outroAnimalContainer.style.display = "none";
        outroAnimalInput.removeAttribute('required'); 
        outroAnimalInput.value = ""; 
    }
}

function mostrarOpcoes() {
    const exame = document.getElementById("exame").value;
    const subtiposContainer = document.getElementById("subtiposContainer");
    const subtipoExameSelect = document.getElementById("subtipoExame");
    const horariosContainer = document.getElementById("horariosContainer");
    const horarioSelect = document.getElementById("horario");

    if (exame) {
        subtiposContainer.style.display = "block";
        let subtipos = [];

        if (exame === "vacinação") {
            subtipos = ["Vacina Raiva (R$ 70,00)", "Vacina V8 (R$ 100,00)", "Vacina V10 (R$ 120,00)", "Vacina Antirrábica (R$ 70,00)", "Vacina Gripe Canina (R$ 90,00)", "Vacina Leptospirose (R$ 100,00)", "Vacina Giárdia (R$ 80,00)"];
        } else if (exame === "consulta") {
            subtipos = ["Consulta Rotina (R$ 100,00)", "Consulta Especialista (R$ 200,00)", "Retorno (R$ 100,00)", "Consulta Dermatológica (R$ 200,00)", "Consulta Cardiológica (R$ 200,00)"];
        } else if (exame === "cirurgia") {
            subtipos = ["Castrar (R$ 200,00)", "Remoção de Tumor (R$ 600,00)", "Cirurgia Ortopédica (R$ 1000,00)", "Cirurgia de Catarata (R$ 1000,00)", "Cirurgia Abdominal (R$ 800,00)"];
        } else if (exame === "exame") {
            subtipos = ["Ultrassom (R$ 200,00)", "Raio-X (R$ 150,00)", "Exame de Sangue (R$ 100,00)", "Eletrocardiograma (R$ 200,00)", "Exame de Urina (R$ 80,00)", "Tomografia (R$ 800,00)"];
        }


        subtipoExameSelect.innerHTML = '<option value="">Selecione uma opção</option>';
        subtipos.forEach(subtipo => {
            const option = document.createElement("option");
            option.value = subtipo;
            option.textContent = subtipo;
            subtipoExameSelect.appendChild(option);
        });

    
        mostrarHorarios(exame);
    } else {
        subtiposContainer.style.display = "none";
        horariosContainer.style.display = "none";
    }
}

function mostrarHorarios(exame) {
    const horariosContainer = document.getElementById("horariosContainer");
    const horarioSelect = document.getElementById("horario");

    if (exame) {
        horariosContainer.style.display = "block";
        let horarios = [];

    
        if (exame === "consulta") {
            horarios = ["08:00", "09:00", "10:00", "11:00"];
        } else if (exame === "vacinação") {
            horarios = ["13:00", "14:00", "15:00"];
        } else if (exame === "cirurgia") {
            horarios = ["08:00", "12:00", "16:00"];
        } else if (exame === "exame") {
            horarios = ["09:00", "11:00", "13:00", "15:00"];
        }

    
        horarioSelect.innerHTML = '<option value="">Selecione um horário</option>';
        horarios.forEach(horario => {
            const option = document.createElement("option");
            option.value = horario;
            option.textContent = horario;
            horarioSelect.appendChild(option);
        });
    } else {
        horariosContainer.style.display = "none";
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const telefoneInput = document.getElementById('telefone');
    const telefoneErro = document.getElementById('telefoneErro');
    
    telefoneInput.addEventListener('input', function(event) {
        let telefone = event.target.value.replace(/\D/g, '');

        // Aplica a máscara automática para (XX) XXXXX-XXXX
        if (telefone.length > 11) telefone = telefone.slice(0, 11); // Limita a 11 dígitos
        telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        
        event.target.value = telefone;
    });

    document.getElementById('formTelefone').addEventListener('submit', function(event) {
        event.preventDefault();
        const telefone = telefoneInput.value.replace(/\D/g, ''); // Remove tudo que não for número

        if (telefone.length == 11) {
            telefoneErro.style.display = 'none';
            
        } else {
            telefoneErro.style.display = 'block';
        }
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

document.getElementById("dataAgendamento").min = new Date().toISOString().split("T")[0];
