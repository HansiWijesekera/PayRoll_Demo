<?php
session_start();
if($_SESSION['userType']=="1"){
	header('location:LandingPagers/adminPanel.php');
}else if($_SESSION['userType']=="2"){
	header('location:LandingPagers/companyPanel.php');
} else if ($_SESSION['userType'] == "3") {
	header('location:LandingPagers/userPanel.php');
}else if ($_SESSION['userType'] == "4") {
	echo "<script type='text/javascript'>alert('Expired User - Please Contact Admin');location.href='index.php'</script>";
}