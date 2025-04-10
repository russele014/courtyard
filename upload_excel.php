<?php
// upload_excel.php - Script to handle Excel uploads and database updates

// Include necessary libraries and connection
require 'vendor/autoload.php'; // For PhpSpreadsheet
include 'database/db_connection.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $targetDir = "uploads/";
    
    // Create directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    if ($userId <= 0) {
        die("Invalid user ID");
    }
    
    // Get filename and ensure it's unique
    $fileName = basename($_FILES["excel_file"]["name"]);
    $targetFilePath = $targetDir . time() . '_' . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
    // Check if file is a valid Excel file
    $allowedTypes = array('xlsx', 'xls', 'csv');
    if (!in_array($fileType, $allowedTypes)) {
        die("Sorry, only Excel files are allowed");
    }
    
    // Upload file
    if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $targetFilePath)) {
        try {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($targetFilePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Start from row 2 (assuming row 1 is header)
            $highestRow = $worksheet->getHighestRow();
            
            // Begin transaction
            $conn->begin_transaction();
            
            // Delete existing records for this user to avoid duplicates
            $deleteStmt = $conn->prepare("DELETE FROM user_db_tbl WHERE user_id = ?");
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();
            
            // Prepare insert statement
            $sql = "INSERT INTO user_db_tbl (
                    user_id, month, dues, 
                    penalty_jan, penalty_feb, penalty_mar, penalty_apr, 
                    penalty_may, penalty_jun, penalty_jul, penalty_aug, 
                    penalty_sep, penalty_oct, penalty_nov, penalty_dec, 
                    total_penalty, dues_plus_penalty, payment_date, 
                    particulars, or_number, amount_paid, balance
                ) VALUES (
                    ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, 
                    ?, ?, ?, ?
                )";
            
            $stmt = $conn->prepare($sql);
            
            // Process each row in the Excel file
            for ($row = 2; $row <= $highestRow; $row++) {
                // Using coordinate-based cell access instead of getCellByColumnAndRow
                $month = $worksheet->getCell(Coordinate::stringFromColumnIndex(1) . $row)->getValue();
                if (empty($month)) continue; // Skip empty rows
                
                $dues = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(2) . $row)->getValue());
                
                // Get penalty values for each month
                $penaltyJan = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(3) . $row)->getValue());
                $penaltyFeb = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(4) . $row)->getValue());
                $penaltyMar = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(5) . $row)->getValue());
                $penaltyApr = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(6) . $row)->getValue());
                $penaltyMay = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(7) . $row)->getValue());
                $penaltyJun = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(8) . $row)->getValue());
                $penaltyJul = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(9) . $row)->getValue());
                $penaltyAug = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(10) . $row)->getValue());
                $penaltySep = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(11) . $row)->getValue());
                $penaltyOct = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(12) . $row)->getValue());
                $penaltyNov = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(13) . $row)->getValue());
                $penaltyDec = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(14) . $row)->getValue());
                
                $totalPenalty = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(15) . $row)->getValue());
                $duesPlusPenalty = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(16) . $row)->getValue());
                
                // Get payment date and convert to MySQL date format
                $paymentDateValue = $worksheet->getCell(Coordinate::stringFromColumnIndex(17) . $row)->getValue();
                if ($paymentDateValue instanceof \DateTime) {
                    $paymentDate = $paymentDateValue->format('Y-m-d');
                } else if (is_numeric($paymentDateValue)) {
                    // Handle Excel serial date format
                    $paymentDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($paymentDateValue)->format('Y-m-d');
                } else {
                    $paymentDate = null;
                }
                
                $particulars = $worksheet->getCell(Coordinate::stringFromColumnIndex(18) . $row)->getValue();
                $orNumber = $worksheet->getCell(Coordinate::stringFromColumnIndex(19) . $row)->getValue();
                $amountPaid = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(20) . $row)->getValue());
                $balance = floatval($worksheet->getCell(Coordinate::stringFromColumnIndex(21) . $row)->getValue());
                
                // FIXED: Count the number of parameters carefully and ensure types match
                $stmt->bind_param(
                    "isdddddddddddddddsssdd",  // 21 parameters: 1 integer, 15 doubles, 3 strings, 2 doubles
                    $userId, $month, $dues,
                    $penaltyJan, $penaltyFeb, $penaltyMar, $penaltyApr,
                    $penaltyMay, $penaltyJun, $penaltyJul, $penaltyAug,
                    $penaltySep, $penaltyOct, $penaltyNov, $penaltyDec,
                    $totalPenalty, $duesPlusPenalty, $paymentDate,
                    $particulars, $orNumber, $amountPaid, $balance
                );
                
                $stmt->execute();
            }
            
            // Commit transaction
            $conn->commit();
            
            echo "Excel data successfully imported to database!";
            
            // Optional: Update the total bill in admin_db_tbl
            updateTotalBill($conn, $userId);
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        } finally {
            // Close database connection - safely check if variables exist first
            if (isset($stmt) && $stmt) {
                $stmt->close();
            }
            if (isset($deleteStmt) && $deleteStmt) {
                $deleteStmt->close();
            }
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "Please select a file to upload.";
}

// Function to update the total bill in admin_db_tbl
function updateTotalBill($conn, $userId) {
    // Calculate total bill from user_db_tbl
    $sql = "SELECT SUM(balance) as total_bill FROM user_db_tbl WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $totalBill = $row['total_bill'];
        
        // Update bill in admin_db_tbl
        $updateSql = "UPDATE admin_db_tbl SET bill = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("di", $totalBill, $userId);
        $updateStmt->execute();
        $updateStmt->close();
    }
    
    $stmt->close();
}
?>