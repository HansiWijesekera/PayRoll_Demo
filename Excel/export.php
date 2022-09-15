<?php

require_once('./db.php');


$expo_query = "SELECT * FROM errors";
$result = mysqli_query($con, $expo_query);
$columnHeader = '';
$columnHeader = "Employee Name" . "\t" . "Join Date" . "\t" . "Address" . "\t" . "NIC" . "\t". "Birthday" . "\t" . "Contact No" . "\t" . "Job Title" . "\t" . "Email"
. "\t" . "Bank Code" . "\t" . "Short Code" . "\t" . "Account Holder" . "\t" . "Initiated Date" . "\t" . "User name" . "\t" . "Passoword"
. "\t"  . "Fix Allowance" . "\t"  . "basic Salary" . "\t" . "Error"   ;

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


$truncateQuery = "TRUNCATE TABLE errors";
mysqli_query($con, $truncateQuery);
header('excelUserUpload.php');

