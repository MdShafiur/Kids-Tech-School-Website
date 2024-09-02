<?php

session_start();
unset($_SESSION["adminemail"]); 
session_write_close();
$url = "./validateadmin.php";
header("Location: $url");

?>