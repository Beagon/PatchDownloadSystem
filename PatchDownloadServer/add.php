<?php
require_once 'config.php';
require_once 'lib/class.db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!$_SESSION['lin'] == "1") {
    header('Location: index.php');
}

if (isset($_POST['furl'])) {
    $db = new DB($db_host, $db_uname, $db_pw, $db_db);
    $pathInfo = basename($_POST['furl']);
    $data = array(
            'url' => $_POST['furl'],
            'priority' => $_POST['prio'],
            'file' => $pathInfo
            );
    $insert = $db->insert_safe('patches', $data);
    if ($insert) {
        $set = "Patch " . $_POST['furl'] . " has been added.";
    } else {
        $set = "Something went wrong with inserting the data. Please try again.";
    }
}

?>
    <a href="logout.php">Logout</a><center>
    <form method="post">
        <table>
<?php
if (isset($set)) {
    echo "<tr>
    <th>".$set."</th>
    <th>&nbsp;</th>
    </tr>";
}
?>
          <tr>
            <th>Add patch:</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <td>File url:</td>
            <td><input type="text" name="furl" required></td>
          </tr>
          <tr>
            <td>Priority:</td>
            <td>
              <select name="prio" required>
                <option value="4">High</option>
                <option value="3">Medium</option>
                <option value="2">Low</option>
                <option value="1">Very Low</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Add"></td>
          </tr>
      </table>
    </form></center>
