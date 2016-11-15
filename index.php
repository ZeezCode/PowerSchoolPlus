<?php
    session_start();
    if (isset($_SESSION['username'])) {
        header('Location: http://craftmountain.net/ps/home.php');
    } else { //Not logged in, requires login form
        ?>
<html>
    <head>
        <title>Login Screen - PS+</title>
        <style>
            body {
                background-color: #354D62;
            }
            #errorbox {
                position: absolute;
                top: 10%;
                bottom: 0;
                left: 0;
                right: 0;
                margin-left: auto;
                margin-right: auto;

                width: 750px;
                height: 40px;
                line-height: 0px;
                vertical-align: middle;
                background-color: #848484;
                color: #FF0000;

                border-radius: 15px;
            }
            #loginform {
                position: absolute;
                top: 25%;
                bottom: 0;
                left: 0;
                right: 0;
                margin-left: auto;
                margin-right: auto;

                width: 500px;
                height: 275px;
                background-color: #59748C;

                border-radius: 25px;
                border: 2px solid #FFFFFF;
            }
            input {
                background-color: #D7F2F7;
                color: #000000;
                outline: none;
                border: 2px solid #D7F2F7;
                border-radius: 15px;

                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
            }
            input[type=submit] {
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }
            
            /*Color the placeholder text in input fields*/
            ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
                color: #000000;
            }
            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
                color: #000000;
                opacity: 1;
            }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color: #000000;
                opacity: 1;
            }
            :-ms-input-placeholder { /* Internet Explorer 10-11 */
                color: #000000;
            }
        </style>
    </head>
    <body>
    <?php
        if (isset($_GET['error'])) {
            ?>
        <div align="center" id="errorbox">
            <?php
                $errorMsg = "";
                $errorCode = $_GET['error'];
                if ($errorCode == 1) {
                    $errorMsg = "No username or password was supplied.";
                } else if ($errorCode == 2) {
                    $errorMsg = 'No account exists with this username.';
                } else if ($errorCode == 3) {
                    $errorMsg = "Incorrect password";
                } else if ($errorCode == 4) {
                    $errorMsg = "Invalid session ID";
                } else if ($errorCode == 5) {
                    $errorMsg = "Failed to log in, please try again later.";
                } else {
                    $errorMsg = "Unknown error";
                }
                echo "<h3>" . $errorMsg . "</h3>";
                echo "</div>";
            ?>
            <?php
        }
    ?>
        <div align="center" id="loginform">
            <h1>Log In To PowerSchool+</h1>
            <form action="processlogin.php" method="post">
                <table>
                    <tr>
                        <td><input type="text" name="username" size="20" placeholder="Username" autofocus /></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="password" size="20" placeholder="Password" /></td>
                    </tr>
                    <tr>
                        <td align="center"><input type="submit" name="submit" value="Log In!" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
        <?php
    }
?>