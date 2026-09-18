document.getElementById('formLogin').addEventListener('submit', function(event) {

    event.preventDefault();

    const emailDigitado = document.getElementById('email').value.trim();
    const senhaDigitada = document.getElementById('senha').value;

    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailValido.test(emailDigitado)) {
        alert("Digite um email válido!");
        return;
    }

    const usuariosCadastrados = JSON.parse(localStorage.getItem('usuarios')) || [];

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