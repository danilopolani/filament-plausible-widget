(function () {
    let initialized = false;
    let plausibleWidget;

    const init = () => {
        plausibleWidget = document.getElementById('plausible-widget-chart');

        if (!plausibleWidget) {
            return;
        }

        const Chart = require('chart.js');
        const ctx = plausibleWidget.getContext('2d');

        const bgColor = ctx.createLinearGradient(0, 0, 0, 300);
        bgColor.addColorStop(0, 'rgba(101, 116, 205, .2)');
        bgColor.addColorStop(1, 'rgba(101, 116, 205, 0)');

        window.plausibleChart = new Chart(plausibleWidget.getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    borderWidth: 3,
                    borderColor: 'rgb(101, 116, 205)',
                    pointBackgroundColor: 'rgb(101, 116, 205)',
                    backgroundColor: bgColor,
                    data: [],
                    label: 'Views',
                    fill: 'start',
                }]
            },
            options: {
                animation: false,
                legend: {
                    display: false,
                },
                responsive: true,
                maintainAspectRatio: false,
                elements: {
                    line: {
                        tension: 0,
                    },
                    point: {
                        radius: 0,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            autoSkip: true,
                            maxTicksLimit: 8,
                        },
                        gridLines: {
                            zeroLineColor: "transparent",
                            drawBorder: false,
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 8,
                        }
                    }]
                }
            }
        });
    };

    // Listen for updates from Livewire
    Livewire.on('plausibleWidgetUpdated', (timeseries) => {
        if (!initialized) {
            initialized = true;
            init();
        }

        window.plausibleChart.data.labels = timeseries.labels;
        window.plausibleChart.data.datasets[0].data = timeseries.data;
        window.plausibleChart.update();
    });
})();
