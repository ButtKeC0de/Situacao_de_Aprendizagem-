const sensores = document.querySelectorAll(".sensor");

sensores.forEach((sensor) => {

    sensor.addEventListener("click", () => {

        const id = sensor.dataset.id;

        window.location.href =
            `sensor_lista.php?id=${encodeURIComponent(id)}`;

    });

});

const pesquisa = document.getElementById("pesquisa");

if (pesquisa) {

    pesquisa.addEventListener("input", () => {

        let valor = pesquisa.value
            .toLowerCase()
            .trim();

        valor = valor.replace(
            /^id\s*:\s*/i,
            ""
        );

        sensores.forEach((sensor) => {

            const id =
                sensor.dataset.id.toLowerCase();

            const texto =
                sensor.textContent.toLowerCase();

            if (
                id.includes(valor) ||
                texto.includes(valor)
            ) {

                sensor.style.display = "";

            } else {

                sensor.style.display = "none";

            }

        });

    });

}