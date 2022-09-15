<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>PayRoll System</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #333;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {
                display: none;
            }

            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {
                position: relative;
            }

            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }

            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <div class="topnav" id="myTopnav">
        <a href="../LandingPagers/companyPanel.php">Go to Homepage</a>
        <a href="../Company/changeDet.php">Change Company Details</a>
        <a href="../Company/changePwd.php">Change Company Password</a>
        <a href="../Company/newUser.php">Create New Employees</a>
        <a href="../Company/viewEmployees.php">View And Modify Employees</a>
        <a href="../Company/linkSalaryCategories.php">Link Salary Categories</a>
        <a href="../Company/employeeSalaries.php">Salary Initiation</a>
        <a href="../Company/submitEmployees.php">Approve Employees</a>
        <a href="../Company/viewAdvance.php">Approve Advance</a>
        <a href="../Company/payAdvance.php">Advance Payment</a>
        <a href="../Company/employeeDues.php">Salary Payments</a>
        <a href="../logout.php">Log Out</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>

</body>

</html>