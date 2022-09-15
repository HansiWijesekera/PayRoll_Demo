<?php include '../dbconn.php';
include '../Headers/companyHeader.php';

session_start();
if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 2) {
    header("location: ../index.php");
    exit();
}

$companyID = $_SESSION['companyId'];

if (isset($_POST['employeeName'])) {

    $employeeName = $_POST['employeeName'];
    $joinDate = $_POST['joinDate'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $dob = $_POST['dob'];
    $cantactNo = $_POST['cantactNo'];
    $jobTitle = $_POST['jobTitle'];
    $email = $_POST['email'];

    $status = $_POST['status'];

    $bankCode = $_POST['bankCode'];
    $branchCode = $_POST['branchCode'];
    $status1 = $_POST['status1'];
    $accoundHolder = $_POST['accoundHolder'];
    $initiatedDate = $_POST['initiatedDate'];

    $password = MD5($_POST['password']);
    $userName = $_POST['userName'];
    $userType = "3";
    $companyId = '$companyID';

    $sql = "SELECT * FROM employee WHERE email='$email'";
    $res = mysqli_query($con, $sql);

    $sql1 = "SELECT * FROM user WHERE userName='$userName'";
    $res1 = mysqli_query($con, $sql1);

    $query =
        "INSERT INTO user(userName,password,userType)
	    VALUES('$userName','$password','$userType')";


    if (mysqli_num_rows($res1) > 0) {
        echo " <script type='text/javascript'>alert('Username Already Taken');location.href='newUser.php'</script>";
    } else {
        if (mysqli_num_rows($res) > 0) {
            echo " <script type='text/javascript'>alert('Email Already Registerd Please enter another Email');location.href='newUser.php'</script>";
        } else {
            $query = mysqli_query($con, $query);
            $userId = mysqli_insert_id($con);
            if ($employeeName <> "") {
                $query1 = "INSERT INTO employee (employeeName,joinDate,address,nic,dob,cantactNo,jobTitle,userId,email,companyId,status)
        	           VALUES('$employeeName','$joinDate','$address','$nic','$dob','$cantactNo','$jobTitle','$userId','$email','$companyId','$status')";

                if (mysqli_query($con, $query1)) {
                    $employeeId = mysqli_insert_id($con);
                    if ($password <> "") {
                        $query2 =
                            "INSERT INTO bankinfo (bankCode,branchCode,accoundHolder,employeeId,status,initiatedDate)
	                         VALUES('$bankCode','$branchCode','$accoundHolder','$employeeId','$status1','$initiatedDate')";

                        if (mysqli_query($con, $query2)) {
                        } else {
                            echo "<script type='text/javascript'>alert('Error In Bank Details');location.href='AddBankDet.php'</script>";
                        }
                    } else {
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Error In Employee Details');location.href='AddBankDet.php'</script>";
                }
            } else {
            }

            echo " <script type='text/javascript'>alert('User Added Sucessfully');location.href='AddBankDet.php'</script>";
        }
        $query = mysqli_query($con, $query);
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
                <h4>Add New User</h4>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                    <div class="form-group">
                        <label class="form-control-label">Enter Emoplyee Name</label>
                        <input type="text" name="employeeName" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Emoplyee UserName</label>
                        <input type="text" name="userName" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Joined Date</label>
                        <input type="date" name="joinDate" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Address</label>
                        <input type="text" name="address" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter NIC</label>
                        <input type="text" name="nic" class="form-control" minlength="10" maxlength="12" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Date Of Birth</label>
                        <input type="date" name="dob" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Contact No</label>
                        <input type="tel" name="cantactNo" maxlength="10" minlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Job Title</label>
                        <input type="text" name="jobTitle" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Email</label>
                        <input type="email" name="email" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Select Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="A">Active</option>
                            <option value="E">Expired</option>
                            <option value="I">Initiated</option>
                            <option value="R">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Bank Code</label>
                        <input type="number" name="bankCode" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Branch code</label>
                        <input type="number" name="branchCode" class="form-control" minlength="4" maxlength="4" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Account Holder</label>
                        <input type="text" name="accoundHolder" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Select Status</label>
                        <select id="status1" name="status1" class="form-control">
                            <option value="A">Active</option>
                            <option value="E">Expired</option>
                            <option value="I">Initiated</option>
                            <option value="R">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter initiated Date</label>
                        <input type="date" name="initiatedDate" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter Password For User</label>
                        <input type="password" name="password" class="form-control" id="password" required />
                        <input type="checkbox" onclick="myFunction()">Show Password
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btnRegister" name="submit" value="Add User">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>