<?php

use LDAP\Result;
use PhpOffice\PhpSpreadsheet\Shared\Date;

include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();

if (!isset($_SESSION['userID'])|| $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];
$companyID = $_SESSION['companyId'];

$today = DATE("Y-m-d");
echo $today;

$salaryid = $_GET['id'];

$selectQuery = "select * from salary inner join employee on salary.employeeId = employee.EmployeeId  where salary.salaryID = $salaryid ";
$squery = mysqli_query($con, $selectQuery);
$result = mysqli_fetch_assoc($squery);
$settledAmount = $result['settledAmount'];

if (isset($_POST['amount'])) {
    $paidAmount = $_POST['amount'] + $settledAmount;
    $query = "UPDATE salary set settledAmount = '" . $paidAmount . "'  , paidDate = '" . $today . "' WHERE salaryID = $salaryid ";
    if (mysqli_query($con, $query)) {
        echo "<script type='text/javascript'>alert('Salary Payment Completed');location.href='employeeDues.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('Failed to done payment');location.href='salaryPayments.php?id=$salaryid;'</script>";
    }
}

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div class="row" style="padding-left: 30%; padding-top: 70px; ">
    <div class="col-lg-7" style="padding: 10%;">
        <div class="card">
            <div class="card-header text-center">
                <h4>Salary Payment</h4>
            </div>
            <h6>Employee Name - <?php echo $result['employeeName']; ?> </h6>
            <h6>Due Date - <?php echo $result['dueDate']; ?> </h6>
            <h6>Due Amount - Rs.<?php echo $result['payableAmount']; ?> </h6>
            <h6>Settled Amount - Rs.<?php echo $settledAmount; ?> </h6>
            <h6>Remaining Amount - Rs.<?php echo $result['payableAmount'] - $settledAmount; ?> </h6>
            <form method="post" enctype="multipart/form-data">
                <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                    <div class="form-group">
                        <label class="form-control-label">Enter Paying Amount</label>
                        <input type="number" name="amount" class="form-control" max="<?php echo ($result['payableAmount'] - $settledAmount); ?>" required />
                    </div><br>
                    <div class="form-group">
                        <input type="submit" class="btnRegister" name="submit" value="Submit Payment">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>