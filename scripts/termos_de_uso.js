document.addEventListener('DOMContentLoaded', function () {
    const btnAceitar = document.getElementById('btnAceitar');

    if (!btnAceitar) {
        return;
    }

    btnAceitar.addEventListener('click', function () {
        localStorage.setItem('termosAceitos', 'true');

        const paginaAnterior = document.referrer;

        if (paginaAnterior) {
            try {
                const urlAnterior = new URL(paginaAnterior);

                if (urlAnterior.origin === window.location.origin) {
                    window.location.href = urlAnterior.href;
                    return;
                }
            } catch (erro) {
                console.error('Não foi possível retornar à página anterior.', erro);
            }
        }

        window.location.href = '../public/cadastro.html';
    });
});