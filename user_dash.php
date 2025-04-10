<?php
// Include the database connection file
include 'database/db_connection.php';

// Function to get home owner data
function getHomeOwnerData($conn, $homeOwnerId = 1) {
    $sql = "SELECT name, lot_no, bill FROM admin_db_tbl WHERE id = ? AND archived = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $homeOwnerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $homeOwnerData = $result->fetch_assoc();
        $stmt->close();
        return $homeOwnerData;
    } else {
        $stmt->close();
        return null;
    }
}

// Function to get user account records
function getUserAccountRecords($conn, $userId) {
    $sql = "SELECT * FROM user_db_tbl WHERE user_id = ? ORDER BY FIELD(month, 'Arr/Billed'), 
            CASE 
                WHEN month LIKE 'Jan%' THEN 1
                WHEN month LIKE 'Feb%' THEN 2
                WHEN month LIKE 'Mar%' THEN 3
                WHEN month LIKE 'Apr%' THEN 4
                WHEN month LIKE 'May%' THEN 5
                WHEN month LIKE 'Jun%' THEN 6
                WHEN month LIKE 'Jul%' THEN 7
                WHEN month LIKE 'Aug%' THEN 8
                WHEN month LIKE 'Sep%' THEN 9
                WHEN month LIKE 'Oct%' THEN 10
                WHEN month LIKE 'Nov%' THEN 11
                WHEN month LIKE 'Dec%' THEN 12
                ELSE 13
            END";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    
    $stmt->close();
    return $records;
}

// Get home owner ID from URL parameter or use default
$homeOwnerId = isset($_GET['id']) ? intval($_GET['id']) : 1;
$homeOwnerData = getHomeOwnerData($conn, $homeOwnerId);
$accountRecords = getUserAccountRecords($conn, $homeOwnerId);

// If no home owner data found, display error message
if (!$homeOwnerData) {
    echo "Home owner not found.";
    exit;
}

// Check if we need to populate default months
if (count($accountRecords) == 0) {
    // Insert default months if no records exist
    $defaultMonths = [
        'Arr/Billed',
        'Jan-25', 'Feb-25', 'Mar-25', 'Apr-25', 
        'May-25', 'Jun-25', 'Jul-25', 'Aug-25', 
        'Sep-25', 'Oct-25', 'Nov-25', 'Dec-25'
    ];
    
    $insertSql = "INSERT INTO user_db_tbl (user_id, month) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSql);
    
    foreach ($defaultMonths as $month) {
        $stmt->bind_param("is", $homeOwnerId, $month);
        $stmt->execute();
    }
    
    $stmt->close();
    
    // Refresh the records
    $accountRecords = getUserAccountRecords($conn, $homeOwnerId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOA Account History</title>
    <link rel="stylesheet" href="res/css/user_dash.css">
    <style>
        .button-container {
            margin: 20px 0;
            text-align: right;
        }
        .button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .upload-form {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: none;
        }
        input[type="file"] {
            margin: 10px 0;
        }
    </style>
    <script>
        function toggleUploadForm() {
            var form = document.getElementById('uploadForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>HOME OWNER'S ASSOCIATION OF MAIA ALTA, INC.</h1>
            <h2>ACCOUNT HISTORY</h2>
        </div>
        
        <div class="owner-info">
            <div class="left-info">
                <div class="owner-name">NAME OF HOME OWNER: <?php echo htmlspecialchars($homeOwnerData['name']); ?></div>
                <div class="property-info">Lot Area: <?php echo htmlspecialchars($homeOwnerData['lot_no']); ?></div>
            </div>
        </div>
        
        <div class="button-container">
            <a href="download_excel.php?user_id=<?php echo $homeOwnerId; ?>" class="button">Download Excel</a>
            <button class="button" onclick="toggleUploadForm()">Upload Excel</button>
        </div>
        
        <div id="uploadForm" class="upload-form">
            <h3>Upload Excel File</h3>
            <form action="upload_excel.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $homeOwnerId; ?>">
                <input type="file" name="excel_file" accept=".xlsx, .xls, .csv" required>
                <button type="submit" class="button">Upload</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th rowspan="2">MONTH</th>
                    <th rowspan="2">HOA DUES</th>
                    <th colspan="12" class="penalty-header">PENALTY</th>
                    <th rowspan="2">TOTAL PENALTY</th>
                    <th rowspan="2">HOA DUES + PENALTY</th>
                    <th rowspan="2">DATE</th>
                    <th rowspan="2">PARTICULARS</th>
                    <th rowspan="2">OR#</th>
                    <th rowspan="2">AMOUNT PAID</th>
                    <th rowspan="2">BAL</th>
                </tr>
                <tr>
                    <th>JAN</th>
                    <th>FEB</th>
                    <th>MAR</th>
                    <th>APRIL</th>
                    <th>MAY</th>
                    <th>JUNE</th>
                    <th>JULY</th>
                    <th>AUG</th>
                    <th>SEPT</th>
                    <th>OCT</th>
                    <th>NOV</th>
                    <th>DEC</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accountRecords as $record): ?>
                <tr>
                    <td class="month-column"><?php echo htmlspecialchars($record['month']); ?></td>
                    <td><?php echo number_format($record['dues'], 2); ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_jan'] > 0 ? number_format($record['penalty_jan'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_feb'] > 0 ? number_format($record['penalty_feb'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_mar'] > 0 ? number_format($record['penalty_mar'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_apr'] > 0 ? number_format($record['penalty_apr'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_may'] > 0 ? number_format($record['penalty_may'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_jun'] > 0 ? number_format($record['penalty_jun'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_jul'] > 0 ? number_format($record['penalty_jul'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_aug'] > 0 ? number_format($record['penalty_aug'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_sep'] > 0 ? number_format($record['penalty_sep'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_oct'] > 0 ? number_format($record['penalty_oct'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_nov'] > 0 ? number_format($record['penalty_nov'], 2) : ''; ?></td>
                    <td class="penalty-columns"><?php echo $record['penalty_dec'] > 0 ? number_format($record['penalty_dec'], 2) : ''; ?></td>
                    <td><?php echo number_format($record['total_penalty'], 2); ?></td>
                    <td><?php echo number_format($record['dues_plus_penalty'], 2); ?></td>
                    <td><?php echo $record['payment_date'] ? date('m/d/Y', strtotime($record['payment_date'])) : ''; ?></td>
                    <td><?php echo htmlspecialchars($record['particulars']); ?></td>
                    <td><?php echo htmlspecialchars($record['or_number']); ?></td>
                    <td><?php echo number_format($record['amount_paid'], 2); ?></td>
                    <td><?php echo number_format($record['balance'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="total-amount">
            TOTAL AMOUNT DUE: <span class="php-currency">₱</span> <span class="highlight-cell" id="total-amount-due"><?php echo number_format($homeOwnerData['bill'], 2); ?></span>
        </div>
    </div>
</body>
</html>