<?php
session_start();
$debug = false;
if (is_dir('install') && !$debug) {
    if (strlen(file_get_contents("config.php")) > 0) {
        die('Please remove or rename the install directory to continue.');
    } else {
        header('Location: install/');
    }
}

if ($_SESSION['lin'] == "1") {
    header('Location: add.php');
} else {
    header('Location: login.php');
}
