const checkboxTermos = document.getElementById('termos');
const linkTermos = document.getElementById('linkTermos');

let termosLidos = false;

linkTermos.addEventListener('click', function () {

    termosLidos = true;

    checkboxTermos.disabled = false;

    alert("Após ler os Termos de Uso, marque a caixa para continuar.");
});


document.getElementById('formLogin').addEventListener('submit', function(event) {

    event.preventDefault();

    const emailDigitado = document.getElementById('email').value.trim();
    const senhaDigitada = document.getElementById('senha').value;

    const termosAceitos = checkboxTermos.checked;

    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    if (!emailValido.test(emailDigitado)) {

        alert("Digite um email válido!");
        return;

    }


    if (!termosLidos) {

        alert("Você precisa ler os Termos de Uso antes de continuar.");
        return;

    }


    if (!termosAceitos) {

        alert("Você precisa aceitar os Termos de Uso para continuar.");
        return;

    }


    const usuariosCadastrados =
        JSON.parse(localStorage.getItem('usuarios')) || [];


    const usuarioValido = usuariosCadastrados.find(usuario =>

        usuario.email === emailDigitado &&
        usuario.senha === senhaDigitada

    );


    if (usuarioValido) {

        alert("Bem-vindo de volta! Login realizado com sucesso.");

        window.location.href = "../public/home.html";

    } else {

        alert("Email ou senha incorretos. Verifique os dados ou cadastre-se.");

    }

});


document.getElementById('text_log').addEventListener('click', function() {

    window.location.href = "../public/cadastro.html";

});