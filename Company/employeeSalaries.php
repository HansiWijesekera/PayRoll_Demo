<?php include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];
$userID = $_SESSION['userID'];
$employeeId = 1;

$selectQuery1 = "select amount from employee_vise_categories inner join company_wise_categories on employee_vise_categories.companyWiseCategoriesId  = company_wise_categories.companyWiseCategoriesId
where employee_vise_categories.employeeId = $employeeId and salaryCategoryCode = 'BS' ";
$squery1  = mysqli_query($con, $selectQuery1);
while (($result1 = mysqli_fetch_assoc($squery1))) {
    $BasicSalary = implode(array_slice($result1, 0));
}

        if (isset($_POST['otherAllowance'])) {
            $otherAllowance = $_POST['otherAllowance'];
            echo $otherAllowance;
        }
                                      
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
    <script>

    </script>
    <div class="container-fluid" style="margin-top:30px !important;">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-9">
                    <h1>Employee Salaries</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser">
                    <thead>
                        <tr>
                            <th>Emplyee ID</th>
                            <th>Employee Name</th>
                            <th>Salary Date</th>
                            <th>
                                <?php
                                $selectQuery = "select salary_category.description from salary_category inner join company_wise_categories on company_wise_categories.salaryCategoryCode = salary_category.code where company_wise_categories.companyId  = $companyID ";
                                $squery = mysqli_query($con, $selectQuery);
                                while (($result = mysqli_fetch_assoc($squery))) {
                                ?>
                                    <?php
                                    foreach ($result as $key => $value) {
                                        echo "<th>";
                                        echo $value;
                                        echo "</th>";
                                    }
                                    ?>
                                <?php
                                }
                                ?></th>
                            <th>Other Allowance</th>
                            <th>Total Salary</th>
                            <th>Government Payments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $selectQuery = "select * from employee where employee.companyId = $companyID";
                        $squery = mysqli_query($con, $selectQuery);
                        while (($result = mysqli_fetch_assoc($squery))) {
                        ?>
                            <tr>
                                <td CLASS="employeeIds"><?php echo $result['employeeId'];
                                                        $_SESSION['employeeId'] = $result['employeeId']; ?></td>
                                <td><?php echo $result['employeeName']; ?></td>
                                <td>
                                    <?php
                                    $selectQuery1 = "SELECT * FROM company WHERE company.userId= $userID";
                                    $squery1 = mysqli_query($con, $selectQuery1);
                                    while (($result1 = mysqli_fetch_assoc($squery1))) {
                                        $time = strtotime($result1['lastUpdateDate']);
                                        $final = date("Y-m-d", strtotime("+1 month", $time));
                                        echo $final;
                                        $_SESSION['final'] = $final;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $selectQuery2 = "select salary_category.commonValue from salary_category inner join company_wise_categories on company_wise_categories.salaryCategoryCode = salary_category.code where company_wise_categories.companyId  = $companyID and salary_category.status = 'G' ";
                                    $squery2 = mysqli_query($con, $selectQuery2);
                                    while (($result2 = mysqli_fetch_assoc($squery2))) {
                                        $commonValue = implode(array_slice($result2, 0));
                                    ?>
                                        <?php
                                        foreach ($result2 as $key => $value2) {
                                            echo "<td>";
                                            $value = ($BasicSalary * $commonValue) / 100;
                                            $_SESSION['val'] = $value;
                                            echo $value;
                                            echo "</td>";
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                    <?php

                                    $selectQuery1 = "select amount from employee_vise_categories where employee_vise_categories.employeeId = $employeeId ";
                                    $squery1  = mysqli_query($con, $selectQuery1);
                                    while (($result1 = mysqli_fetch_assoc($squery1))) {
                                        $amount = implode(array_slice($result1, 0));
                                    ?>
                                        <?php
                                        foreach ($result1 as $key => $value2) {
                                            echo "<td>";
                                            echo $amount;
                                            echo "</td>";
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <form id="form" method="post">
                                        <input type="number" id="input" name="otherAllowance"/>
                                        <input type="submit" id="insert" name="submit" hidden/>
                                        <script>
                                            $(document).ready(function() {

                                                var toSubmit = function() {
                                                    var text = $("#input").val();

                                                    // for testing only:
                                                    $('#output').text(text);

                                                    // do whatever you want to do with 'text' variable here

                                                    return false;
                                                };

                                                var formSubmit = function(e) {
                                                    $('#form').submit(toSubmit);
                                                };

                                                // call this when you want to bind the submit handler
                                                formSubmit();

                                            });
                                        </script>
                                        <?php
                                       
                                        ?>
                                    </form>
                                </td>
                                <td>
                                    <?php
                                    $selectQuery4 = "SELECT IFNULL($BasicSalary * SUM(commonValue)/100,0) - (SELECT IFNULL($BasicSalary * SUM(commonValue)/100,0) + (SELECT IFNULL(SUM(commonValue),0) - (SELECT IFNULL(SUM(commonValue),0) 
                                                    +(SELECT ifnull(SUM(AMOUNT),0) - (SELECT ifnull(SUM(AMOUNT),0) FROM (employee_vise_categories INNER JOIN company_wise_categories 
                                                    ON employee_vise_categories.companyWiseCategoriesId = company_wise_categories.companyWiseCategoriesId  )
                                                    INNER JOIN salary_category ON salary_category.code = company_wise_categories.salaryCategoryCode 
                                                    WHERE employeeId = $employeeId ANd type = 'Deduction') 
                                                    FROM (employee_vise_categories INNER JOIN company_wise_categories
                                                    ON employee_vise_categories.companyWiseCategoriesId = company_wise_categories.companyWiseCategoriesId  )
                                                    INNER JOIN salary_category ON salary_category.code = company_wise_categories.salaryCategoryCode 
                                                    WHERE employee_vise_categories.employeeId = $employeeId ANd salary_category.type = 'Addition') 
                                                    FROM salary_category  INNER JOIN company_wise_categories 
                                                    on salary_category.code = company_wise_categories.salaryCategoryCode
                                                    WHERE companyId = 1 AND `type` = 'Deduction' AND common = 'Amount') FROM salary_category INNER JOIN company_wise_categories on salary_category.code = company_wise_categories.salaryCategoryCode
                                                    WHERE companyId = 1 AND `type` = 'Addition' AND common = 'Amount') FROM salary_category INNER JOIN company_wise_categories on salary_category.code = company_wise_categories.salaryCategoryCode
                                                    WHERE companyId = 1 AND `type` = 'Deduction' AND common = 'Rate') FROM salary_category INNER JOIN company_wise_categories on salary_category.code = company_wise_categories.salaryCategoryCode
                                                    WHERE companyId = 1 AND `type` = 'Addition' AND common = 'Rate'";
                                    $squery4 = mysqli_query($con, $selectQuery4);
                                    while (($result4 = mysqli_fetch_assoc($squery4))) {
                                        $finalSalary = implode($result4);
                                    }
                                    echo bcdiv($finalSalary, 1, 2);

                                    ?>


                                </td>

                                <td>
                                    <?php
                                    $selectQuery4 = "select SUM(commonValue) from salary_category where status = 'G'";
                                    $squery4 = mysqli_query($con, $selectQuery4);
                                    while (($result4 = mysqli_fetch_assoc($squery4))) {
                                        $amount = implode($result4);
                                        echo  $BasicSalary * $amount / 100;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <input type="submit" class="btnRegister" name="submit" value="Add Salary">
                </div>
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

        //  $(document).on('click', '.btnRegister', function() {
        //     console.log($('.employeeIds').classList);

        // });
    </script>

</body>

</html>