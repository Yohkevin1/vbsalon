var ChartLine

function LineChart(dataPJL, dataPBL) {
    if (ChartLine) {
        ChartLine.destroy();
    }
    var ctx = document.getElementById("LinePBLvsPJL");
    ChartLine = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Penjualan",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05",
                borderColor: "rgba(78, 115, 223, 1",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1",
                pointBorderColor: "rgba(78, 115, 223, 1",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1",
                pointHoverBorderColor: "rgba(78, 115, 223, 1",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: dataPJL,
            },
            {
                label: "Pembelian",
                lineTension: 0.3,
                backgroundColor: "rgba(28, 200, 138, 0.05",
                borderColor: "rgba(28, 200, 138, 1",
                pointRadius: 3,
                pointBackgroundColor: "rgba(28, 200, 138, 1",
                pointBorderColor: "rgba(28, 200, 138, 1",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(28, 200, 138, 1",
                pointHoverBorderColor: "rgba(28, 200, 138, 1",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: dataPBL,
            }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 0,
              bottom: 0
            }
          },
          scales: {
              x: {
                beginAtZero: true,
                gridLines: {
                    display: false,
                    drawBorder: false,
                },
                maxTicksLimit: 7,
              },
              y: {
                beginAtZero: true,
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2],
                },
                maxTicksLimit: 5,
                padding: 10,
            },
          },
          legend: {
              display: false
          },
        }
    });
}
