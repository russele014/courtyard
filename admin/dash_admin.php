<?php
// Include database connection
require_once '../database/db_connection.php';

// Function to get all active tenants
function getAllTenants($conn) {
    $sql = "SELECT * FROM admin_db_tbl WHERE archived = 0 ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $tenants = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tenants[] = $row;
        }
    }
    
    return $tenants;
}

// Get tenants for display
$tenants = getAllTenants($conn);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new tenant
    if (isset($_POST['add_tenant'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $isTenant = $conn->real_escape_string($_POST['isTenant']);
        $lotNo = $conn->real_escape_string($_POST['lotNo']);
        $bill = floatval($_POST['bill']);
        $status = $conn->real_escape_string($_POST['status']);
        
        $sql = "INSERT INTO admin_db_tbl (name, is_tenant, lot_no, bill, status) 
                VALUES ('$name', '$isTenant', '$lotNo', $bill, '$status')";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: dash_admin.php?message=added");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Update tenant
    if (isset($_POST['update_tenant'])) {
        $id = intval($_POST['id']);
        $name = $conn->real_escape_string($_POST['updateName']);
        $isTenant = $conn->real_escape_string($_POST['updateIsTenant']);
        $lotNo = $conn->real_escape_string($_POST['updateLotNo']);
        $bill = floatval($_POST['updateBill']);
        $status = $conn->real_escape_string($_POST['updateStatus']);
        
        $sql = "UPDATE admin_db_tbl SET 
                name = '$name',
                is_tenant = '$isTenant',
                lot_no = '$lotNo',
                bill = $bill,
                status = '$status'
                WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: dash_admin.php?message=updated");
            exit();
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Handle tenant archiving
if (isset($_GET['archive'])) {
    $id = intval($_GET['archive']);
    $sql = "UPDATE admin_db_tbl SET archived = 1 WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dash_admin.php?message=archived");
        exit();
    }
}

// Get tenant details for view modal
$tenantDetails = null;
if (isset($_GET['view'])) {
    $id = intval($_GET['view']);
    $sql = "SELECT * FROM admin_db_tbl WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $tenantDetails = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="res/css/dash_admin.css">
    <link rel="stylesheet" href="res/css/dash_navbar.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
  <div class="navbar-left">The Courtyard of Maia Alta</div>
  <ul class="navbar-right">
    <li><a href="../index.php">Home</a></li>
    <li><a href="dash_admin.php">Admin</a></li>
    <li><a href="Gallery.php">Gallery </a></li>
    <li><a href="UserDash.php">SOA</a></li>
    <li><a href="Events.php">Events</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="../login_user.php" class="logout-btn">Login</a></li>
  </ul>
</nav>

<div class="container">
    <h2>Tenant Information</h2>
    <p>Manage and review tenant details, billing, and status actions.</p>
    
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success" id="alertMessage">
            <?php 
                switch($_GET['message']) {
                    case 'added':
                        echo "Tenant added successfully!";
                        break;
                    case 'updated':
                        echo "Tenant updated successfully!";
                        break;
                    case 'archived':
                        echo "Tenant archived successfully!";
                        break;
                }
            ?>
        </div>
        <script>
            // Auto-hide alert after 3 seconds and redirect
            setTimeout(function() {
                var alert = document.getElementById('alertMessage');
                if (alert) {
                    alert.classList.add('fade-out');
                    
                    // Redirect after fade animation completes
                    setTimeout(function() {
                        window.location.href = 'dash_admin.php';
                    }, 1000);
                }
            }, 3000);
        </script>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" id="errorMessage">
            <?php echo $error; ?>
        </div>
        <script>
            // Auto-hide error alert after 3 seconds and redirect
            setTimeout(function() {
                var alert = document.getElementById('errorMessage');
                if (alert) {
                    alert.classList.add('fade-out');
                    
                    // Redirect after fade animation completes
                    setTimeout(function() {
                        window.location.href = 'dash_admin.php';
                    }, 1000);
                }
            }, 3000);
        </script>
    <?php endif; ?>
</div>

<!-- Tables -->        
<div class="header-section">
    <span class="homeowner-title">Homeowner's file</span>
    <button class="add-button" id="addBtn">Add</button>
</div>
        
<table id="tenantsTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Tenant</th>
            <th>Lot No.</th>
            <th>Bill</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tenants as $tenant): ?>
            <tr data-id="<?php echo $tenant['id']; ?>">
                <td><?php echo htmlspecialchars($tenant['name']); ?></td>
                <td><?php echo htmlspecialchars($tenant['is_tenant']); ?></td>
                <td><?php echo htmlspecialchars($tenant['lot_no']); ?></td>
                <td>₱<?php echo number_format($tenant['bill'], 2); ?></td>
                <td>
                    <span class="status-<?php echo strtolower($tenant['status']); ?>">
                        <?php echo htmlspecialchars($tenant['status']); ?>
                    </span>
                </td>
                <td class="action-buttons">
                    <div class="view-btn" onclick="window.location.href='dash_admin.php?view=<?php echo $tenant['id']; ?>'">View</div>
                    <div class="update-btn" onclick="openUpdateModal(<?php echo $tenant['id']; ?>, '<?php echo htmlspecialchars($tenant['name']); ?>', '<?php echo htmlspecialchars($tenant['is_tenant']); ?>', '<?php echo htmlspecialchars($tenant['lot_no']); ?>', '<?php echo $tenant['bill']; ?>', '<?php echo htmlspecialchars($tenant['status']); ?>')">Update</div>
                    <div class="archive-btn" onclick="archiveTenant(<?php echo $tenant['id']; ?>)">Archive</div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add Tenant Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
        <h2>Add New Tenant</h2>
        <form id="addTenantForm" method="post" action="dash_admin.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="isTenant">Tenant:</label>
                <select id="isTenant" name="isTenant" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="lotNo">Lot No.:</label>
                <input type="text" id="lotNo" name="lotNo" required>
            </div>
            <div class="form-group">
                <label for="bill">Bill:</label>
                <input type="number" id="bill" name="bill" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit" name="add_tenant" class="form-submit">Add Tenant</button>
        </form>
    </div>
</div>

<!-- Update Tenant Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('updateModal')">&times;</span>
        <h2>Update Tenant</h2>
        <form id="updateTenantForm" method="post" action="dash_admin.php">
            <input type="hidden" id="updateTenantId" name="id">
            <div class="form-group">
                <label for="updateName">Name:</label>
                <input type="text" id="updateName" name="updateName" required>
            </div>
            <div class="form-group">
                <label for="updateIsTenant">Tenant:</label>
                <select id="updateIsTenant" name="updateIsTenant" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="updateLotNo">Lot No.:</label>
                <input type="text" id="updateLotNo" name="updateLotNo" required>
            </div>
            <div class="form-group">
                <label for="updateBill">Bill:</label>
                <input type="number" id="updateBill" name="updateBill" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="updateStatus">Status:</label>
                <select id="updateStatus" name="updateStatus" required>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit" name="update_tenant" class="form-submit">Update Tenant</button>
        </form>
    </div>
</div>

<!-- View Tenant Modal -->
<div id="viewModal" class="modal view-modal" <?php echo isset($tenantDetails) ? 'style="display: block;"' : ''; ?>>
    <div class="modal-content">
        <span class="close-btn" onclick="window.location.href='dash_admin.php'">&times;</span>
        <h2>Tenant Details</h2>
        <div class="tenant-details" id="tenantDetailsContainer">
            <?php if (isset($tenantDetails)): ?>
                <h3>Tenant Information</h3>
                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($tenantDetails['name']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tenant Status:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($tenantDetails['is_tenant']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Lot Number:</div>
                    <div class="detail-value"><?php echo htmlspecialchars($tenantDetails['lot_no']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Bill Amount:</div>
                    <div class="detail-value">₱<?php echo number_format($tenantDetails['bill'], 2); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Payment Status:</div>
                    <div class="detail-value">
                        <span class="status-<?php echo strtolower($tenantDetails['status']); ?>"><?php echo htmlspecialchars($tenantDetails['status']); ?></span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Created At:</div>
                    <div class="detail-value"><?php echo date('F j, Y g:i A', strtotime($tenantDetails['created_at'])); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Last Updated:</div>
                    <div class="detail-value"><?php echo date('F j, Y g:i A', strtotime($tenantDetails['updated_at'])); ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Event listeners for modal controls
    document.getElementById('addBtn').addEventListener('click', function() {
        document.getElementById('addModal').style.display = 'block';
    });

    // Close modal function
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Close modals when clicking outside of content
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }

    // Open update modal with tenant data
    function openUpdateModal(id, name, isTenant, lotNo, bill, status) {
        document.getElementById('updateTenantId').value = id;
        document.getElementById('updateName').value = name;
        document.getElementById('updateIsTenant').value = isTenant;
        document.getElementById('updateLotNo').value = lotNo;
        document.getElementById('updateBill').value = bill;
        document.getElementById('updateStatus').value = status;
        
        document.getElementById('updateModal').style.display = 'block';
    }

    // Archive tenant
    function archiveTenant(id) {
        if (confirm('Are you sure you want to archive this tenant?')) {
            window.location.href = 'dash_admin.php?archive=' + id;
        }
    }
</script>

</body>
</html>
<?php
// Close the database connection
$conn->close();
?>