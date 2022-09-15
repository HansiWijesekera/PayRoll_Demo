<?php include '../dbconn.php';

session_start();
$employeeId = $_SESSION['employeeId'];

$id = $_GET['id'];

$query = "update salary_advance set status = 'R' where advanceId = $id ";
    if (mysqli_query($con, $query)) {
    echo " <script type='text/javascript'>alert('Advance Rejected Sucessfully');location.href='viewAdvance.php'</script>";
    }
else {
    echo " <script type='text/javascript'>alert('Error');location.href='viewAdvance.php'</script>";
}
?>
