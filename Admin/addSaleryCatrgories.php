<?php include '../dbconn.php';
include '../Headers/adminHeader.php';

session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 1) {
    header("location: ../index.php");
    exit();
}

if (isset($_POST['code'])) {
    $code = $_POST['code'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $common = $_POST['common'];
    $commonValue = $_POST['commonValue'];
    $status = $_POST['status'];

    $sql1 = "SELECT * FROM salary_category WHERE code='$code'";
    $res1 = mysqli_query($con, $sql1);

    $query =
        "INSERT INTO salary_category(code,description,type,common,commonValue,status)
	     VALUES('$code','$description','$type','$common','$commonValue','$status')";

    if (mysqli_num_rows($res1) > 0) {
        echo "<script type='text/javascript'>alert('Existing Code!');location.href='addSaleryCategories.php'</script>";
    } else {
        $query = mysqli_query($con, $query);
        $userId = mysqli_insert_id($con);
        echo "<script type='text/javascript'>alert('Code Added Sucessfully');location.href='addSaleryCategories.php'</script>";
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

</head>

<div class="row" style="padding-left: 30%; padding-top: 70px; ">
    <div class="col-lg-7" style="padding: 10%;">
        <div class="card">
            <div class="card-header text-center">
                <h4>Add New Salery Category</h4>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="form-input py-2" style="padding-left: 20px;  border-radius: 5px;background-color: #f2f2f2;padding: 20px;">
                    <div class="form-group">
                        <label class="form-control-label">Enter Salary Code</label>
                        <input type="text" name="code" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter description</label>
                        <input type="text" name="description" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter type</label>
                        <input type="text" name="type" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter common</label>
                        <input type="text" name="common" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Enter common value</label>
                        <input type="text" name="commonValue" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Select Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Non-Active">Non-Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btnRegister" name="submit" value="Add Salary Category">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>