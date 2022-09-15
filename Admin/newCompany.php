<?php include '../dbconn.php';
include '../Headers/adminHeader.php';
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 1) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];

if (isset($_POST['companyName'])) {
    $companyName = $_POST['companyName'];
    $salaryDate = $_POST['salaryDate'];
    $BRI = $_POST['BRI'];
    $status = $_POST['status'];

    $password = MD5($_POST['password']);
    $userName = $_POST['userName'];
    $userType = "2";

    $sql1 = "SELECT * FROM user WHERE userName='$userName'";
    $res1 = mysqli_query($con, $sql1);

    $query =
        "INSERT INTO user(userName,password,userType)
	     VALUES('$userName','$password','$userType')";

    if (mysqli_num_rows($res1) > 0) {
        echo " <script type='text/javascript'>alert('Username Already Registerd');location.href='newCompany.php'</script>";
    } else {
        $query = mysqli_query($con, $query);
        $userID = mysqli_insert_id($con);
        if ($companyName <> "") {
            $query1 = "INSERT INTO company (companyName,salaryDate,userId,BRI,status)
        	           VALUES('$companyName','$salaryDate','$userID','$BRI','$status')";
            if (mysqli_query($con, $query1)) {
                $_SESSION['companyId'] = mysqli_insert_id($con);
                echo " <script type='text/javascript'>alert('Company Added Succesfully');location.href='../Excel/excelUserUpload.php'</script>";
            } else {
                echo " <script type='text/javascript'>alert('Error In company Details');location.href='newCompany.php'</script>";
            }
        } else {
        }
        echo " <script type='text/javascript'>alert('User Added Sucessfully');location.href='newCompany.php'</script>";
    }
}
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylex.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="ajax-script.js"></script>
    <title>Add New User</title>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

</head>

<div class="row" style="padding-left: 30%; padding-top: 70px; ">
    <div class="col-lg-7" style="padding: 10%;">
        <div class="card">
            <div class="card-header text-center">
                <h4>Add New Company</h4>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                    <div class="form-group">
                        <label class="form-control-label">Enter company Name</label>
                        <input type="text" name="companyName" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter UserName for Company</label>
                        <input type="text" name="userName" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter salary Day</label>
                        <input type="date" name="salaryDate" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter BRI</label>
                        <input type="number" name="BRI" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Select Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Non-Active">Non-Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Password For User</label>
                        <input type="password" name="password" class="form-control" id="password" required />
                        <input type="checkbox" onclick="myFunction()">Show Password
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btnRegister" name="submit" value="Add Company">
                    </div>
                    
                </div>
            </form>

        </div>
    </div>
</div>