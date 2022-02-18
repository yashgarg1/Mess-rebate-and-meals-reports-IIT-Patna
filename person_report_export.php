<?php
//export.php  
if (isset($_POST["export"])) {
     require_once "config.php";

     header('Content-Type: text/csv; charset=utf-8');

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $originalDate = trim($_POST["fname"]);
          $fname = date("Y-m-d", strtotime($originalDate));
          // echo $fname;
          $originalDate1 = trim($_POST["lname"]);
          $lname = date("Y-m-d", strtotime($originalDate1));
          // echo $lname;
          $person_roll = trim($_POST["p_roll"]);
     }
     $proll = $person_roll . '.csv';
     header("Content-Disposition: attachment; filename=$proll ");
     $output = fopen("php://output", "w");
     fputcsv($output, array('SL', 'Roll', 'Name', 'Hostel ID', 'Hostel Name', 'Reason', 'From Date', 'To Date', 'leaves'));



     // $query = " select * 
     //           from mess_student_leaves
     //           where stud_roll='$person_roll' and to_date <= '$lname' and from_date >= '$fname'";

     $query = "select id,stud_roll,stud_name,hostel_id,hostel_name,reason,from_date,to_date,
               datediff(least(to_date, '$lname'),greatest(from_date, '$fname')) + 1
               from mess_student_leaves
               where stud_roll='$person_roll' and from_date <= least(to_date, '$lname') and to_date >= greatest(from_date, '$fname')";

     if (!mysqli_query($conn, $query)) {
          die("Error description: " . mysqli_error($conn));
     }

     $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result)) {
          fputcsv($output, $row);
     }
     fclose($output);
}
