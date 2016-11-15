<?php
    function verifySession($username, $id, $dbconnect) {
        $getUserInfoSQL = sprintf("SELECT * FROM ps_users WHERE username='%s';", mysqli_real_escape_string($dbconnect, $username));
        $getUserInfoQuery = mysqli_query($dbconnect, $getUserInfoSQL);
        if (mysqli_num_rows($getUserInfoQuery) == 0) {
            return false;
        }
        $userInfo = mysqli_fetch_assoc($getUserInfoQuery);
        if ($userInfo['sessionid'] == $id) {
            return true;
        }
        return false;
    }

    function userLoggedIn($username, $id, $dbconnect) {
        $updateUserSQL = sprintf("UPDATE ps_users SET lastseen = '%d', lastip = '%s', sessionid = '%s' WHERE username = '%s';",
            mysqli_real_escape_string($dbconnect, time()),
            mysqli_real_escape_string($dbconnect, $_SERVER['REMOTE_ADDR']),
            mysqli_real_escape_string($dbconnect, $id),
            mysqli_real_escape_string($dbconnect, $username));
        return mysqli_query($dbconnect, $updateUserSQL);
    }

    function getUserInfo($username, $dbconnect) {
        $getUserInfoSQL = sprintf("SELECT * FROM ps_users WHERE username='%s';", mysqli_real_escape_string($dbconnect, $username));
        $getUserInfoQuery = mysqli_query($dbconnect, $getUserInfoSQL);
        if (mysqli_num_rows($getUserInfoQuery) == 0) {
            return false;
        }
        else {
            return mysqli_fetch_assoc($getUserInfoQuery);
        }
    }
    function getGradeNameFromNum($num) {
        if ($num == 9) return "Freshman";
        else if ($num == 10) return "Sophomore";
        else if ($num == 11) return "Junior";
        else if($num == 12) return "Senior";
        else return "UNKNOWN_GRADE";
    }
?>