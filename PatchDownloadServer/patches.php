<?php
require_once 'lib/class.db.php';
require_once 'config.php';
$query = "SELECT * FROM patches ORDER BY `priority` DESC";
$db = new DB($db_host, $db_uname, $db_pw, $db_db);

$results = $db->get_results($query);
echo json_encode($results);
