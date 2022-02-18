<?php

// Connect to database 
require_once "config.php";

$query = "SELECT distinct(stud_name) FROM mess_student_leaves";
if (!mysqli_query($conn, $query)) {
    echo ("Error description: " . mysqli_error($conn));
} else {
    $all_categories = mysqli_query($conn, $query);
}

?>





<!DOCTYPE html>
<html lang="en">

<head>




    <meta charset="UTF-8">
    <title>Welcome</title>

    <script>
        function ddlselect() {
            var d = document.getElementById("ddselect");
            var displaytext = d.options[d.selectedIndex].text;
            document.getElementById("txtvalue").value = displaytext;
        }

        function ddlselect1() {

            var d = document.getElementById("ddselect1");
            var displaytext = d.options[d.selectedIndex].text;
            document.getElementById("txtvalue1").value = displaytext;

        }

        function ddlselect2() {

            var d = document.getElementById("ddselect2");
            var displaytext = d.options[d.selectedIndex].text;
            document.getElementById("txtvalue2").value = displaytext;

        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #3e8e41;
        }

        #myInput {
            box-sizing: border-box;
            background-image: url('searchicon.png');
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 45px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        #myInput:focus {
            outline: 3px solid #ddd;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style_header.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function checkFilled() {
            var interests = document.getElementsByClassName("form-interests-input-field");
            for (var i = 0; i < interests.length; i++) {
                if (interests[i].value == '') {
                    // interests[i].style.backgroundColor = 'red';
                } else {
                    interests[i].style.backgroundColor = 'BlanchedAlmond';
                }
            }
        }
    </script>
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 950px;
            padding: 10px;
            border: 1px solid gray;
            background: #DCDCDC;
            margin: 0;
        }

        .head_reg {
            width: 950px;
            height: 100px;
            padding: 12px;
            border: 1px solid gray;
            margin: auto;
            background: #428BCA;
            font-family: "Times New Roman", Times, serif;
        }

        label {
            /* Other styling... */
            text-align: right;
            clear: both;
            float: left;
            margin-right: 15px;
            color: #484848;
            font-weight: bold;
        }
    </style>
</head>



<body>

    <center>
        <script src="script_header.js"></script>

        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'Users')">Users</button>
            <button class="tablinks" onclick="openCity(event, 'PDF_Receipt')">PDF Receipt</button>
            <button class="tablinks" onclick="openCity(event, 'Reports')">Reports</button>
            <button class="tablinks" onclick="openCity(event, 'Meals')">Meals Reports</button>
        </div>

        <!-- list of USERS TAB -->
        <div id="Users" class="tabcontent">
            <br>
            <h3>Users</h3>
            <br>
            <form action="ListUsers.php" method="post">
                <input type="submit" value="Show List Of Users" class="btn btn-info">
            </form>
        </div>

        <!-- PDF receipts TAB -->
        <div id="PDF_Receipt" class="tabcontent">
            <div class="container py-1">
                <div class="row">
                    <div class="col-md-10 offset-md-1">

                        <div class="card">
                            <div class="card-header">
                                <h4><i class='fa fa-edit'></i>Summary report </h4>
                            </div>
                            <br>
                            <form action="pdf_receipt.php" method="post">

                                <label>Start Date: </label>
                                <input type="date" id="fname" name="fname" data-date-format="DD MM YYYY" required><br><br>



                                <label>End Date: </label>
                                <input type="date" id="lname" name="lname" data-date-format="DD MM YYYY" required><br><br>


                                <div class="form-group">
                                    <label>Max Leaves: </label>
                                    <input type="int" id="max_leaves" name="max_leaves" required><br><br>
                                </div>

                                <div class="form-group">
                                    <label>Per Day Mess Charges: </label>
                                    <input type="int" id="charges" name="charges" required><br><br>
                                </div>
                                <input type="submit" class="btn btn-info" name="edit" value="Generate Receipt">
                                <br>
                                <p>This will create the report for all the students.</p>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports TAB -->
        <div id="Reports" class="tabcontent">
            <!-- <h3></h3> -->
            <div class="container py-1">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class='fa fa-edit'></i>Individual Reports </h4>
                            </div>
                            <br>
                            <form action="person_report.php" method="post">
                                <label>Start Date: </label>
                                <input type="date" id="fname" name="fname" data-date-format="MM DD YYYY" required><br><br>

                                <label>End Date: </label>
                                <input type="date" id="lname" name="lname" data-date-format="MM DD YYYY" required><br><br>

                                <label>Roll no: </label>

                                <input type="text" id="p_roll" name="p_roll" required><br><br>



                                <input type="submit" class="btn btn-info" name="edit" value="Submit">
                                <br>
                                <p>This will generate detailed report of the particular roll number.</p>
                            </form>
                            <br>
                        </div>
                        <br><br>
                        <!-- this program prints the summary reports -->
                        <!-- <h3></h3> -->
                        <div class="card">
                            <!-- JOURNAL Fill FORM - HEADER -->
                            <div class="card-header">
                                <h4><i class='fa fa-edit'></i>Summary report </h4>
                            </div>
                            <br>
                            <form action="csvsummary.php" method="post">

                                <label>Start Date: </label>
                                <input type="date" id="fname" name="fname" data-date-format="DD MM YYYY" required><br><br>



                                <label>End Date: </label>
                                <input type="date" id="lname" name="lname" data-date-format="DD MM YYYY" required><br><br>


                                <div class="form-group">
                                    <label>Max Leaves: </label>
                                    <input type="int" id="max_leaves" name="max_leaves" required><br><br>
                                </div>

                                <div class="form-group">
                                    <label>Per Day Mess Charges: </label>
                                    <input type="int" id="charges" name="charges" required><br><br>
                                </div>
                                <input type="submit" class="btn btn-info" name="edit" value="Submit">
                                <br>
                                <p>This will create the report for all the students.</p>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Meals" class="tabcontent">
            <div class="container py-1">
                <div class="row">
                    <div class="col-md-10 offset-md-1">

                        <div class="card">
                            <div class="card-header">
                                <h4><i class='fa fa-edit'></i>Meals report </h4>
                            </div>
                            <br>
                            <form action="Meals_report.php" method="post">

                                <label>Start Date: </label>
                                <input type="date" id="fname" name="fname" data-date-format="DD MM YYYY" required><br><br>


                                <label>End Date: </label>
                                <input type="date" id="lname" name="lname" data-date-format="DD MM YYYY" required><br><br>

                                <input type="submit" class="btn btn-info" name="edit" value="Generate Receipt">
                                <br>
                                <p>This will create the report for all the Meals.</p>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        </form>

    </center>
    <p>
        <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
        <a href="index.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

</body>

</html>