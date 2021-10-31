<?php
require("connect.inc.php");
require("function.inc.php");
session_unset();
session_destroy();
header('location:index.php');
die();
?>