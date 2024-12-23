<?php require_once('include.php'); ?>
<?php
$searchTerm = strtoupper($_GET['term']);

$kolom = 'nama';
if(is_numeric(substr($searchTerm,0,2))) {
 $kolom = 'sket_no';
}
if($kolom == 'sket_no' && strlen($searchTerm)<3) {
 die();
}
$sql = "SELECT DISTINCT $kolom FROM validasiphtb WHERE $kolom LIKE UPPER('%".$searchTerm."%') ORDER BY $kolom ";
$resu = mysqli_query($QConn, $sql) or die(mysqli_error($QConn).'<hr>'.$sql);
$nRows = mysqli_num_rows($resu);
$namae = array();
if($nRows>0) {
 while ($row = mysqli_fetch_assoc($resu)) {
 $namae[]=$row[$kolom];
 }
}

echo json_encode($namae);



?>

