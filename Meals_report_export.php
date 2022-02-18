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
        $hostel_name = trim($_POST["hostel_name"]);
    }
    $filename = $hostel_name . '_meals_report.csv';
    header("Content-Disposition: attachment; filename=$filename ");
    $output = fopen("php://output", "w");
    fputcsv($output, array('Date', 'Breakfast', 'Lunch', 'Snacks', 'Dinner'));



    $query = "SELECT added_on,
                sum(case when meal_type_id = '1' then 1 else 0 end) AS Breakfast,
                sum(case when meal_type_id = '2' then 1 else 0 end) AS Lunch ,
                sum(case when meal_type_id = '3' then 1 else 0 end) AS Snacks,
                sum(case when meal_type_id = '4' then 1 else 0 end) AS Dinner 
            FROM mess_meal_info 
            where hostel_id = '1' and added_on BETWEEN '$fname' and '$lname' 
            GROUP BY date(added_on)";


    if (!mysqli_query($conn, $query)) {
        die("Error description: " . mysqli_error($conn));
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $date = date_create($row["added_on"]);
        // $date = $row["added_on"];
        $date = date_format($date, 'd-M-Y \, D');
        fputcsv($output, array($date, $row["Breakfast"], $row["Lunch"], $row["Snacks"], $row["Dinner"]));
    }
    fclose($output);
}
