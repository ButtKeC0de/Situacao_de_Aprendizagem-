
const temperatura = document.getElementById("clima-temperatura");
const condicao = document.getElementById("clima-condicao");
const icone = document.getElementById("clima-icone");
const atualizacao = document.getElementById("clima-atualizacao");

async function carregarClima() {
    atualizacao.textContent = "Consultando a API...";

    try {
        const url =
            "https://api.open-meteo.com/v1/forecast" +
            "?latitude=-26.3044" +
            "&longitude=-48.8487" +
            "&current=temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,wind_speed_10m" +
            "&timezone=America%2FSao_Paulo";

        const resposta = await fetch(url);

        if (!resposta.ok) {
            throw new Error("Falha na consulta meteorológica");
        }

        const dados = await resposta.json();
        const clima = dados.current;

        const descricoes = {
            0: ["Céu limpo", "☀️"],
            1: ["Predominantemente limpo", "🌤️"],
            2: ["Parcialmente nublado", "⛅"],
            3: ["Nublado", "☁️"],
            45: ["Neblina", "🌫️"],
            48: ["Neblina com geada", "🌫️"],
            51: ["Garoa leve", "🌦️"],
            53: ["Garoa moderada", "🌦️"],
            55: ["Garoa intensa", "🌧️"],
            61: ["Chuva leve", "🌧️"],
            63: ["Chuva moderada", "🌧️"],
            65: ["Chuva intensa", "🌧️"],
            80: ["Pancadas de chuva", "🌦️"],
            81: ["Pancadas moderadas", "🌧️"],
            82: ["Pancadas intensas", "⛈️"],
            95: ["Trovoadas", "⛈️"],
            96: ["Trovoadas com granizo", "⛈️"],
            99: ["Trovoadas intensas com granizo", "⛈️"]
        };

        const resultado = descricoes[clima.weather_code]
            || ["Condição não identificada", "🌡️"];

        temperatura.textContent =
            `${Math.round(clima.temperature_2m)} °C`;

        condicao.textContent = resultado[0];
        icone.textContent = resultado[1];

        const data = new Date(clima.time);

        atualizacao.textContent =
            `Observação: ${data.toLocaleString("pt-BR")}`;

    } catch (erro) {
        console.error("Erro ao consultar clima:", erro);

        condicao.textContent = "Clima indisponível";
        atualizacao.textContent =
            "Não foi possível consultar os dados. Tente novamente.";
    }
}

carregarClima();
