<?php
    include 'db_info.php';
    include 'utilities.php';
    session_start();

    function returnWithError($errorNum) {
        header('Location: http://craftmountain.net/ps/index.php?error=' . $errorNum);
    }

    $dbconnect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno()) {
        die("Connection error: " . mysqli_connect_error());
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);
        if ($user == "" || $pass == "") {
            returnWithError(1);
            die(0);
        }
        $getUserInfoSQL = sprintf("SELECT * FROM ps_users WHERE username='%s';", mysqli_real_escape_string($dbconnect, $user));
        $getUserInfoQuery = mysqli_query($dbconnect, $getUserInfoSQL);
        if (mysqli_num_rows($getUserInfoQuery) == 0) {
            returnWithError(2);
            die(0);
        }
        #We now know user exists with the given username, now verify password
        $userInfo = mysqli_fetch_assoc($getUserInfoQuery);
        $hashedPass = md5( md5($userInfo['salt']).md5($pass) );
        if ($userInfo['password'] == $hashedPass) { #Successful login
            $_SESSION['username'] = $user;
            $_SESSION['sesid'] = session_id();
            if (userLoggedIn($_SESSION['username'], session_id(), $dbconnect) == false) {
                returnWithError(5);
                die(0);
            }
            header('Location: http://craftmountain.net/ps/home.php');
        } else {
            returnWithError(3);
            die(0);
        }

    } else {
        returnWithError(1);
    }