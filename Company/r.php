<?php
if (isset($_POST["submit"])) {


foreach ($spreadSheetAry as $key => $value) {

$error = [];

$sql1 = "SELECT userName FROM user WHERE userName='$value[12]'";
$res1 = mysqli_query($con, $sql1);

$sql2 = "SELECT email FROM employee WHERE email='$value[7]'";
$res2 = mysqli_query($con, $sql2);

$sql3 = "SELECT contactNo FROM employee WHERE contactNo = '$value[5]'";
$res3 = mysqli_query($con, $sql3);

$sql4 = "SELECT nic FROM employee WHERE nic='$value[3]'";
$res4 = mysqli_query($con, $sql4);

if (!empty($res1) && mysqli_num_rows($res1) > 0) {
$suggesedPassword = implode("-", mysqli_fetch_assoc($res1)) ;
$error['0'] = "Duplicate Username - " . $suggesedPassword . " | Suggesed Password - ". $suggesedPassword . substr($value[3],0,2);
}

if (!empty($res2) && mysqli_num_rows($res2) > 0) {
$error['1'] = "Duplicate Emails - " . implode("-", mysqli_fetch_assoc($res2)) . " ";
}

if (!empty($res3) && mysqli_num_rows($res3) > 0) {
$error['2'] = "Duplicate Contacts - " . implode("-", mysqli_fetch_assoc($res3)) . " ";
}

if (!empty($res4) && mysqli_num_rows($res4) > 0) {
$error['3'] = "Duplicate NIC - " . implode("-", mysqli_fetch_assoc($res4)) . " ";
}


$errors = implode(",",$error);
if(!empty($error)) {

$sql = "INSERT INTO errors (a,b,c,d,e,f,g,h,i,j,k,l,m,n,errors) VALUES ('$value[0]','$value[1]','$value[2]','$value[3]',
'$value[4]','$value[5]','$value[6]','$value[7]','$value[8]','$value[9]','$value[10]','$value[11]','$value[12]','$value[13]','$errors')";
if (mysqli_query($con, $sql)) {
} else {
}


} else {
if (!empty($value[13])) {
$password = md5($value[13]);
$query = "INSERT INTO user(userName,password,userType) VALUES('$value[12]','$password','3')";
// echo 'query === '.$query; exit;
$query = mysqli_query($con, $query);
$userId = mysqli_insert_id($con);

if (!empty($value[0])) {

$joinDate = date('Y-m-d', strtotime($value[1]));
$dob = date('Y-m-d', strtotime($value[4]));
$query1 = "INSERT INTO employee (employeeName,joinDate,address,nic,dob,cantactNo,jobTitle,userId,email,companyId,status)
VALUES('$value[0]','$joinDate','$value[2]','$value[3]','$dob','$value[5]','$value[6]','$userId','$value[6]','1','I')";

if (mysqli_query($con, $query1)) {
$employeeId = mysqli_insert_id($con);

if (!empty($value[0])) {
$initiatedDate = date('Y-m-d', strtotime($value[11]));
$query2 = "INSERT INTO bankinfo (bankCode,branchCode,accoundHolder,employeeId,status,initiatedDate)
VALUES('$value[8]','$value[9]','$value[10]', '$employeeId', 'I','$initiatedDate')";

if (mysqli_query($con, $query2)) {
echo "<script type='text/javascript'>
    alert('Data Added Successfully');
</script>";
} else {
echo "<script type='text/javascript'>
    alert('Error In Bank Details');
</script>";
}
} else {
}
} else {
echo "<script type='text/javascript'>
    alert('Error In Employee Details');
</script>";
}
} else {

$type = "success";
$message = "Excel Data Imported into the Database";

}
}
}


}






} else {
$type = "error";
$message = "Invalid File Type. Upload Excel File.";
}

$sqlx = "SELECT * FROM errors";
$resx = mysqli_query($con, $sqlx);

if (mysqli_num_rows($resx) > 0) {
echo "<script type='text/javascript'>
    alert('Errors Found');
    location.href = 'export.php'
</script>";
}



?>