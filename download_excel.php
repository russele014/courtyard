<?php
// download_excel.php - Script to generate Excel file from database

require 'vendor/autoload.php';
include 'database/db_connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get user ID from URL parameter
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($userId <= 0) {
    die("Invalid user ID");
}

// Get user data
$userQuery = "SELECT name, lot_no FROM admin_db_tbl WHERE id = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("i", $userId);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userData = $userResult->fetch_assoc();

if (!$userData) {
    die("User not found");
}

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set worksheet title
$sheet->setTitle('Account History');

// Add headers
$sheet->setCellValue('A1', 'MONTH');
$sheet->setCellValue('B1', 'HOA DUES');
$sheet->setCellValue('C1', 'JAN');
$sheet->setCellValue('D1', 'FEB');
$sheet->setCellValue('E1', 'MAR');
$sheet->setCellValue('F1', 'APR');
$sheet->setCellValue('G1', 'MAY');
$sheet->setCellValue('H1', 'JUN');
$sheet->setCellValue('I1', 'JUL');
$sheet->setCellValue('J1', 'AUG');
$sheet->setCellValue('K1', 'SEP');
$sheet->setCellValue('L1', 'OCT');
$sheet->setCellValue('M1', 'NOV');
$sheet->setCellValue('N1', 'DEC');
$sheet->setCellValue('O1', 'TOTAL PENALTY');
$sheet->setCellValue('P1', 'HOA DUES + PENALTY');
$sheet->setCellValue('Q1', 'DATE');
$sheet->setCellValue('R1', 'PARTICULARS');
$sheet->setCellValue('S1', 'OR#');
$sheet->setCellValue('T1', 'AMOUNT PAID');
$sheet->setCellValue('U1', 'BAL');

// Get user's account data
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

// Add data rows
$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowIndex, $row['month']);
    $sheet->setCellValue('B' . $rowIndex, $row['dues']);
    $sheet->setCellValue('C' . $rowIndex, $row['penalty_jan']);
    $sheet->setCellValue('D' . $rowIndex, $row['penalty_feb']);
    $sheet->setCellValue('E' . $rowIndex, $row['penalty_mar']);
    $sheet->setCellValue('F' . $rowIndex, $row['penalty_apr']);
    $sheet->setCellValue('G' . $rowIndex, $row['penalty_may']);
    $sheet->setCellValue('H' . $rowIndex, $row['penalty_jun']);
    $sheet->setCellValue('I' . $rowIndex, $row['penalty_jul']);
    $sheet->setCellValue('J' . $rowIndex, $row['penalty_aug']);
    $sheet->setCellValue('K' . $rowIndex, $row['penalty_sep']);
    $sheet->setCellValue('L' . $rowIndex, $row['penalty_oct']);
    $sheet->setCellValue('M' . $rowIndex, $row['penalty_nov']);
    $sheet->setCellValue('N' . $rowIndex, $row['penalty_dec']);
    $sheet->setCellValue('O' . $rowIndex, $row['total_penalty']);
    $sheet->setCellValue('P' . $rowIndex, $row['dues_plus_penalty']);
    $sheet->setCellValue('Q' . $rowIndex, $row['payment_date']);
    $sheet->setCellValue('R' . $rowIndex, $row['particulars']);
    $sheet->setCellValue('S' . $rowIndex, $row['or_number']);
    $sheet->setCellValue('T' . $rowIndex, $row['amount_paid']);
    $sheet->setCellValue('U' . $rowIndex, $row['balance']);
    
    $rowIndex++;
}

// Add user information
$spreadsheet->createSheet();
$infoSheet = $spreadsheet->getSheet(1);
$infoSheet->setTitle('User Info');
$infoSheet->setCellValue('A1', 'Name:');
$infoSheet->setCellValue('B1', $userData['name']);
$infoSheet->setCellValue('A2', 'Lot No:');
$infoSheet->setCellValue('B2', $userData['lot_no']);

// Set the first sheet as active
$spreadsheet->setActiveSheetIndex(0);

// Format columns
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(12);
$sheet->getColumnDimension('Q')->setWidth(12);
$sheet->getColumnDimension('R')->setWidth(20);

// Create the Excel file
$writer = new Xlsx($spreadsheet);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="HomeOwner_AccountHistory_' . $userId . '.xlsx"');
header('Cache-Control: max-age=0');

// Output the file
$writer->save('php://output');

// Close database connections
$stmt->close();
$userStmt->close();
$conn->close();
exit;
?>