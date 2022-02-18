<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalDate = trim($_POST["fname"]);
    $fname = date("Y-m-d", strtotime($originalDate));
    $originalDate1 = trim($_POST["lname"]);
    $lname = date("Y-m-d", strtotime($originalDate1));
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Meals report download</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style_header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <script src="script_header.js"></script>
    <div class="tab">
        <button class="tablinks" onClick="document.location.href='welcome.php'">Users</button>
        <button class="tablinks" onClick="document.location.href='welcome.php'">PDF Receipt</button>
        <button class="tablinks" onClick="document.location.href='welcome.php'">Reports</button>
        <button class="tablinks" onClick="document.location.href='welcome.php'">Meals Reports</button>
    </div>

    <div class="container" style="width:900px;">
        <h2 align="center">Exporting all the data in CSV file</h2>
        <h3 align="center">Meals report</h3>
        <br />


    </div>
    <hr>
    <?php
    $query = "select distinct(name) from mess_hostels";


    if (!mysqli_query($conn, $query)) {
        die("Error description: " . mysqli_error($conn));
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $hostel_name = $row['name'];
    ?>
        <form method="post" action="Meals_report_export.php" align="center">
            <input type="hidden" name="fname" value="<?php echo $fname ?>">
            <input type="hidden" name="lname" value="<?php echo $lname ?>">
            <input type="hidden" name="hostel_name" value="<?php echo $hostel_name ?>">
            <input type="submit" name="export" value=<?php echo $hostel_name ?> class="btn btn-success" />
        </form>
        <br />
    <?php

    }
    ?>
    <p>
        <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
        <a href="index.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>

</html>