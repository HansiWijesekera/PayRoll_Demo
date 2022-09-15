<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];
$companyID = $_SESSION['companyId'];


$today = DATE("Y-m-d");
echo $today;

?>

<!DOCTYPE html>
<html>

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

<body>

    <div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Due Amounts</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser1">
                    <thead>
                        <tr>
                            <th>Salary Number</th>
                            <th>Employee Name</th>
                            <th>Payble Amount</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Due Date</th>
                            <th>Paid Date</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery1 = "select * from salary inner join employee on salary.employeeId = employee.employeeId 
                        where salary.dueDate <= CURDATE() and employee.companyId = $companyID and (salary.payableAmount - ifnull(salary.settledAmount,0)) > 0 ";
                        $squery1 = mysqli_query($con, $selectQuery1);
                        while (($result1 = mysqli_fetch_assoc($squery1))) {
                            $salaryId = $result1['salaryID'];
                        ?>
                            <tr>
                                <td><?php echo $result1['salaryNo']; ?></td>
                                <td><?php echo $result1['employeeName']; ?></td>
                                <td><?php echo $result1['payableAmount']; ?></td>
                                <td><?php echo $result1['settledAmount']; ?></td>
                                <td><?php echo ($result1['payableAmount'] - $result1['settledAmount']); ?></td>
                                <td><?php echo $result1['dueDate']; ?></td>
                                <td><?php echo $result1['paidDate']; ?></td>
                                <td>
                                    <a href="salaryPayments.php?id=<?php echo $salaryId; ?>" class="btn btn-primary btn-sm">Pay Here</a>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="payAllDues.php" class="btn btn-primary btn-sm">Pay All Due Amounts</a>

            </div>
        </div>
        <br> <br> <br> <br> <br>
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Future Dues</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser">
                    <thead>
                        <tr>
                            <th>Salary Number</th>
                            <th>Employee Name</th>
                            <th>Payble Amount</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Due Date</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery = "select * from salary inner join employee on salary.employeeId = employee.employeeId 
                        where salary.dueDate > CURDATE() and employee.companyId = $companyID and (salary.payableAmount - ifnull(salary.settledAmount,0)) > 0 ";
                        $squery = mysqli_query($con, $selectQuery);
                        while (($result = mysqli_fetch_assoc($squery))) {
                        ?>
                            <tr>
                                <td><?php echo $result['salaryNo']; ?></td>
                                <td><?php echo $result['employeeName']; ?></td>
                                <td><?php echo $result['payableAmount']; ?></td>
                                <td><?php echo $result['settledAmount']; ?></td>
                                <td><?php echo ($result['payableAmount'] - $result['settledAmount']); ?></td>
                                <td><?php echo $result['dueDate']; ?></td>
                                <td><?php echo $result['paidDate']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('#tblUser').DataTable();
            $("#form-body").hide();

            $("#insert-btn").on('click', function() {
                $("#form-body").toggle(500);
            });

            $("#submit").on('click', function(e) {
                e.preventDefault();

                var name = $('#name').val();
                var email = $('#email').val();

                $.ajax({
                    url: "insert_data.php",
                    type: "POST",
                    data: {
                        name: name,
                        email: email
                    },
                    success: function(data) {
                        alert("Data Inserted Successfully");
                        $("#form-body").hide();
                        location.reload(true);
                    }
                });

            });

        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            $('#tblUser1').DataTable();
            $("#form-body").hide();

            $("#insert-btn").on('click', function() {
                $("#form-body").toggle(500);
            });

            $("#submit").on('click', function(e) {
                e.preventDefault();

                var name = $('#name').val();
                var email = $('#email').val();

                $.ajax({
                    url: "insert_data.php",
                    type: "POST",
                    data: {
                        name: name,
                        email: email
                    },
                    success: function(data) {
                        alert("Data Inserted Successfully");
                        $("#form-body").hide();
                        location.reload(true);
                    }
                });

            });

        });
    </script>

</body>

</html>