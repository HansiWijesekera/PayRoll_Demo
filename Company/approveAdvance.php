<?php include '../dbconn.php';

session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];
$userID = $_SESSION['userID'];

$id = $_GET['id'];

$query = "update salary_advance set status = 'A' where advanceId = $id ";
    if (mysqli_query($con, $query)) {
    echo " <script type='text/javascript'>alert('Advance Approved Sucessfully');location.href='viewAdvance.php'</script>";
    }
else {
    echo " <script type='text/javascript'>alert('Error');location.href='viewAdvance.php'</script>";
}
