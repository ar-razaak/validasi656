<?php
// Koneksyong
// config.php
date_default_timezone_set('Asia/Jakarta');
$mdhost = "localhost";
$mddata = "ply656";
$mduser = "kpp656";
$mdpass = "kpp656";
$QConn = mysqli_connect($mdhost, $mduser, $mdpass, $mddata) or die(mysqli_connect_error()); 
mysqli_select_db($QConn,$mddata) or die('---error conection----');

date_default_timezone_set("Asia/Jakarta");
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$proxy = '10.12.7.251';
$myip = $_SERVER['REMOTE_ADDR'];
if($myip==$proxy) {
 echo '<font color=red>Proxy Detected!<br>Jangan menggunakan Proxy!!!</font><br>';
 die('<a href="">Reload</a>');
}
// fungsi cek string querry
if (!function_exists("CekStr")) {
 function CekStr($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  if (PHP_VERSION < 6) {
   $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $mdhost = "localhost";
  $mddata = "ply656";
  $mduser = "kpp656";
  $mdpass = "kpp656";
  $QConn = mysqli_connect($mdhost, $mduser, $mdpass, $mddata) or die(mysqli_connect_error()); 
  mysqli_select_db($QConn,$mddata) or die('---error conection----');

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($QConn,$theValue) : mysqli_escape_string($QConn,$theValue);
  switch ($theType) {
   case "text":
    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;    
   case "long":
   case "int":
    $theValue = ($theValue != "") ? intval($theValue) : "NULL";
    break;
   case "double":
    $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
    break;
   case "date":
    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    break;
   case "defined":
    $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
    break;
  }
  return $theValue;
 }
}

?>