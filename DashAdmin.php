<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="navbar.css"/>
  <link rel="stylesheet" href="dash.css"/>
  <style>
    .dashboard-section {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      margin: 30px auto;
      gap: 30px;
      max-width: 90%;
      flex-wrap: wrap;
    }

    .chart-container {
      flex: 1;
      min-width: 300px;
    }

    .report-form {
      flex: 1;
      min-width: 280px;
      background-color: #f7f7f7;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .report-form h3 {
      margin-bottom: 20px;
    }

    .report-form p {
      margin: 10px 0;
    }

    #downloadBtn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007e33;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #downloadBtn:hover {
      background-color: #005e26;
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <div class="navbar-left">The Courtyard of Maia Alta</div>
    <ul class="navbar-right">
      <li><a href="index.php">Home</a></li>
      <li><a href="DashAdmin.php">Admin</a></li>
      <li><a href="Gallery.php">Gallery</a></li>
      <li><a href="UserDash.php">SOA</a></li>
      <li><a href="Events.php">Events</a></li>
      <li><a href="News.php">News</a></li>
      <li><a href="Login.php" class="logout-btn">Login</a></li>
    </ul>
  </nav>

  <!-- Two-column Section -->
  <div class="dashboard-section">
    <!-- Line Chart -->
    <div class="chart-container">
      <canvas id="lineChart" width="600" height="300"></canvas>
    </div>

    <!-- Report Form -->
    <div class="report-form">
      <h3>Monthly Report</h3>
      <p><strong>Total Collected:</strong> $<span id="totalCollected">0</span></p>
      <p><strong>Total Unpaid:</strong> $<span id="totalUnpaid">0</span></p>
      <p><strong>Paid Homeowners:</strong> <span id="paidCount">0</span></p>
      <p><strong>Unpaid Homeowners:</strong> <span id="unpaidCount">0</span></p>
      <button id="downloadBtn">Download as PDF</button>
    </div>
  </div>


  <div class="container">
    <h2>Tenant Information</h2>
    <p>Manage and review tenant details, billing, and status actions.</p>
  </div>

  <div class="header-section">
    <span class="homeowner-title">Homeowner's file</span>
    <button class="add-button">Add</button>
  </div>

  <table id="tenantTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Tenant</th>
        <th>Lot No.</th>
        <th>Bill</th>
        <th>Status<br>(paid/unpaid)</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John Doe</td>
        <td>Yes</td>
        <td>A-123</td>
        <td>$150</td>
        <td>Paid</td>
        <td class="action-buttons">
          <div class="update-btn">Update</div>
          <div class="archive-btn">Archive</div>
        </td>
      </tr>
      <tr>    
        <td>Jane Smith</td>
        <td>No</td>
        <td>B-456</td>
        <td>$200</td>
        <td>Unpaid</td>
        <td class="action-buttons">
          <div class="update-btn">Update</div>
          <div class="archive-btn">Archive</div>
        </td>
      </tr>
      <tr>
        <td>Bob Johnson</td>
        <td>Yes</td>
        <td>C-789</td>
        <td>$175</td>
        <td>Paid</td>
        <td class="action-buttons">
          <div class="update-btn">Update</div>
          <div class="archive-btn">Archive</div>
        </td>
      </tr>
      <tr>
        <td>Sarah Williams</td>
        <td>No</td>
        <td>D-012</td>
        <td>$225</td>
        <td>Unpaid</td>
        <td class="action-buttons">
          <div class="update-btn">Update</div>
          <div class="archive-btn">Archive</div>
        </td>
      </tr>
      <tr>
        <td>Mike Brown</td>
        <td>Yes</td>
        <td>E-345</td>
        <td>$190</td>
        <td>Paid</td>
        <td class="action-buttons">
          <div class="update-btn">Update</div>
          <div class="archive-btn">Archive</div>
        </td>
      </tr>
    </tbody>
  </table>

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    // Chart Data
    const ctx = document.getElementById('lineChart').getContext('2d');
    const months = ["January", "February", "March", "April", "May", "June"];
    const billAmounts = [500, 700, 620, 550, 720, 680]; // Replace with real data if needed

    const lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: months,
        datasets: [{
          label: 'Monthly Bills Collected ($)',
          data: billAmounts,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Dummy Tenant Data
    const tenants = [
      { name: "John Doe", bill: 150, paid: true },
      { name: "Jane Smith", bill: 200, paid: false },
      { name: "Bob Johnson", bill: 175, paid: true },
      { name: "Sarah Williams", bill: 225, paid: false },
      { name: "Mike Brown", bill: 190, paid: true }
    ];

    let totalCollected = 0, totalUnpaid = 0, paidCount = 0, unpaidCount = 0;

    tenants.forEach(t => {
      if (t.paid) {
        totalCollected += t.bill;
        paidCount++;
      } else {
        totalUnpaid += t.bill;
        unpaidCount++;
      }
    });

    document.getElementById("totalCollected").innerText = totalCollected;
    document.getElementById("totalUnpaid").innerText = totalUnpaid;
    document.getElementById("paidCount").innerText = paidCount;
    document.getElementById("unpaidCount").innerText = unpaidCount;

    // PDF Download
    document.getElementById("downloadBtn").addEventListener("click", () => {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.text("Monthly Report", 20, 20);

      doc.setFontSize(12);
      doc.text(`Total Collected: $${totalCollected}`, 20, 40);
      doc.text(`Total Unpaid: $${totalUnpaid}`, 20, 50);
      doc.text(`Paid Homeowners: ${paidCount}`, 20, 60);
      doc.text(`Unpaid Homeowners: ${unpaidCount}`, 20, 70);

      doc.save("monthly_report.pdf");
    });
  </script>

</body>
</html>
