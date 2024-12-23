<?php
date_default_timezone_set('Asia/Jakarta');
$mdhost = "localhost";
$mddata = "unggulan";
$mduser = "kpp656";
$mdpass = "kpp656";
$QConn = mysqli_connect($mdhost, $mduser, $mdpass, $mddata) or die(mysqli_connect_error()); 
mysqli_select_db($QConn,$mddata) or die('---error conection----');

// fungsi cek string querry
if (!function_exists("CekStr")) {
 function CekStr($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  if (PHP_VERSION < 6) {
   $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $mdhost = "localhost";
  $mddata = "unggulan";
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
//$datamem='';
if(isset($_GET['data'])) {
 $datamem = mysqli_real_escape_string($QConn, $_GET['data']);
} else {
 die('No Param!');
}

echo $datamem.'<hr>';
$pc = explode('||',$datamem);
$nopem = $pc[0];
echo $nopem.'<br>';
$tgp = explode("/",$pc[1]);
$tgpem = $tgp[2].'-'.$tgp[1].'-'.$tgp[0];
echo $tgpem.'<br>';
$sql = "SELECT * FROM validasiphtb WHERE bps_no='$nopem' ";
//$sql = "SELECT * from HimbauanValidasi WHERE NoPem = '$nopem' ";
echo $sql;
$result = mysqli_query($QConn, $sql) or die(mysqli_error($QConn));
$totalRows = mysqli_num_rows($result);
mysqli_free_result($result);
if($totalRows>0) {
 $sql = "UPDATE validasiphtb SET approve=NOW() WHERE bps_no='$nopem' ";
 if(!mysqli_query($QConn,$sql)) {
  die($sql);
 }
}

echo 'Sukses..!';
?>
