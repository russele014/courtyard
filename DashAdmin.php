<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dash.css">
</head>
<body>
<nav class="navbar">
  <div class="navbar-left">The Courtyard of Maia Alta</div>
  <ul class="navbar-right">
    <li><a href="index.php">Home</a></li>
    <li><a href="DashAdmin.php">Admin</a></li>
    <li><a href="Gallery.php">Gallery </a></li>
    <li><a href="UserDash.php">SOA</a></li>
    <li><a href="Events.php">Events</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Login.php" class="logout-btn">Login</a></li>
  </ul>
</nav>

<div class="container">
  <h2>Tenant Information</h2>
  <p>Manage and review tenant details, billing, and status actions.</p>
</div>
<!-- Tables -->
<!-- Tables -->

        
        <div class="header-section">
            <span class="homeowner-title">Homeowner's file</span>
            <button class="add-button">Add</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Tenant</t>
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

</body>
</html>