"use strict";

const CHAVE_ROTAS = "railViewRotas";

const formulario = document.getElementById("formRota");
const inputIdTrem = document.getElementById("idTrem");
const inputOrigem = document.getElementById("origem");
const inputDestino = document.getElementById("destino");
const inputPesquisa = document.getElementById("pesquisarRota");
const listaRotas = document.getElementById("listaRotas");
const estadoVazio = document.getElementById("estadoVazio");
const contadorRotas = document.getElementById("contadorRotas");
const mensagemFormulario = document.getElementById("mensagemFormulario");

let rotas = carregarRotas();

function carregarRotas() {
    try {
        const dadosSalvos = localStorage.getItem(CHAVE_ROTAS);
        const dadosConvertidos = dadosSalvos ? JSON.parse(dadosSalvos) : [];

        return Array.isArray(dadosConvertidos) ? dadosConvertidos : [];
    } catch (erro) {
        console.error("Não foi possível carregar as rotas:", erro);
        return [];
    }
}

function salvarRotas() {
    localStorage.setItem(CHAVE_ROTAS, JSON.stringify(rotas));
}

function normalizarTexto(texto) {
    return texto
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase()
        .trim();
}

function escaparHtml(texto) {
    const elemento = document.createElement("div");
    elemento.textContent = texto;
    return elemento.innerHTML;
}

function mostrarMensagem(texto, tipo = "") {
    mensagemFormulario.textContent = texto;
    mensagemFormulario.className = `mensagem ${tipo}`.trim();

    window.clearTimeout(mostrarMensagem.temporizador);

    if (texto) {
        mostrarMensagem.temporizador = window.setTimeout(() => {
            mensagemFormulario.textContent = "";
            mensagemFormulario.className = "mensagem";
        }, 3500);
    }
}

function atualizarContador(quantidadeExibida) {
    const total = rotas.length;

    if (total === 0) {
        contadorRotas.textContent = "Nenhuma rota cadastrada";
        return;
    }

    if (quantidadeExibida !== total) {
        contadorRotas.textContent = `${quantidadeExibida} de ${total} rotas encontradas`;
        return;
    }

    contadorRotas.textContent = total === 1 ? "1 rota cadastrada" : `${total} rotas cadastradas`;
}

function criarElementoRota(rota) {
    const item = document.createElement("article");
    item.className = "rota";
    item.dataset.rotaId = rota.id;

    item.innerHTML = `
        <div class="rota-id">Trem<br>${escaparHtml(rota.idTrem)}</div>
        <div class="rota-trajeto">
            <strong>${escaparHtml(rota.origem)} → ${escaparHtml(rota.destino)}</strong>
            <span>Rota #${escaparHtml(rota.id.slice(-6).toUpperCase())}</span>
        </div>
        <button class="btn-excluir" type="button" aria-label="Excluir rota de ${escaparHtml(rota.origem)} para ${escaparHtml(rota.destino)}" title="Excluir rota">
            <i class="bi bi-trash3-fill" aria-hidden="true"></i>
        </button>
    `;

    return item;
}

function renderizarRotas(filtro = "") {
    const termo = normalizarTexto(filtro);
    const rotasFiltradas = rotas.filter((rota) => {
        const dadosDaRota = normalizarTexto(`${rota.idTrem} ${rota.origem} ${rota.destino}`);
        return dadosDaRota.includes(termo);
    });

    listaRotas.replaceChildren();

    rotasFiltradas.forEach((rota) => {
        listaRotas.appendChild(criarElementoRota(rota));
    });

    const semResultados = rotasFiltradas.length === 0;
    estadoVazio.classList.toggle("oculto", !semResultados);

    const tituloVazio = estadoVazio.querySelector("h3");
    const descricaoVazia = estadoVazio.querySelector("p");

    if (termo && semResultados) {
        tituloVazio.textContent = "Nenhuma rota encontrada";
        descricaoVazia.textContent = "Tente pesquisar outro trem, origem ou destino.";
    } else {
        tituloVazio.textContent = "Nenhuma rota cadastrada";
        descricaoVazia.textContent = "As novas rotas aparecerão aqui.";
    }

    atualizarContador(rotasFiltradas.length);
}

formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();

    const idTrem = inputIdTrem.value.trim();
    const origem = inputOrigem.value.trim();
    const destino = inputDestino.value.trim();

    if (!idTrem || !origem || !destino) {
        mostrarMensagem("Preencha todos os campos.", "erro");
        return;
    }

    if (normalizarTexto(origem) === normalizarTexto(destino)) {
        mostrarMensagem("A origem e o destino precisam ser diferentes.", "erro");
        inputDestino.focus();
        return;
    }

    const novaRota = {
        id: `${Date.now()}-${Math.random().toString(16).slice(2)}`,
        idTrem,
        origem,
        destino
    };

    rotas.unshift(novaRota);
    salvarRotas();
    renderizarRotas(inputPesquisa.value);

    formulario.reset();
    inputIdTrem.focus();
    mostrarMensagem("Rota cadastrada com sucesso!", "sucesso");
});

inputPesquisa.addEventListener("input", () => {
    renderizarRotas(inputPesquisa.value);
});

listaRotas.addEventListener("click", (evento) => {
    const botaoExcluir = evento.target.closest(".btn-excluir");

    if (!botaoExcluir) {
        return;
    }

    const itemRota = botaoExcluir.closest(".rota");
    const rotaSelecionada = rotas.find((rota) => rota.id === itemRota.dataset.rotaId);

    if (!rotaSelecionada) {
        return;
    }

    const deveExcluir = window.confirm(
        `Deseja excluir a rota ${rotaSelecionada.origem} → ${rotaSelecionada.destino}?`
    );

    if (!deveExcluir) {
        return;
    }

    rotas = rotas.filter((rota) => rota.id !== rotaSelecionada.id);
    salvarRotas();
    renderizarRotas(inputPesquisa.value);
    mostrarMensagem("Rota excluída.", "sucesso");
});

renderizarRotas();
