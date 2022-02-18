<?php
//summary.php  
if (isset($_POST["export"])) {
     require_once "config.php";

     header('Content-Type: text/csv; charset=utf-8');

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $originalDate = trim($_POST["fname"]);
          $fname = date("Y-m-d", strtotime($originalDate));
          $originalDate1 = trim($_POST["lname"]);
          $lname = date("Y-m-d", strtotime($originalDate1));
          $max_leaves = trim($_POST["max_leaves"]);
          $charges = trim($_POST["charges"]);
     }
     $proll = 'summary.csv';
     header("Content-Disposition: attachment; filename=$proll ");
     $output = fopen("php://output", "w");
     fputcsv($output, array('SL', 'Name', 'ROLL NO', 'program', 'department', 'yjoin', 'email', 'aemail', 'mobile', 'guardian contact', 'hostel name', 'hostel block', 'Hostel Room', 'Account Holder Name', 'Account Number', 'Account Ifsc', 'Total leaves', 'Max leaves allowed', 'Valid leaves count', 'Mess charges/day', 'Total refund'));



     $query = " select t1.id,t1.name,t1.rollno,t1.prog,t1.department,t1.yjoin,t1.email,t1.aemail,t1.mobile,t1.guardian_contact,t1.hostel_name,t1.hostel_block,t1.hostel_full_room,t1.account_holder_name,t1.account_number,t1.account_ifsc,sum( datediff(least(to_date, '$lname'),greatest(from_date, '$fname')) + 1) as leavescnt
               from mess_student_hostel_hostelinfo as t1
               left join mess_student_leaves as t2
               on t1.rollno=t2.stud_roll
               where from_date <= least(to_date, '$lname') and to_date >= greatest(from_date, '$fname') 
               group by t1.rollno
               
               ";

     if (!mysqli_query($conn, $query)) {
          die("Error description: " . mysqli_error($conn));
     }

     $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result)) {
          fputcsv($output, array($row["id"], $row["name"], $row["rollno"], $row["prog"], $row["department"], $row["yjoin"], $row["email"], $row["aemail"], $row["mobile"], $row["guardian_contact"], $row["hostel_name"], $row["hostel_block"], $row["hostel_full_room"], $row["account_holder_name"], '#' . $row["account_number"], $row["account_ifsc"], max(0, $row["leavescnt"]), $max_leaves, min($max_leaves, $row["leavescnt"]), $charges, $charges * min($max_leaves, $row["leavescnt"])));
     }
     fclose($output);
}
