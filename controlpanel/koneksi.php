<?php 

$servername = "localhost";
$username = "iptv";
$password = "iptvmma2025";
$database = "web_tv";

$koneksi = mysqli_connect($servername, $username, $password, $database);
$protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$hostUrl = $protocol . "://" . $_SERVER["HTTP_HOST"];
 ?>
