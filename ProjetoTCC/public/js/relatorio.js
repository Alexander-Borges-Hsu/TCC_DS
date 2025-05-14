// Chart.js é carregado via CDN, então não há importação aqui.

/**
 * Inicializa o gráfico de Consumo vs Meta.
 * @param {string[]} labels - As etiquetas para o eixo X (datas).
 * @param {number[]} consumoData - Os dados de consumo de CO2.
 * @param {number[]} metaData - Os dados da meta de CO2.
 */
function initConsumoMetaChart(labels, consumoData, metaData) {
    const chartCanvas = document.getElementById("grafico-consumo-meta"); // ID humanizado: grafico-consumo-meta
    if (chartCanvas) {
        if (typeof Chart === "undefined") {
            console.error("Chart.js não foi carregado. Verifique a inclusão do CDN.");
            return;
        }

        // Se os dados não forem passados como argumentos, tenta pegar do dataset (fallback)
        // No entanto, a abordagem atual é passar via window.graficoDadosParaPagina no Blade.
        const finalLabels = labels && labels.length > 0 ? labels : JSON.parse(chartCanvas.dataset.labels || "[]");
        const finalConsumoData = consumoData && consumoData.length > 0 ? consumoData : JSON.parse(chartCanvas.dataset.consumo || "[]");
        const finalMetaData = metaData && metaData.length > 0 ? metaData : JSON.parse(chartCanvas.dataset.meta || "[]");

        try {
            const ctx = chartCanvas.getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: finalLabels,
                    datasets: [
                        {
                            label: "Consumo CO₂ (kg)",
                            data: finalConsumoData,
                            borderColor: "rgb(220, 38, 38)", // Vermelho vivo (Tailwind red-600)
                            backgroundColor: "rgba(220, 38, 38, 0.1)", // Vermelho mais claro para área
                            tension: 0.1,
                            pointBackgroundColor: "rgb(220, 38, 38)",
                            pointBorderColor: "#fff",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgb(220, 38, 38)"
                        },
                        {
                            label: "Meta CO₂ (kg)",
                            data: finalMetaData,
                            borderColor: "rgb(22, 163, 74)", // Verde escuro (Tailwind green-600)
                            backgroundColor: "rgba(22, 163, 74, 0.1)", // Verde mais claro para área
                            borderDash: [5, 5],
                            tension: 0.1,
                            pointBackgroundColor: "rgb(22, 163, 74)",
                            pointBorderColor: "#fff",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgb(22, 163, 74)"
                        }
                    ]
                },
                options: {
                    responsive: true, // O gráfico se ajustará ao tamanho do contêiner
                    maintainAspectRatio: false, // Permite que a altura definida no contêiner seja respeitada
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "rgba(0, 0, 0, 0.1)" // Linhas de grade mais claras para tema claro
                            },
                            ticks: {
                                color: "#1f2937" // Cor do texto dos ticks (Tailwind gray-800)
                            }
                        },
                        x: {
                            grid: {
                                display: false // Remove linhas de grade do eixo X para um visual mais limpo
                            },
                            ticks: {
                                color: "#1f2937" // Cor do texto dos ticks
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: "#1f2937" // Cor do texto da legenda
                            }
                        }
                    }
                }
            });
        } catch (e) {
            console.error("Erro ao inicializar ou renderizar o gráfico:", e);
        }
    }
}

function imprimirRelatorio() {
    document.body.classList.add("print-mode");
    window.print();
    // Adiciona um pequeno atraso para remover a classe após a impressão ser provavelmente concluída ou cancelada.
    // Isso ajuda a restaurar os estilos normais da página.
    setTimeout(() => { document.body.classList.remove("print-mode"); }, 500);
}

// Torna as funções globalmente acessíveis para serem chamadas pelo HTML (onclick) ou por outros scripts.
window.solicitarImpressaoDoRelatorio = imprimirRelatorio; // Nome humanizado usado no Blade
window.inicializarGraficoConsumoVsMeta = initConsumoMetaChart; // Nome humanizado usado no Blade

// A inicialização do gráfico agora é chamada pelo script inline no arquivo Blade,
// que passa os dados diretamente para window.inicializarGraficoConsumoVsMeta.
// O script no Blade que faz a chamada:
// document.addEventListener("DOMContentLoaded", function() {
//     if (window.graficoDadosParaPagina) {
//         window.inicializarGraficoConsumoVsMeta(
//             window.graficoDadosParaPagina.rotulos,
//             window.graficoDadosParaPagina.consumo,
//             window.graficoDadosParaPagina.meta
//         );
//     } else {
//         console.warn("Dados do gráfico (window.graficoDadosParaPagina) não encontrados.");
//     }
// });

