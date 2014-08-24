<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'lib/class.db.php';
$debug = true;
if (is_dir('install') && !$debug) {
    if (strlen(file_get_contents("config.php")) > 0) {
        die('Please remove or rename the install directory to continue.');
    } else {
        header('Location: install/');
    }
}

require_once 'config.php';

if ($_SESSION['lin'] == "1") {
    header('Location: add.php');
} else {
    header('Location: login.php');
}
