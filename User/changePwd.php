<?php include '../dbconn.php';
include '../Headers/userHeader.php';
session_start();

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 3) {
    header("location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];
$employeeID = $_SESSION['employeeId'];



if (count($_POST) > 0) {
    $result = mysqli_query($con, "SELECT * from user WHERE userID= $userID");
    $row = mysqli_fetch_array($result);
    if (MD5($_POST["currentPassword"]) == $row["password"]) {
        mysqli_query($con, "UPDATE user set password = '" .  MD5($_POST["newPassword"]) . "' WHERE userId= $userID");
        echo " <script type='text/javascript'>alert('Password Changed');location.href='../index.php'</script>";
    } else
        echo " <script type='text/javascript'>alert('Current Password Incorrect');location.href='changePwd.php'</script>";
}
?>
<html>

<head>
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script>
        function validatePassword() {
            var currentPassword, newPassword, confirmPassword, output = true;

            currentPassword = document.frmChange.currentPassword;
            newPassword = document.frmChange.newPassword;
            confirmPassword = document.frmChange.confirmPassword;

            if (!currentPassword.value) {
                currentPassword.focus();
                document.getElementById("currentPassword").innerHTML = "required";
                output = false;
            } else if (!newPassword.value) {
                newPassword.focus();
                document.getElementById("newPassword").innerHTML = "required";
                output = false;
            } else if (!confirmPassword.value) {
                confirmPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "required";
                output = false;
            }
            if (newPassword.value != confirmPassword.value) {
                newPassword.value = "";
                confirmPassword.value = "";
                newPassword.focus();
                document.getElementById("confirmPassword").innerHTML = "Password didn't match";
                output = false;
            }
            return output;
        }
    </script>
</head>

<body>
    <form name="frmChange" method="post" action="" onSubmit="return validatePassword()">
        <div style="width: 500px;">
            <div class="message"><?php if (isset($message)) {
                                        echo $message;
                                    } ?></div>
            <table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
                <tr class="tableheader">
                    <td colspan="2">Change Password</td>
                </tr>
                <tr>
                    <td width="40%"><label>Current Password</label></td>
                    <td width="60%"><input type="password" name="currentPassword" class="txtField" /><span id="currentPassword" class="required"></span></td>
                </tr>
                <tr>
                    <td><label>New Password</label></td>
                    <td><input type="password" name="newPassword" class="txtField" /><span id="newPassword" class="required"></span></td>
                </tr>
                <td><label>Confirm Password</label></td>
                <td><input type="password" name="confirmPassword" class="txtField" /><span id="confirmPassword" class="required"></span></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Submit" class="btnSubmit"></td>
                </tr>
            </table>
        </div>
    </form>
</body>

</html>