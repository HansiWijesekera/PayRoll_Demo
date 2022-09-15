<?php include '../dbconn.php';

session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];
$userID = $_SESSION['userID'];

$id = $_GET['id'];

$query = "update salary_advance,salary set salary.settledAmount = (ifnull(salary.settledAmount,0) + salary_advance.amount), salary_advance.status = 'P', salary.paidDate = CURDATE() 
where salary_advance.advanceId = $id and salary.salaryNo = salary_advance.salaryNo and salary.employeeId = salary_advance.employeeId ";
if (mysqli_query($con, $query)) {
    echo " <script type='text/javascript'>alert('Advance Paid Sucessfully');location.href='payAdvance.php'</script>";
} else {
    echo " <script type='text/javascript'>alert('Error');location.href='payAdvance.php'</script>";
}


