<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

include '../dbconn.php';
include '../Headers/adminHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 1) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];

$today = DATE("Y-m-d");
echo $today;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <h1>Company vise Due Amounts</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser1">
                    <thead>
                        <tr>
                            <th>Company Id</th>
                            <th>Company Name</th>
                            <th>Due Amount</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery1 = "select SUM(salary.payableAmount - ifnull(salary.settledAmount,0)),salary.dueDate,company.companyName,company.companyId FROM company INNER JOIN ( salary inner join employee on salary.employeeId = employee.employeeId ) 
                                         ON company.companyId = employee.companyId
                                         where salary.dueDate <= CURDATE() and (salary.payableAmount - ifnull(salary.settledAmount,0)) > 0 
                                         GROUP BY employee.companyId; ";
                        $squery1 = mysqli_query($con, $selectQuery1);
                        while (($result1 = mysqli_fetch_row($squery1))) {
                        ?>
                            <tr>
                                <td><?php echo $result1[3]; ?></td>
                                <td><?php echo $result1[2]; ?></td>
                                <td><?php echo $result1[0]; ?></td>
                                <td><?php echo $result1[1]; ?></td>
                            <?php
                        }
                            ?>
                    </tbody>
                </table>
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
                            <th>Company Id</th>
                            <th>Company Name</th>
                            <th>Due Amount</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery = "select SUM(salary.payableAmount - ifnull(salary.settledAmount,0)),salary.dueDate,company.companyName,company.companyId FROM company INNER JOIN ( salary inner join employee on salary.employeeId = employee.employeeId ) 
                                         ON company.companyId = employee.companyId
                                         where salary.dueDate > CURDATE() GROUP BY employee.companyId; ";
                        $squery = mysqli_query($con, $selectQuery);
                        while (($result = mysqli_fetch_row($squery))) {
                        ?>
                            <tr>
                                <td><?php echo $result[3]; ?></td>
                                <td><?php echo $result[2]; ?></td>
                                <td><?php echo $result[0]; ?></td>
                                <td><?php echo $result[1]; ?></td>
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