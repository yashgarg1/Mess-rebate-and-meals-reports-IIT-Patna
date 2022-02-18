<?php
require_once "config.php";

$query = "SELECT distinct(stud_name),stud_roll FROM mess_student_leaves";
$result = mysqli_query($conn, $query);
if (!mysqli_query($conn, $query)) {
     echo ("Error description: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
     <title>List Of All The Staff Members</title>
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
          <h2 align="center">Showing names of all the students</h2>
          <br />
          <br />
          <div class="table-responsive" id="employee_table">
               <table class="table table-bordered">
                    <tr>
                         <th width="25%">NAME</th>
                         <th width="25%">ROLL NO.</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                         <tr>
                              <td><?php echo $row["stud_name"]; ?></td>
                              <td><?php echo $row["stud_roll"]; ?></td>
                         </tr>
                    <?php
                    }
                    ?>
               </table>
          </div>
     </div>
     <p>
          <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
          <a href="index.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
     </p>
</body>

</html>