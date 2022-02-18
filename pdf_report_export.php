<!DOCTYPE html>
<html>

<head>
    <title>PDF download</title>
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
    <p>All the pdf are generated in the folder itself folder name is PDF_REPORTS</p>

</body>

</html>

<?php

include('library/tcpdf.php');

require_once "config.php";
class MYPDF extends TCPDF
{
    public function Header()
    {
        if ($this->page > 1) {
            return;
        }
        $image_file = 'images/iitp.png';
        $this->Image($image_file, 3, 5, 20, '', 'PNG', '', 'N', false, 300, 'L', false, false, 0, false, false, false);

        $image_file = 'images/iitp_header.png';
        $this->Image($image_file, 30, 5, 100, '', 'PNG', '', 'N', false, 300, 'R', false, false, 0, false, false, false);
    }
}


class GoodZipArchive extends ZipArchive
{
    //@author Nicolas Heimann
    public function __construct($a = false, $b = false)
    {
        $this->create_func($a, $b);
    }

    public function create_func($input_folder = false, $output_zip_file = false)
    {
        if ($input_folder !== false && $output_zip_file !== false) {
            $res = $this->open($output_zip_file, ZipArchive::CREATE);
            if ($res === TRUE) {
                $this->addDir($input_folder, basename($input_folder));
                $this->close();
            } else {
                echo 'Could not create a zip archive. Contact Admin.';
            }
        }
    }

    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name)
    {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive 
    private function addDirDo($location, $name)
    {
        $name .= '/';
        $location .= '/';
        // Read all Files in Dir
        $dir = opendir($location);
        while ($file = readdir($dir)) {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype($location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalDate = trim($_POST["fname"]);
    $fname = date("Y-m-d", strtotime($originalDate));
    $originalDate1 = trim($_POST["lname"]);
    $lname = date("Y-m-d", strtotime($originalDate1));
    $max_leaves = trim($_POST["max_leaves"]);
    $charges = trim($_POST["charges"]);
}

    $query = " select t1.id,t1.name,t1.rollno,t1.prog,t1.department,t1.yjoin,t1.email,t1.aemail,t1.mobile,t1.guardian_contact,t1.hostel_name,t1.hostel_block,t1.hostel_full_room,t1.account_holder_name,t1.account_number,t1.account_ifsc,sum( datediff(least(to_date, '$lname'),greatest(from_date, '$fname')) + 1) as leavescnt
        from mess_student_hostel_hostelinfo as t1
        left join mess_student_leaves as t2
        on t1.rollno=t2.stud_roll
        where from_date <= least(to_date, '$lname') and to_date >= greatest(from_date, '$fname') 
        group by t1.rollno
               ";
$file_name = "summary.csv";


$delimiter = ",";
$f = fopen($file_name, 'a');

$fields = array('SL', 'Name', 'ROLL NO', 'program', 'department', 'yjoin', 'email', 'aemail', 'mobile', 'guardian contact', 'hostel name', 'hostel block', 'Hostel Room', 'Account Holder Name', 'Account Number', 'Account Ifsc', 'Total leaves', 'Max leaves allowed', 'Valid leaves count', 'Mess charges/day', 'Total refund');

fputcsv($f, $fields, $delimiter);


$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $lineData = array($row["id"], $row["name"], $row["rollno"], $row["prog"], $row["department"], $row["yjoin"], $row["email"], $row["aemail"], $row["mobile"], $row["guardian_contact"], $row["hostel_name"], $row["hostel_block"], $row["hostel_full_room"], $row["account_holder_name"], '#' . $row["account_number"], $row["account_ifsc"], max(0, $row["leavescnt"]), $max_leaves, min($max_leaves, $row["leavescnt"]), $charges, $charges * min($max_leaves, $row["leavescnt"]));
    fputcsv($f, $lineData, $delimiter);
}
fseek($f, 0);


$file = fopen($file_name, 'r');
$row = array_fill(0, 124, 0);

//here goes the pdfmaking
$row = fgetcsv($file);

$folder = 'C:/xampp/htdocs/mess_rebate/';
$folder1 = $folder . 'PDF_REPORTS';
if (!file_exists($folder1)) {
    mkdir($folder1, 0777, true);
}

while (($row = fgetcsv($file)) !== FALSE) {
    $pdf = new TCPDF('P', 'mm', 'A4');

    //remove default header and footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 2, 10, $keepmargins = false);

    //add page
    $pdf->AddPage();

    //add content
    //table
    $pdf->SetFont('Helvetica', '', 14);
    $pdf->Cell(190, 10, "INDIAN INSTITUTE OF TECHNOLOGY PATNA", 0, 1, 'C');

    $pdf->SetFont('freesans', '', 14);
    $pdf->Cell(190, 10, "भारतीय प्रौद्योगिकी संस्थान पटना", 0, 1, 'C');

    $pdf->Ln(4);

    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(190, 5, "I confirm that the following amount has been credited to the below mentioned Bank Account Number", 0, 1);
    $pdf->Ln();
    $tbl = <<<EOD
    <table border="1" cellpadding="1" cellspacing="0" nobr="true">
        <tr>
            <th colspan="2" align="center">DETAILS</th>
        </tr>
        <tr>
            <td>Roll Number</td>
            <td>$row[2]</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>$row[1]</td>
        </tr>
        <tr>
            <td>Account Number</td>
            <td>$row[14]</td>
        </tr>
        <tr>
            <td>IFSC Code</td>
            <td>$row[15]</td>
        </tr>
        <tr>
            <td>Total Leaves</td>
            <td>$row[16]</td>
        </tr>
        <tr>
            <td>Max Leaves Allowed</td>
            <td>$row[17]</td>
        </tr>
        <tr>
            <td>Valid Leaves</td>
            <td>$row[18]</td>
        </tr>
        <tr>
            <td>Mess Charges Per Day</td>
            <td>Rs. $row[19]</td>
        </tr>
        <tr>
            <td>Total Rebate</td>
            <td>Rs. $row[20]</td>
        </tr>
    </table>
    EOD;

    $pdf->writeHTML($tbl, true, false, false, false, '');

    $pdf->Ln(20);

    $pdf->Cell(190, 5, "Caretaker Sign.                                          Warden Sign.                                                Student Sign.", 0, 1);
    $pdf->Ln(10);

    $pdf->Cell(190, 5, "----------------------------------------------------------------------------------------------------------------------------------", 0, 1, 'C');
    $pdf->SetFont('Helvetica', '', 14);
    $pdf->Cell(190, 10, "INDIAN INSTITUTE OF TECHNOLOGY PATNA", 0, 1, 'C');

    $pdf->SetFont('freesans', '', 14);
    $pdf->Cell(190, 10, "भारतीय प्रौद्योगिकी संस्थान पटना", 0, 1, 'C');

    $pdf->Ln(4);

    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Cell(190, 5, "I confirm that the following amount has been credited to the below mentioned Bank Account Number", 0, 1);
    $pdf->Ln();
    $tbl = <<<EOD
    <table border="1" cellpadding="1" cellspacing="0" nobr="true">
        <tr>
            <th colspan="2" align="center">DETAILS</th>
        </tr>
        <tr>
            <td>Roll Number</td>
            <td>$row[2]</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>$row[1]</td>
        </tr>
        <tr>
            <td>Account Number</td>
            <td>$row[14]</td>
        </tr>
        <tr>
            <td>IFSC Code</td>
            <td>$row[15]</td>
        </tr>
        <tr>
            <td>Total Leaves</td>
            <td>$row[16]</td>
        </tr>
        <tr>
            <td>Max Leaves Allowed</td>
            <td>$row[17]</td>
        </tr>
        <tr>
            <td>Valid Leaves</td>
            <td>$row[18]</td>
        </tr>
        <tr>
            <td>Mess Charges Per Day</td>
            <td>Rs. $row[19]</td>
        </tr>
        <tr>
            <td>Total Rebate</td>
            <td>Rs. $row[20]</td>
        </tr>
    </table>
    EOD;

    $pdf->writeHTML($tbl, true, false, false, false, '');

    $pdf->Ln(20);

    $pdf->Cell(190, 5, "Caretaker Sign.                                          Warden Sign.                                                Student Sign.", 0, 1);



    $mess_name = $row[10];
    $folder2 = $folder1 . "/" . $mess_name;
    if (!file_exists($folder2)) {
        mkdir($folder2, 0777, true);
    }

    $name_of_file = $row[2];
    $filename = 'PDF_report_' . $name_of_file;
    $fileNL = $folder2 . "/" . $filename;
    $pdf->Output($fileNL . '.pdf', 'F');
}



$path = $folder . $file_name;
unlink($path);

fclose($file);

// $downloaded = WASTE;
// if (!file_exists($downloaded)) {
//     mkdir($waste, 0777, true);
// }
$out = $folder1 . ".zip";

new GoodZipArchive($folder1, $out);

// header('Content-Type: application/zip');
// header("Content-Disposition: attachment; filename=".$phd_department.".zip");
// unlink(WASTE.$phd_department.".zip");


?>