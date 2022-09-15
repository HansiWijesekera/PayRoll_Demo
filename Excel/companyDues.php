<?php include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];
$userID = $_SESSION['userID'];
//$companyID = 1;

$today = DATE("Y-m-d");
$selectQuery = "select count(distinct salary.employeeId) , COUNT(DISTINCT salary.salaryId) , ifnull(sum(payableAmount) - (select sum(settledAmount) from salary inner join employee on salary.employeeId = employee.EmployeeId
where employee.companyId = $companyID and  salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ),0)
from salary inner join employee on salary.employeeId=employee.EmployeeId where employee.companyId=$companyID and salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ";
$squery = mysqli_query($con, $selectQuery);
$result = mysqli_fetch_row($squery);

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


<div class="container">
    <br><br> <br>
    <div class="card">
        <div class="card-header text-center">
            <h4>Salary Payments for next 15 days</h4>
        </div>
        <h6>Number of Employees - <?php echo $result[0]; ?> </h6>
        <h6>Number of Salaries - <?php echo $result[1]; ?> </h6>
        <h6>Total Due Amount - Rs.<?php echo $result[2]; ?> </h6>
    </div>
    <br><br>
    <div class="row mb-2">
        <div class="col-md-9">
            <h1>Detaild View</h1>

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
                $selectQuery = "select * from salary inner join employee on salary.employeeId = employee.EmployeeId
                where employee.companyId = $companyID and  salary.dueDate > CURDATE() AND salary.dueDate <= DATE_ADD(CURDATE(), INTERVAL 15 DAY) ";
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
        <form action="duesExport.php" method="post">
            <input type="submit" name="submit" value="Export To Excel">
        </form>
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