<?php include '../dbconn.php';
include '../Headers/companyHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];

if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $companyId = $companyID;
    $status = "A";

    $query =
        "INSERT INTO company_wise_categories(salaryCategoryCode,companyId,status)
	     VALUES('$code''$companyId','$status')";

    if (mysqli_query($con, $query)) {
        echo "<script type='text/javascript'>alert('Code Added Sucessfully');location.href='linkSalaryCategories.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('Try Again');location.href='linkSalaryCategories.php'</script>";
    }
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
                    <h1>Current Salary Catrgories</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tblUser">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Category Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery = "select * from salary_category inner join company_wise_categories on company_wise_categories.salaryCategoryCode = salary_category.code where company_wise_categories.companyId  = $companyID ";
                        $squery = mysqli_query($con, $selectQuery);
                        while (($result = mysqli_fetch_assoc($squery))) {
                        ?>
                            <tr>
                                <td><?php echo $result['code']; ?></td>
                                <td><?php echo $result['description']; ?></td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                </form>
            </div>


        </div>



        <div class="row" style="padding-left: 30%; padding-top: 70px; ">
            <div class="col-lg-7" style="padding: 10%;">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Link New Salery Category</h4>
                    </div>

                    <form method="post" enctype="multipart/form-data">
                        <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                            <label class="form-control-label">Select Salary Category</label>
                            <div>
                                <?php
                                $queryX = "select distinct code from salary_category inner join company_wise_categories on company_wise_categories.salaryCategoryCode = salary_category.code where company_wise_categories.companyId <> $companyID";
                                $result = $con->query($queryX);
                                if ($result->num_rows > 0) {
                                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                }
                                ?>
                                <select name="code" required>
                                    <option>Select Salary Category</option>
                                    <?php
                                    foreach ($options as $option) {
                                    ?>
                                        <option><?php echo $option['code']; ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div><br>


                            <div class="form-group">
                                <input type="submit" class="btnRegister" name="submit" value="Add Salary Category">
                            </div>
                        </div>
                    </form>

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
    </script>

</body>

</html>