<?php

require_once('./db.php');
session_start();
if (!isset($_SESSION['userID']) ) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];
$userID = $_SESSION['userID'];

$expo_query = "select salaryNo,EmployeeName,nic,PayableAmount,settledAmount,(PayableAmount - ifnull(settledAmount,0)),dueDate , PaidDate from salary inner join employee on salary.employeeId = employee.EmployeeId
                where employee.companyId = 1 and  salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ";
$result = mysqli_query($con, $expo_query);
$columnHeader = '';
$columnHeader = "Salary Number" . "\t" . "Employee Name" . "\t" . "NIC" . "\t" . "Payable Amount" . "\t" . "Paid Amount" . "\t" . "Remaining Amount" . "\t" . "Due Date" . "\t" . "Last Payment Date" ;

$setData = '';
while ($rec = mysqli_fetch_row($result)) {
    $rowData = '';
    foreach ($rec as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
    }
    $setData .= trim($rowData) . "\n";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";


