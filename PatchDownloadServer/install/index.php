<?php
//This is just an ugly mess thrown together for this principle of concept.


if (strlen(file_get_contents("../config.php")) > 0) {
    die('You have already have ran the installation, if you would like to rerun it please delete the contents of config.php');
}

if (!isset($_GET['o'])) {
    showForm();
} else {
    switch ($_GET['o']) {
        case '1':
            $data = array('a_uname' => $_POST['a_uname'],
                  'a_pw' => $_POST['a_pw'],
                  'db_host' => $_POST['db_host'],
                  'db_uname' => $_POST['db_uname'],
                  'db_pw' => $_POST['db_pw'],
                  'db_db' => $_POST['db_db']
                  );
            install($data);
            break;
        
        default:
            showForm();
            break;
    }
}

function install(array $data)
{
    require_once '../lib/class.db.php';
    $database = new DB($data['db_host'], $data['db_uname'], $data['db_pw'], $data['db_db']);
    $patchesTable = "CREATE TABLE `" . $data['db_db'] . "`.`patches` (
                `id` INT NOT NULL,
                `url` VARCHAR(1024) NOT NULL,
                `priority` INT NOT NULL,
                PRIMARY KEY (`id`));
              ";
    $database->dropTable('patches');
    if ($database->query($patchesTable)) {
        echo "Patches table created. <br />";
    }

    $configFile = fopen("../config.php", "w");
    if (!$configFile) {
        die("Are you sure config.php exists and has write permission?");
    }
    $txt = "<?php
\$db_host = \"" . $data['db_host'] . "\";
\$db_uname = \"" . $data['db_uname'] . "\";
\$db_pw = \"" . $data['db_pw'] . "\";
\$db_db = \"" . $data['db_db'] . "\";
\$a_uname = \"" . $data['a_uname'] . "\";
\$a_pw = \"" . hash("sha256", $data['a_pw']) . "\";";
    fwrite($configFile, $txt);
    fclose($configFile);
    echo "Config.php installed.<br />";
    echo "Installation done, please remove or rename the install folder. <br /> After you've done that please click <a href=\"../\">here</a>.";
}

function showForm()
{
    echo '<center>
    <form action="?o=1" method="post">
        <table>
          <tr>
            <th>Installation:</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <td>Admin Username:</td>
            <td><input type="text" name="a_uname" value="admin"></td>
          </tr>
          <tr>
            <td>Admin Password:</td>
            <td><input type="password" name="a_pw" value="admin"></td>
          </tr>
          <tr>
            <th>Database:</th>
            <th>&nbsp;</th>
          </tr>
          <tr>
            <td>MySQL Hostname:</td>
            <td><input type="text" name="db_host" value="localhost"></td>
          </tr>
          <tr>
            <td>MySQL Port:</td>
            <td><input type="text" value="3306" name="db_port"></td>
          </tr>
          <tr>
            <td>MySQL Username:</td>
            <td><input type="text" name="db_uname"></td>
          </tr>
          <tr>
            <td>MySQL Password:</td>
            <td><input type="password" name="db_pw"></td>
          </tr>
          <tr>
            <td>MySQL Database:</td>
            <td><input type="text" name="db_db"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="Install"></td>
          </tr>
        </table>
    </form>
</center>';
}
