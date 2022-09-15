<?php include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];

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
                    <h1>Company Employees</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser">
                    <thead>
                        <tr>

                            <th>
                            <th>Employee Name</th>
                            <th>Join Date</th>
                            <th>Addess</th>
                            <th>NIC</th>
                            <th>DOB</th>
                            <th>Contact No</th>
                            <th>Job Title</th>
                            <th>Email</th>
                            <th>Bank Code</th>
                            <th>Branch Code</th>
                            <th>Account Holder</th>
                            <th>Initiated Date</th>
                            <th>Modify Employee Datails</th>

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery = "select * from employee where companyId  = $companyID and status = 'A' ";
                        $squery = mysqli_query($con, $selectQuery);
                        while (($result = mysqli_fetch_assoc($squery))) {
                        ?>
                            <tr>
                                <td><?php echo $result['employeeId'];
                                    $empid = $result['employeeId'];
                                    $_SESSION['employeeId'] = $result['employeeId']; ?></td>
                                <td><?php echo $result['employeeName']; ?></td>
                                <td><?php echo $result['joinDate']; ?></td>
                                <td><?php echo $result['address']; ?></td>
                                <td><?php echo $result['nic']; ?></td>
                                <td><?php echo $result['dob']; ?></td>
                                <td><?php echo $result['cantactNo']; ?></td>
                                <td><?php echo $result['jobTitle']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td> <?php
                                        $selectQuery1 = "SELECT * FROM  bankinfo WHERE employeeId = '$empid' ";
                                        $squery1 = mysqli_query($con, $selectQuery1);
                                        while (($result1 = mysqli_fetch_assoc($squery1))) {
                                            echo $result1['bankCode'];
                                        }
                                        ?>
                                </td>
                                <td> <?php
                                        $selectQuery1 = "SELECT * FROM  bankinfo WHERE employeeId = '$empid' ";
                                        $squery1 = mysqli_query($con, $selectQuery1);
                                        while (($result1 = mysqli_fetch_assoc($squery1))) {
                                            echo $result1['branchCode'];
                                        }
                                        ?>
                                </td>
                                <td> <?php
                                        $selectQuery1 = "SELECT * FROM  bankinfo WHERE employeeId = '$empid' ";
                                        $squery1 = mysqli_query($con, $selectQuery1);
                                        while (($result1 = mysqli_fetch_assoc($squery1))) {
                                            echo $result1['accoundHolder'];
                                        }
                                        ?>
                                </td>
                                <td> <?php
                                        $selectQuery1 = "SELECT * FROM  bankinfo WHERE employeeId = '$empid' ";
                                        $squery1 = mysqli_query($con, $selectQuery1);
                                        while (($result1 = mysqli_fetch_assoc($squery1))) {
                                            echo $result1['initiatedDate'];
                                        }
                                        ?>
                                </td>
                                <td>
                                    <a href="changeEmpDetails.php?id=<?php echo $result['employeeId']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                    <a href="expireEmployees.php?id=<?php echo $result['employeeId']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
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