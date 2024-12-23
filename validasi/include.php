<?php
// Koneksyong
// config.php
date_default_timezone_set('Asia/Jakarta');
$mdhost = "localhost";
$mddata = "unggulan";
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
function cutstring ($string,$length,$html = true) {
 if(strlen($string) > $length) {
  if($html) {
   $original = str_replace(':', '\"', $string);
  }
  $string = substr($string, 0, $length);
  if($html) {
   $string = '<span title="'.$original.'">'.$string.'&hellip;</span>';
  } else {
   $string .='...';
  }
 }
 return $string;
}
function t_tanggal($tg) {
 if(strlen($tg)!=10) {
  return('---');
 }
 if(substr($tg,4,1)=='-') {
  $ola = explode('-',$tg);
  return($ola[2].'/'.$ola[1].'/'.$ola[0]);
 } else {
  $ola = explode('/',$tg);
  return($ola[2].'-'.$ola[1].'-'.$ola[0]);
 }
}

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

class Paging{
 function cariPosisi($batas){
  //isset($_GET['thn']) ? $_GET['thn']:$thpil;
  $halaman = @$_GET['halaman'];
  if(empty($halaman)){
   $position = 0;
   $halaman = 1;
  }else{
   $position = ($halaman - 1) * $batas;
  }
  return $position;
 }

 function jmlHalaman($jmlData,$batas){
  $jmlHal = ceil($jmlData/$batas);
  return $jmlHal;
 }

 Function linkHal($halamanAktif,$jumlahHalaman){
  $link_halaman = '<table style="width:100%;"><thead><tr valign="middle"><td align="center">';
  $file = $_SERVER['PHP_SELF'];
  
  // Link First dan Previous
  $prev = $halamanAktif-1;
  if($halamanAktif < 2){
   //$link_halaman .= "First &nbsp; Prev  ";
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="First">First</button>';
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="Prev">Prev</button></td>';
  }else{
   //$link_halaman .= "<a href='$file?halaman=1'>FIRST</a> &nbsp; <a href='$file?halaman=$prev'>PREV</a> &nbsp; ";
   $link_halaman .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=1'\">First</button>";
   $link_halaman .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=$prev'\">Prev</button></td>";
  }

  // link halaman 1,2,3,...
  // Angka awal
  //$angka = ($halamanAktif > 3 ? "<td>..." : "<td>_");
  $angka = "<td align=\"center\">";
  for($i=$halamanAktif-5;$i<$halamanAktif;$i++){
   if ($i < 1 )continue;
   //$angka .= "<a href='$file?halaman=$i'>$i</a> &nbsp; ";
   $angka .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=$i'\">$i</button>";
  }
  //$angka .="</td><td>";

  // Angka tengah
  if($halamanAktif=='') {
   $angka .= "<button disabled style=\"background:grey; color:white;\"><b>1</b></button> &nbsp; ";
  } else {
   $angka .= "<button disabled style=\"background:grey; color:white;\"><b>$halamanAktif</b></button>";
  }
  for($i=$halamanAktif+1;$i<($halamanAktif+6);$i++){
   if($i > $jumlahHalaman) break;
   if($i!=1) {
    $angka .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=$i'\">$i</button>";
   }
  }

  // ANgka Akhir
  $angka .= "</td><td align=\"center\">";
  //$angka .= ($halamanAktif+2<$jumlahHalaman ? " ... &nbsp; <button onclick=\"javascript:location.href='$file?halaman=$jumlahHalaman'\">$jumlahHalaman</button> &nbsp;" : "");
  $link_halaman .= $angka;

  // Link Next dan Last
  if($halamanAktif < $jumlahHalaman){
   $next = $halamanAktif+1;
   $link_halaman .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=$next'\">Next</button>";
   $link_halaman .= "<button class=\"nbutton\" onclick=\"javascript:location.href='$file?halaman=$jumlahHalaman'\">Last</a> &nbsp;";
  }else{
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="Next">Next</button>';
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="Last">Last</button> &nbsp; ';
   $link_halaman .= "</td></tr></th></table>";
  }
  return $link_halaman;
 }
}

class Pager{
 function cariPosisi($batas){
  //isset($_GET['thn']) ? $_GET['thn']:$thpil;
  $halaman = @$_GET['halaman'];
  if(empty($halaman)){
   $position = 0;
   $halaman = 1;
  }else{
   $position = ($halaman - 1) * $batas;
  }
  return $position;
 }

 function jmlHalaman($jmlData,$batas){
  $jmlHal = ceil($jmlData/$batas);
  return $jmlHal;
 }

 Function linkHal($halamanAktif,$jumlahHalaman){
  $link_halaman = '<table style="width:100%;"><thead><tr valign="middle"><td align="center">';
  $file = $_SERVER['PHP_SELF'];
  
  // Link First dan Previous
  $prev = $halamanAktif-1;
  if($halamanAktif < 2){
   //$link_halaman .= "First &nbsp; Prev  ";
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;">First</button>';
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;">Prev</button></td>';
  }else{
   //$link_halaman .= "<a href='$file?halaman=1'>FIRST</a> &nbsp; <a href='$file?halaman=$prev'>PREV</a> &nbsp; ";
   $link_halaman .= "<button id=\"pgs1\" class=\"nbutton\" onclick=\"perpage(this)\" value=1>First</button>";
   $link_halaman .= "<button id=\"pgs2\" class=\"nbutton\" onclick=\"perpage(this)\" value=$prev>Prev</button></td>";
  }

  // link halaman 1,2,3,...
  // Angka awal
  //$angka = ($halamanAktif > 3 ? "<td>..." : "<td>_");
  $angka = "<td align=\"center\">";
  for($i=$halamanAktif-5;$i<$halamanAktif;$i++){
   if ($i < 1 )continue;
   //$angka .= "<a href='$file?halaman=$i'>$i</a> &nbsp; ";
   $angka .= "<button id=\"pg".$i."\" class=\"nbutton\" onclick=\"perpage(this)\" value=$i>$i</button>";
  }
  //$angka .="</td><td>";

  // Angka tengah
  if($halamanAktif=='') {
   $angka .= "<button disabled style=\"background:grey; color:white;\"><b>1</b></button> &nbsp; ";
  } else {
   $angka .= "<button disabled style=\"background:grey; color:white;\"><b>$halamanAktif</b></button>";
  }
  for($i=$halamanAktif+1;$i<($halamanAktif+6);$i++){
   if($i > $jumlahHalaman) break;
   if($i!=1) {
    $angka .= "<button id=\"pge".$i."\" class=\"nbutton\" onclick=\"perpage(this)\" value=$i>$i</button>";
   }
  }

  // ANgka Akhir
  $angka .= "</td><td align=\"center\">";
  //$angka .= ($halamanAktif+2<$jumlahHalaman ? " ... &nbsp; <button onclick=\"javascript:location.href='$file?halaman=$jumlahHalaman'\">$jumlahHalaman</button> &nbsp;" : "");
  $link_halaman .= $angka;

  // Link Next dan Last
  if($halamanAktif < $jumlahHalaman){
   $next = $halamanAktif+1;
   $link_halaman .= "<button id=\"pge1\" class=\"nbutton\" onclick=\"perpage(this)\" value=$next>Next</button>";
   $link_halaman .= "<button id=\"pge2\" class=\"nbutton\" onclick=\"perpage(this)\" value=$jumlahHalaman>Last</button>";
  }else{
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="Next">Next</button>';
   $link_halaman .= '<button disabled style="background:grey;color:white;font-weight:bold;" value="Last">Last</button> &nbsp; ';
   $link_halaman .= "</td></tr></th></table>";
  }
  return $link_halaman;
 }
}

?>