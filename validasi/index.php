<?php
require_once ('include.php');
$getprt = printer_list(PRINTER_ENUM_LOCAL);
$printers = serialize($getprt);
$printers = unserialize($printers);
$pilprint = 'Print Rawdata<br>';
$pilprint .= '<select name="printer" id="printer">';
//echo '<pre>';
//print_r ($printers);
//echo '</pre>';
foreach($printers as $PrintDest) {
 //$pipi = explode(',',$PrintDest['DESCRIPTION']);
 $pilprint .= ' <option value="'.$PrintDest['NAME'].'">'.$PrintDest['NAME'].'</option>';
}
$pilprint .= '</select>';
$pilprint .= '<button onclick="cetakl()">Cetak</button>';
$p = new Pager();
$batas = 40;
//$posisi = $p->cariPosisi($batas);
$thpil =(int)date('Y')+1;
$thpal =(int)date('Y')+1;
$sql = "SELECT YEAR(bps_tg) AS awu,bps_tg AS tg1,CURDATE() AS tg2 from validasiphtb WHERE bps_tg<>'0000-00-00' order by bps_tg LIMIT 1 ";
$resu = mysqli_query($QConn, $sql) or die(mysqli_error($QConn).'<hr>'.$sql);
if(mysqli_num_rows($resu)){
 while($r=mysqli_fetch_assoc($resu)){
  $thpal = (int)$r['awu'];
  $tglaw = $r['tg1'];
  $tglax = $r['tg2'];
 }
}
mysqli_free_result($resu);
$today = date('Y-m-d');
$tglm = date('Y-m-d', strtotime($today. ' - 2 month'));
//$tgst = 
// kumpulin parameter========================================
$halaman = isset($_GET['halaman']) ? $_GET['halaman']:1;
$tgla = isset($_GET['tgla']) ? t_tanggal(mysqli_real_escape_string($QConn, $_GET['tgla'])):$tglm;
$tglx = isset($_GET['tglx']) ? t_tanggal(mysqli_real_escape_string($QConn, $_GET['tglx'])):$tglax;
$cari = isset($_GET['mnobps']) ? mysqli_real_escape_string($QConn, $_GET['mnobps']):'';
$order = isset($_GET['order']) ? mysqli_real_escape_string($QConn, $_GET['order']):'ID';
//===========================================================
$orderan = $order;
if($order=='bps_no') {
 $orderan .= ' DESC, ID ';
}
$cari = trim($cari);
$posisi = ($halaman - 1) * $batas; 
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
$xurl = 'expxcl.php?tgla='.$tgla.'&tglx='.$tglax.'&mnobps='.$cari;
//$sql = "select * from validasiphtb where bps_tg between '$tgla' and '$tglx'".$cnama." order by bps_no asc limit $posisi, $batas";
$sql = "SELECT * FROM validasiphtb WHERE bps_tg BETWEEN '$tgla' AND '$tglx'".$cnama." ORDER BY $orderan DESC LIMIT $posisi, $batas";
$sqlp = "SELECT * FROM validasiphtb WHERE bps_tg BETWEEN '$tgla' AND '$tglx'".$cnama;
if($tgla==$tglx) {
 $sql = "SELECT * FROM validasiphtb WHERE bps_tg = '$tgla'".$cnama." ORDER BY $orderan DESC LIMIT $posisi, $batas";
 $sqlp = "SELECT * FROM validasiphtb WHERE bps_tg = '$tgla'".$cnama;
}
$resu = mysqli_query($QConn, $sql) or die(mysqli_error($QConn).'<hr>'.$sql);
$resup = mysqli_query($QConn, $sqlp) or die(mysqli_error($QConn).'<hr>'.$sqlp);
$jsemua = mysqli_num_rows($resu);

//echo $sql.'<hr>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrasi Validasi PHTB</title>
<link type="text/css" rel="stylesheet" href="index.css" />
<link rel="stylesheet" href="../jquery-ui-1.12.1/jquery-ui.css">
<script type="text/javascript" src="jquery.min.js"></script>
<script src="../jquery-ui-1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="cleave.js"></script>
<!--script type="text/javascript" src="index.js"></script-->
<script>
var idcetak=0;
var dicetak = '<?php echo $pilprint; ?>';
function perpage(opo) {
 var ty=opo.id.substr(0,2);
 //console.log(opo.id);
 url = '?tgla='+ $('#i_tgla').val() +'&tglx='+$('#i_tglx').val() +'&order='+$('#order').val() ;
// url += '&stat='+ $('#status').val();
// url += '&spt='+ $('#spt').val() + '&namawp='+$('#namawp').val().trim();
// url += '&rekom='+ $('#rekom').val();
 //console.log(url);
 if(ty=='pg') {
  url += '&halaman='+opo.value;
 }
 $('#kontenval').html('<img src="../images/loading2.gif">');
 location.href=url;
}

function blenk(ipi) {
 var ft=false;
 if($('#mnobps').val().trim()!='') {
  ft=true;
 }
 $('#mnobps').val('');
 $('#mnobps').focus();
 if(ft) {
  perpage(ipi);
 }
}

function cetakl() {
 var printer = $('#printer').val();
 $.ajax({
	 url: '../xbrowser/trans.php',
	 type: 'POST',
	 data: { 'mode':'cetak','var1':idcetak,'var2':printer },
	 success: function(data, textStatus, jqXHR) {
		 alert('Printed!');
	 }
 });
}

function ubahlayar() {
 var b_atas =parseInt($('#header').height());
 var myWidth = 0, myHeight = 0;
 if( typeof( window.innerWidth ) == 'number' ) {
  myWidth = window.innerWidth;
  myHeight = window.innerHeight;
 } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
  myWidth = document.documentElement.clientWidth;
  myHeight = document.documentElement.clientHeight;
 } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
  myWidth = document.body.clientWidth;
  myHeight = document.body.clientHeight;
 }
 var fhe = myHeight-b_atas-3;
 if($('#kontenval').css('display')!='none') {
  $('#kontenval').css({
   'height':fhe,
   'max-height':fhe,
   'top':b_atas,
   'overflow' :'auto',
   'width':myWidth
  });
  $('#kontenval').scrollTop(0);
 }
 if($('#tutup').css('display')!='none') {
  $('#editor').css('height',fhe);
 }
}
function trans(opo,v1,v2,v3,v4,v5,v6,v7,v8) {
 var kirim = new FormData();
 kirim.append('mode',opo);
 sasar = 'editor';
 kirim.append('var1',v1);
 //$('#'+sasar).html('<img src="../images/loading2.gif">');
 $('#tutup').css('display','block');
 var xmlhttp;
 if (window.XMLHttpRequest) {
  xmlhttp=new XMLHttpRequest();
 } else {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 xmlhttp.onreadystatechange=function() {
  if(xmlhttp.readyState==4 && xmlhttp.status==200) {
   document.getElementById(sasar).innerHTML=xmlhttp.responseText;
   if(opo=='view') {
    //$('#cetprint').html(dicetak);
   }
   ubahlayar();
  }
 }
 xmlhttp.open("POST",'../xbrowser/trans.php',true);
 xmlhttp.send(kirim);
 return false;
}
function dexls() {
 location.href='<?php echo $xurl; ?>';
}


</script>
<script>
$(function() {
 $("#mnobps").autocomplete({
  source: "caribps.php",
  minLength:3,
  select: function( event, ui ) {
   if(ui.item) {
    $("#mnobps").val(ui.item.value);
	//$('#spt').val('Semua SPT');
	//perpage(this);
	//$('#formc').submit();
   }
  }
 });
 $('.tanggalan').datepicker({
  dateFormat: "dd/mm/yy",
  minDate: "<?php echo t_tanggal($tglaw); ?>",
  maxDate: 0,
  changeMonth: true,
  changeYear: true,
  dayNames: ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"],
  dayNamesMin: ['Mg','Sn','Sl','Rb','Km','Jm','Sb'],
  gotoCurrent: true,
//  yearRange: '< ?php echo $thpal; ?>:< ?php echo $thpil; ?>'
 });
 $('#klos').click(function() {
  location.reload();
  //$('#tutup').css('display','none');
 });
});
</script>

</head>

<body onload="setTimeout(ubahlayar,50);">
<?php

//echo $sql.'-'.$order;

?>
<div id="tutup" style="position:fixed;width:100%;height:100%; background:rgba(0,0,0,0.95);color:white;top:0px;left:0px; z-index:100; display:none;">
 <div id="klos" class="ui-button" title="Klos dis data">X</div>
 <div id="editor" class="animate-bottom">
 </div>
</div>
<!--img id="cons" style="position:fixed; right:3px; top:25px;" src="../images/underconstruction.png" /-->

<div id="header" style="background: linear-gradient(rgba(0,0,255,1), rgba(200,200,200,200));">
 <div class="auto-widget" style="color:#FFF; z-index:9999; padding:5px; font-size:15px;margin-left:25px;">
 <form id="formc" name="formc" method="get">
  Nama/No.SKET: 
  <input name="mnobps" type="text" id="mnobps" style="width:235px; text-transform:uppercase;"
   onfocus="this.select()" value="<?php echo $cari; ?>
  "/><span class="btext" onclick="blenk(this)">&nbsp;X&nbsp;</span>
  &nbsp; &nbsp; tanggal BPS: <input id="i_tgla" name="tgla" class="tanggalan" 
  style="width:72px;" placeholder="dd/mm/yyyy" value="<?php echo t_tanggal($tgla); ?>"> 
   s.d. 
  <input id="i_tglx" name="tglx" class="tanggalan" style="width:72px;" placeholder="dd/mm/yyyy" 
   value="<?php echo t_tanggal($tglx); ?>">
  Sort Tgl:
  <select id="order" name="order">
   <option value="ID" <?php if($order=='ID') { echo ' selected '; } ?>>SKET</option>
   <option value="bps_no" <?php if($order=='bps_no') { echo ' selected '; } ?>>BPS</option>
  </select>
  <input type="submit" id="i_submit" value="Cari" />
<span style="float:right;
 font-size:10px;
 padding-left:5px;
 padding-right:5px;
 background:pink;
 color:black;
 cursor:pointer;
 border:2px groove black;
 " onclick="dexls()">Download Excel
</span>
 </form> 
 </div>

</div>
<?php
//echo $sql;
?>
<div id="kontenval" align="center">
<table class="fixed_head" border=1 cellspacing="0">
 <thead>
 <tr>
  <th rowspan="2">No.</th>
  <th rowspan="2">NPWP</th>
  <th rowspan="2">NAMA</th>
  <th rowspan="2">Tgl BPS</th>
  <th rowspan="2">KPP</th>
  <th colspan="6">TRANSAKSI</th>
  <th colspan="2">SKET</th>
  <th rowspan="2">Ket.</th>
  <th rowspan="2">Operator</th>
 </tr>
 <tr>
  <!--th>Tgl</th-->
  <th>Nilai</th>
  <th>Bumi</th>
  <th>Bang</th>
  <th>Tarif</th>
  <th>PPh</th>
  <th>Setor</th>
  <th>Nomor</th>
  <th>tanggal</th>
  </tr>
  </thead>
  <tbody>
<?php
if($jsemua<1) {
 echo '<tr><td colspan="15" align="center"><font size="+1">===Data Tidak Ada===</font></td></tr>';
}
if(mysqli_num_rows($resup)){
 $no = 1+$posisi;
 $wnr = '';
 $tra = '';
 $trag = false;
 while($r=mysqli_fetch_assoc($resu)){
  $wn = '';
  $wnr='';
  if($r['v_pph']!=$r['v_setor']) {
   $wn=' bgcolor="yellow" ';
  }
  //
  if($order=='ID') {
   $tcek = $r['sket_tg'];
  } else {
   $tcek = $r['bps_tg'];
  }
  if($tra!=$tcek) {
   $wnr = 'border-top:3px solid';
   $tra = $tcek;
  }
  //
  $sdh = ($r['sket']=='SKET') ? 'SKET':'Tolak';
  echo'<tr style="cursor:pointer;'.$wnr.'" onclick="trans(\'view\','.$r["ID"].')">
  <td align="center">'.$no.'</td>
  <td>'.$r['npwp'].'</td>
  <td>'.$r['nama'].'</td>
  <td align="center">'.t_tanggal($r['bps_tg']).'</td>
  <td align="center"';
  if($r['kpp']!='656') {
   echo ' style="background:lightblue" ';
  }
  echo '>'.$r['kpp'].'</td>
  <!--td>'.t_tanggal($r['trans_tg']).'</td-->
  <td align="right">'.number_format($r['trans_rp'],0,",",".").'</td>
  <td align="right">'.number_format($r['o_bumi'],0,",",".").'</td>
  <td align="right">'.number_format($r['o_bang'],0,",",".").'</td>
  <td align="center">'.number_format($r['v_tarif'],2,",",".").'</td>
  <td align="right"'.$wn.'>'.number_format($r['v_pph'],0,",",".").'</td>
  <td align="right"'.$wn.'>'.number_format($r['v_setor'],0,",",".").'</td>
  <td>'.cutstring($r['sket'].'-'.$r['sket_no'],9).'</td>
  <td>'.t_tanggal($r['sket_tg']).'</td>
  <td>'.$sdh.'</td>
  <td>'.cutstring($r['user'],7,true).'</td>
  </tr>';
  $no++;
 }
 ?>
  </tbody></table>
 <?php
 // Paging========================
 $jumlahData = mysqli_num_rows($resup);
 $jml_halaman = $p->jmlHalaman($jumlahData,$batas);
 //$link = $p->linkHal(@$_GET['halaman'],$jml_halaman);
 $link = $p->linkHal($halaman,$jml_halaman);
 echo '<div style="width:600px;" align="center">Jml data: '.number_format($jumlahData,0,',','.').' | Halaman: '.$halaman.'/'.$jml_halaman .$link. '</div>';
 //echo"<br \>Hal : $link";
}
mysqli_free_result($resu);
mysqli_free_result($resup);
?>
</div>
<?php
//echo $sql;
?>
</body>
</html>