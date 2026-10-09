document.addEventListener('DOMContentLoaded', function () {
    const formCadastro = document.getElementById('formCadastro');
    const textLog = document.getElementById('text_log');

    if (formCadastro) {
        formCadastro.addEventListener('submit', function (event) {
            event.preventDefault();

            if (localStorage.getItem('termosAceitos') !== 'true') {
                alert('Você precisa aceitar os Termos de Uso antes de se cadastrar.');
                window.location.href = '../public/termos.html';
                return;
            }

            const email = document.getElementById('emailCadastro').value.trim();
            const senha = document.getElementById('senhaCadastro').value;
            const confirmaSenha = document.getElementById('confirmaSenha').value;

            const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailValido.test(email)) {
                alert('Digite um e-mail válido!');
                return;
            }

            if (senha.length < 6) {
                alert('A senha deve ter no mínimo 6 caracteres!');
                return;
            }

            if (senha !== confirmaSenha) {
                alert('As senhas não coincidem!');
                return;
            }

            let usuariosCadastrados = [];

            try {
                usuariosCadastrados = JSON.parse(
                    localStorage.getItem('usuarios')
                ) || [];

                if (!Array.isArray(usuariosCadastrados)) {
                    usuariosCadastrados = [];
                }
            } catch (erro) {
                alert('Não foi possível consultar os usuários cadastrados.');
                return;
            }

            const usuarioExiste = usuariosCadastrados.some(function (usuario) {
                return usuario.email.toLowerCase() === email.toLowerCase();
            });

            if (usuarioExiste) {
                alert('Este e-mail já está cadastrado!');
                return;
            }

            usuariosCadastrados.push({
                email: email,
                senha: senha
            });

            localStorage.setItem(
                'usuarios',
                JSON.stringify(usuariosCadastrados)
            );

            alert('Cadastro realizado com sucesso!');

            window.location.href = 'login.php';
        });
    }

    if (textLog) {
        textLog.addEventListener('click', function () {
            window.location.href = 'login.php';
        });
    }
});