<?php
require_once ('include.php');
$sql = "SELECT YEAR(bps_tg) AS awu,bps_tg AS tg1,CURDATE() AS tg2 from validasiphtb order by bps_tg LIMIT 1 ";
$resu = mysqli_query($QConn, $sql) or die(mysqli_error($QConn).'<hr>'.$sql);
if(mysqli_num_rows($resu)){
 while($r=mysqli_fetch_assoc($resu)){
  $thpal = (int)$r['awu'];
  $tglaw = $r['tg1'];
  $tglax = $r['tg2'];
 }
}
mysqli_free_result($resu);
//$xurl = 'expxcl.php?tgla='.$tgla.'&tglx='.$tglax.'&cari='.$cari;

// kumpulin parameter========================================
$halaman = isset($_GET['halaman']) ? $_GET['halaman']:1;
$tgla = isset($_GET['tgla']) ? mysqli_real_escape_string($QConn, $_GET['tgla']):$tglaw;
$tglx = isset($_GET['tglx']) ? mysqli_real_escape_string($QConn, $_GET['tglx']):$tglax;
$cari = isset($_GET['mnobps']) ? mysqli_real_escape_string($QConn, $_GET['mnobps']):'';
//===========================================================
if($tgla > $tglx) {
 $tgls = $tgla;
 $tgla = $tglx;
 $tglx = $tgls;
}
$cnama='';
if($cari!='') {
 $cnama = ' AND nama="'.$cari.'" ';
 if(is_numeric(substr($cari,0,2))) {
  $cnama = ' AND sket_no="'.$cari.'" ';
 }
}

$sql = "DESC validasiphtb";
$result = mysqli_query($QConn, $sql) or die(mysqli_error($QConn.'---'.$sql));
while($row = mysqli_fetch_array($result)){
 $qarr[] = $row['Field'];
}
mysqli_free_result($result);

$sql = "select * from validasiphtb where bps_tg between '$tgla' and '$tglx'".$cnama." order by ID ";
if($tgla==$tglx) {
 $sql = "select * from validasiphtb where bps_tg = '$tgla' ".$cnama." order by ID ";
}
$result = mysqli_query($QConn, $sql) or die(mysqli_error($QConn));
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  

$objPHPExcel->setActiveSheetIndex(0);  

// Initialise the Excel row number 
$rowCount = 1;  
// $spt.$cnama.$qstat.$cpr;

//start of printing column names as names of MySQL fields  
$column = 'A';
for ($i = 0; $i < mysqli_num_fields($result); $i++)  
{
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysqli_fetch_field_direct($result,$i)->name);
    $column++;
}
$rowCount++;
//end of adding column names  

//start while loop to get data  
//$rowCount = 2;  
while($row = mysqli_fetch_row($result)) {
 $column = 'A';
 for($j=0; $j<mysqli_num_fields($result);$j++) {
  if(!isset($row[$j]))
   $value = NULL;
  elseif ($row[$j] != "")
   $value = strip_tags($row[$j]);
  else
   $value = "";

  switch($column) {
  case 'D':
  case 'F':
  case 'Z':
  case 'AH':
  case 'AJ':
  case 'AM':
  case 'AO':
   if(is_null($value)) {
   } else {
    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, t_tanggal($value));
   }
   break;
  case 'G':
  case 'L':
  case 'M';
  case 'R':
   $objPHPExcel->getActiveSheet()->setCellValueExplicit($column.$rowCount, $value, PHPExcel_Cell_Datatype::TYPE_STRING);
   break;
  default:
   $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
  }
/*
  if($column=='C') { // tgl
   $objPHPExcel->getActiveSheet()->setCellValueExplicit($column.$rowCount, $value, PHPExcel_Cell_Datatype::TYPE_STRING);
  } else {
   $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
  }
*/
  $column++;
 }  
 $rowCount++;
} 
$objPHPExcel->getActiveSheet()->setCellValue("A".($rowCount+1),$sql);


// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Resume_PHTB.xlsx"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>