<?php
if (is_dir('install')) {
    if (strlen(file_get_contents("config.php")) > 0) {
        die('Please remove or rename the install directory to continue.');
    } else {
        header('Location: install/');
    }
}
