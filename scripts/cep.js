
const campoCEP = document.getElementById("cep");
const mensagemCEP = document.getElementById("mensagem-cep");

async function buscarCEP() {
    const cep = campoCEP.value.replace(/\D/g, "");

    if (cep === "") {
        mensagemCEP.textContent = "";
        return;
    }

    if (!/^\d{8}$/.test(cep)) {
        mensagemCEP.textContent = "Digite um CEP com 8 números.";
        return;
    }

    mensagemCEP.textContent = "Consultando CEP...";

    try {
        const resposta = await fetch(
            `https://viacep.com.br/ws/${cep}/json/`
        );

        if (!resposta.ok) {
            throw new Error("Falha na consulta do CEP.");
        }

        const dados = await resposta.json();

        if (dados.erro) {
            mensagemCEP.textContent = "CEP não encontrado.";
            limparEndereco();
            return;
        }

        document.getElementById("logradouro").value =
            dados.logradouro || "";

        document.getElementById("bairro").value =
            dados.bairro || "";

        document.getElementById("cidade").value =
            dados.localidade || "";

        document.getElementById("uf").value =
            dados.uf || "";

        mensagemCEP.textContent = "Endereço preenchido com sucesso.";
    } catch (erro) {
        console.error("Erro ao consultar CEP:", erro);
        mensagemCEP.textContent =
            "Não foi possível consultar o CEP. Tente novamente.";
    }
}

function limparEndereco() {
    document.getElementById("logradouro").value = "";
    document.getElementById("bairro").value = "";
    document.getElementById("cidade").value = "";
    document.getElementById("uf").value = "";
}

if (campoCEP) {
    campoCEP.addEventListener("blur", buscarCEP);
}
