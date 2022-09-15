<?php
include '../dbconn.php';
session_start();
include '../Headers/companyHeader.php';

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$userId = $_SESSION['userID'];

$getCompanyDetails = "select * from company where userId = $userId";
$squery1  = mysqli_query($con, $getCompanyDetails);
while (($result1 = mysqli_fetch_row($squery1))) {
    $_SESSION['companyId'] = $result1[0];
}

$companyID = $_SESSION['companyId'];
//$companyID = 1;

$today = DATE("Y-m-d");

$selectQuery = "select count(distinct salary.employeeId) , COUNT(DISTINCT salary.salaryId) , ifnull(sum(payableAmount) - (select sum(settledAmount) from salary inner join employee on salary.employeeId = employee.EmployeeId
where employee.companyId = $companyID and  salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ),0)
from salary inner join employee on salary.employeeId=employee.EmployeeId where employee.companyId=$companyID and salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ";
$squery = mysqli_query($con, $selectQuery);
$result = mysqli_fetch_row($squery);


?>

<html lang=" en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,
	initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <style>
        body {
            height: 50px;
            width: 100%;
        }

        #popup {
            width: 550px;
            height: auto;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body style="background-color: gray;">
    <br />
    <br />
    <div class="POPmain" style="display: none;">
        <div id="popup">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Salary Payments for next 15 days</h4>
                </div>
                <h6>Number of Employees - <?php echo $result[0]; ?> </h6>
                <h6>Number of Salaries - <?php echo $result[1]; ?> </h6>
                <h6>Total Due Amount - Rs.<?php echo $result[2]; ?> </h6>
            </div>
            <a href="../Excel/companyDues.php">
                <button class="submitId btn btn-primary font-weight-bold mt-5">
                    View and Download Details
                </button>
            </a>
                <button class="submitId btn btn-primary text-center font-weight-bold mt-5">
                    Ok!
                </button>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first,then Popper.js,then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        // When document is ready
        $(document).ready(function() {
            // SetTimeout function
            // Will execute the function
            // after 3 sec
            setTimeout(function() {
                $(".POPmain").css("display", "block");
            }, 500);
        });
        $(".submitId").click(function() {
            $(".POPmain").css("display", "none");
        });
    </script>
</body>

</html>