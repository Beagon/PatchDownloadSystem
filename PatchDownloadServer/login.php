<?php
session_start();
if ($_SESSION['lin'] == "1") {
    echo "You are already logged in. Redirecting... <meta http-equiv='refresh' content='3; url=add.php' />";
}
if (isset($_POST['username'])) {
    require_once('config.php');
    if ($a_uname == $_POST['username'] && $a_pw == hash("sha256", $_POST['password'])) {
        $_SESSION['lin'] = "1";
        echo "You are logged in. Redirecting... <meta http-equiv='refresh' content='3; url=add.php' />";
    } else {
        echo "Username or password incorrect.";
    }
} else {
    echo '<center>
    <form method="post">
        <table>
          <tr>
            <th>Login:</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <td>Username:</td>
            <td><input type="text" name="username" required></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="password" required></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Login"></td>
          </tr>
      </table>
    </form></center>';
}
