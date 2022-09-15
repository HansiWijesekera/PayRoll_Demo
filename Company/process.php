<?php include '../dbconn.php';
session_start();



$salaryNo = 1;
$employeeId = $_SESSION['employeeId'];
$payableAmount = $_SESSION['tot_sal'];
$dueDate = $_SESSION['final'] ;
$status = "I";

$query =
"INSERT INTO salary(salaryNo,employeeId,payableAmount,dueDate,status)
VALUES('$salaryNo','$employeeId','$payableAmount','$dueDate','$status')";


if (mysqli_query($con, $query)) {
echo " <script type='text/javascript'>alert('Salary Added SUcessfully');location.href='employeeSalaries.php'</script>";
} else {
echo "Error" . $query . "<br>" . mysqli_error($con);
}
mysqli_close($con);

