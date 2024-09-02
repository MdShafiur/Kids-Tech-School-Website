<?php


session_start();
unset($_SESSION["recID"]);
session_write_close();
$url = "./index.php";
header("Location: $url");


?>
