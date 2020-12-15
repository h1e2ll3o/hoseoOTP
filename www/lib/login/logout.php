<?php
include('../db/config.php');
include('check.php');

session_destroy();

header('Location: ../index.php');
?>
