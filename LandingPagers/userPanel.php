<?php
include '../dbconn.php';
session_start();
include '../Headers/userHeader.php';

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 3) {
    header("location: ../index.php");
    exit();
}

$userId = $_SESSION['userID'];


$getEmpDetails = "select * from employee where userId = $userId";
$squery1  = mysqli_query($con, $getEmpDetails);
while (($result1 = mysqli_fetch_row($squery1))) {
    $_SESSION['employeeId'] = $result1[0];
    $_SESSION['companyId'] = $result1[10];
}

?>