<?php include '../dbconn.php';

session_start();
$employeeId = $_SESSION['employeeId'];

$id = $_GET['id'];


$selectQuery = "SELECT * FROM employee WHERE employeeId= $id";
$squery = mysqli_query($con, $selectQuery);

while (($result = mysqli_fetch_assoc($squery))) {
    $userId  = $result['userId'];
    //echo $userId;
}

$queryX = "update user set userType = '4' where userID = $userId ";
if (mysqli_query($con, $queryX)) {
    $query = "update employee set status = 'E' where employeeId = $id ";
    if (mysqli_query($con, $query)) {
    echo " <script type='text/javascript'>alert('User Details Modified Sucessfully');location.href='viewEmployees.php'</script>";
    }
} else {
    echo " <script type='text/javascript'>alert('Error in user details modification');location.href='viewEmployees.php'</script>";
}

?>
