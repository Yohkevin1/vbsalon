var incomePieChart, OutcomePieChart, PieChart

function ChartIncomePrd_Jasa(dataset) {
  if (PieChart) {
      PieChart.destroy();
  }
  var ctx = document.getElementById("Prd_Jasa");
  PieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: ["Produk", "Jasa"],
          datasets: [{
          data: dataset,
          backgroundColor: ['#4e73df', '#1cc88a'],
          hoverBackgroundColor: ['#2e59d9', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
      },
      options: {
          maintainAspectRatio: false,
          tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          },
          legend: {
          display: false
          },
          cutoutPercentage: 80,
      },
  });
}

function IncomePie(dataset)
{
  if (incomePieChart) {
        incomePieChart.destroy();
    }
  var ctx = document.getElementById("incomePie");
  incomePieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Jan", "Feb", "Mar", "April", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
          data: dataset,
          backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#116A7B', '#FFCDA8', '#40128B', '#F6FA70', '#E55807', '#98EECC', '#A459D1', '#99627A'],
          hoverBackgroundColor: ['#0068D8', '#DC1226', '#E8AE00', '#04A82A', '#004F5F', '#FFB985', '#2B0071', '#EAEF35', '#C94C05', '#4AE4A7', '#901DD4', '#9E3060'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
    },
  });
}

function OutcomePie(dataset)
{
  if (OutcomePieChart) {
        OutcomePieChart.destroy();
    }
  var ctx = document.getElementById("outcomePie");
  OutcomePieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Jan", "Feb", "Mar", "April", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
          data: dataset,
          backgroundColor: ['#007bff', '#A459D1' , '#ffc107', '#28a745', '#116A7B', '#FFCDA8', '#40128B', '#F6FA70', '#E55807', '#99627A', '#dc3545', '#98EECC'],
          hoverBackgroundColor: ['#0068D8', '#901DD4' , '#E8AE00', '#04A82A', '#004F5F', '#FFB985', '#2B0071', '#EAEF35', '#C94C05', '#9E3060', '#DC1226',  '#4AE4A7'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 80,
    },
  });
}