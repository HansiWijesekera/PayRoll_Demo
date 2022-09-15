<?php include '../dbconn.php';
include '../Headers/userHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 3) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];
$employeeID = $_SESSION['employeeId'];

if (isset($_POST['amount'])) {
    $amount = $_POST['amount'];
    $date = date("Y-m-d");
    $status = 'I';

    $queryAdvance = "SELECT max(salaryNo) FROM salary WHERE employeeId = $employeeID";
    $squery = mysqli_query($con, $queryAdvance);
    while (($result = mysqli_fetch_assoc($squery))) {
        $salaryNo = IMPLODE($result);
        //echo $userId;
    }

    $query = "INSERT INTO salary_advance(salaryNo,employeeId,amount,date,status)
	     VALUES('$salaryNo','$employeeID','$amount','$date','$status')";

    $query = mysqli_query($con, $query);
    echo "<script type='text/javascript'>alert('Advance Added Sucessfully');location.href='requestAdvance.php'</script>";
}


$queryBS = "select ifnull(sum(employee_vise_categories.amount),0) from employee_vise_categories inner join company_wise_categories 
    on company_wise_categories.companyWiseCategoriesId = employee_vise_categories.companyWiseCategoriesId
    where (company_wise_categories.salaryCategoryCode = 'BS' or company_wise_categories.salaryCategoryCode = 'FA') and employeeId = $employeeID";
$squery = mysqli_query($con, $queryBS);
while (($result = mysqli_fetch_assoc($squery))) {
    $BS  = IMPLODE($result);
    //echo $userId;
}


$queryAdvance = "select ifnull(SUM(amount),0) from salary_advance WHERE salaryNo = (SELECT max(salaryNo) FROM salary WHERE
                  employeeId = $employeeID) and employeeId = $employeeID AND STATUS = 'A'";
$squery = mysqli_query($con, $queryAdvance);
while (($result = mysqli_fetch_assoc($squery))) {
    $Advance = IMPLODE($result);
    //echo $userId;
}

$maxAmt = $BS - $Advance;


?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylex.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="ajax-script.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Requies Salary Advance</title>

</head>
<div class="container-fluid" style="margin-top:30px !important;">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-9">
                <h1>Salary Advance</h1>
            </div>
        </div>
        <div class="table-responsive">
            <table id="tblUser" class="row-border hover order-column">
                <thead>
                    <tr>
                        <th>Salary Number</th>
                        <th>Amount</th>
                        <th>Requested Date</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectQuery = "select * from salary_advance where employeeId  = $employeeID ";
                    $squery = mysqli_query($con, $selectQuery);
                    while (($result = mysqli_fetch_assoc($squery))) {
                    ?>
                        <tr>
                            <td><?php echo $result['salaryNo']; ?></td>
                            <td><?php echo $result['amount']; ?></td>
                            <td><?php echo $result['date']; ?></td>
                            <td><?php echo $result['status']; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
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
        $(document).ready(function() {
            var table = $('#tblUser').DataTable();

            $('#tblUser tbody').on('mouseenter', 'td', function() {
                var colIdx = table.cell(this).index().column;

                $(table.cells().nodes()).removeClass('highlight');
                $(table.column(colIdx).nodes()).addClass('highlight');
            });
        });
    </script>

    <div class="row" style="padding-left: 30%; padding-top: 70px; ">
        <div class="col-lg-7" style="padding: 10%;">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Request Advance</h4>
                </div>
                <h6>Maximum Advance Amount - <?php echo $maxAmt; ?> </h6>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                        <div class="form-group">
                            <label class="form-control-label">Enter Advance Amount Code</label>
                            <input type="number" name="amount" class="form-control" max="<?php echo $maxAmt; ?>" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnRegister" name="submit" value="Request Advance">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>