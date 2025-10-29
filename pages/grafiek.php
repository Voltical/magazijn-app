<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/magazijn.css">
<title>Grafieken Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  .charts-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    padding: 20px;
  }
  canvas {
    background-color: #f7fdfc;
    border-radius: 8px;
    padding: 10px;
  }
</style>
</head>
<body>

<div class="left-container">
  <div class="sidebar-buttons"> 
    <a href="dash_board.php" class="sidebar-btn">
      <img src="../assets/images/huis.png" class="icon" alt="huis icoon"> Dashboard
    </a>

    <a href="placeholder.php" class="sidebar-btn">
      <img src="../assets/images/monitor.png" class="icon" alt="monitor icoon"> Placeholder
    </a>

    <a href="opslag.php" class="sidebar-btn">
      <img src="../assets/images/doos.png" class="icon" alt="doos icoon"> Opslag
    </a>

    <a href="grafiek.php" class="sidebar-btn active">
      <img src="../assets/images/grafiek.png" class="icon" alt="grafiek icoon"> Grafiek
    </a>
  </div>
</div>

<div class="content">
  <h1>📊 Magazijn Grafieken (Leeg)</h1>

  <div class="charts-container">
    <canvas id="chart1" width="400" height="300"></canvas>
    <canvas id="chart2" width="400" height="300"></canvas>
    <canvas id="chart3" width="400" height="300"></canvas>
    <canvas id="chart4" width="400" height="300"></canvas>
  </div>
</div>

<script>
const chartConfigs = [
  {id: 'chart1', label: 'Aantal producten', yLabel: 'Aantal'},
  {id: 'chart2', label: 'Prijs per product', yLabel: 'Prijs (€)'},
  {id: 'chart3', label: 'Voorraadwaarde', yLabel: 'Waarde (€)'},
  {id: 'chart4', label: 'Verkochte producten', yLabel: 'Aantal'}
];

chartConfigs.forEach(cfg => {
  const ctx = document.getElementById(cfg.id).getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [], // leeg voor nu
      datasets: [{
        label: cfg.label,
        data: [], // nog geen data
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: cfg.yLabel }
        },
        x: {
          title: { display: true, text: 'Product' }
        }
      }
    }
  });
});
</script>

</body>
</html>
