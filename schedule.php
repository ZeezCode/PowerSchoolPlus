<?php
include 'db_info.php';
include 'utilities.php';
session_start();
if (!(isset($_SESSION['username']))) {
    header('Location: http://craftmountain.net/ps/');
    die(0);
}
$dbconnect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!(verifySession($_SESSION['username'], session_id(), $dbconnect))) {
    session_unset();
    echo "<h1>Invalid session ID, <a href='http://craftmountain.net/ps/'>click here to return to the login page.</a></h1>";
    die(0);
}
#echo "Welcome, " . $_SESSION['username'] . "! You've successfully logged in.";
?>
<html>
<head>
    <title>My Schedule - PS+</title>
    <style>
        body {
            margin-top: 0px;
            padding-top: 0px;
            margin-left: 0px;
            padding-left: 0px;
            margin-right: 0px;
            padding-right: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;

            background-color: #59748C;
        }

        #header {
            width: 100%;
            height: 10%;
            border: none;
            border-collapse: collapse;
            background-color: #354D62;

            text-align: center;
            vertical-align: middle;

            font-size: 35px;

            table-layout: fixed;
        }

        #header td {
            width: 14%;
        }

        #header td {
            border-left: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        #header td:first-child {
            border-left: none;
        }

        #header a {
            text-decoration: none;
        }

        #header a:link {
            color: #D7F2F7;
        }

        #header a:visited {
            color: #D7F2F7;
        }

        #header a:hover {
            color: #33FFE0;
        }

        #header a:active {
            color: #D7F2F7;
        }

        #sidebar {
            float: left;
            border-right: 1px solid #000000;
            width: 20%;
            top: 10%;
            height: 90%;
            text-align: center;
        }

        #mainContent {
            margin-left: 20%;
            width: 80%;
            height: 90%;
        }

        #mainContent p, h2 {
            padding: 0px;
            margin-left: 50px;
            margin-bottom: 0px;
        }

        .announcementTitle {
            margin-top: 0px;
        }

        .announcementDate {
            font-size: 10px;
            margin-left: 50px;
            margin-top: 0px;
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #000000;
            margin: 1em 0;
            margin-left: 50px;
            padding: 0;
            width: 35%;
        }

        /** 808080 **/
    </style>
</head>
<body>
<table id="header">
    <tr>
        <td><img src="http://craftmountain.net/ps/images/headerLogo.png"/></td>
        <td><a href="home.php">Home</a></td>
        <td><a href="schedule.php">Schedule</a></td>
        <td><a href="forms.php">Forms</a></td>
        <td><a href="profile.php">Student Info</a></td>
        <td><a href="quiz.php">Quizzes</a></td>
        <td><a href="resetsession.php">Log Out</a></td>
    </tr>
</table>
<div id="sidebar">
    <?php
    $userInfo = getUserInfo($_SESSION['username'], $dbconnect);
    $userFullName = $userInfo['firstname'] . " " . $userInfo['lastname'];
    $regDate = date("m.d.y", $userInfo['regdate']);
    $bDay = $userInfo['birthday'];
    $grade = $userInfo['grade'];
    $gender = ($userInfo['gender'] == 'm' ? "Male" : "Female");
    $counselorName = "";

    if ($userInfo['accounttype'] == 's') {
        $getCounselorSQL = sprintf("SELECT * FROM ps_users WHERE uid='%d';", mysqli_real_escape_string($dbconnect, $userInfo['counselorid']));
        $getCounselorQuery = mysqli_query($dbconnect, $getCounselorSQL);
        if (mysqli_num_rows($getCounselorQuery) == 0) {
            $counselorName = "Not assigned";
        } else {
            $counselorInfo = mysqli_fetch_assoc($getCounselorQuery);
            $counselorName = $counselorInfo['lastname'] . ", " . $counselorInfo['firstname'];
        }
    } else {
        $counselorName = "N/A";
    }

    echo "<p>$userFullName</p>";
    echo "<p>*ShowProfilePictureHere*</p>";
    echo "<p>Enrolled: $regDate</p>";
    echo "<p>D.O.B.: $bDay</p>";
    echo "<p>Grade: " . getGradeNameFromNum($grade) . "</p>";
    echo "<p>Gender: $gender</p>";
    ?>
</div>
<div id="mainContent">
    <center><u><h1>My Schedule</h1></u></center>
</div>
</body>
</html>