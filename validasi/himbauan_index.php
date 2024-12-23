<?php
include('himbauan_include.php');
$tahun = intval(date("Y")) -1;
$pth ='<option value="9999">-----</option>';
for($t=0;$t<4;$t++) {
 $pt = $tahun - $t;
 $pth .= '<option value="'.$pt.'">'.$pt.'</option>';
}
$kakapnm = 'Pak Kepala';
$kakapnip = 'nip101996031001';
$ARW2=$ARW3=$ARE='';
$file = fopen("daftarpeg.txt","r");
while(! feof($file)) {
 $as = fgets($file);
 $ad = explode(';',$as);
 $batas = sizeof($ad);
 if($ad[0]=='Kakap') {
  $kakapnm = $ad[1];
  $kakapnip =  preg_replace('/[\r\n]+/','', $ad[2]);
 }
 if($ad[0]=='Waskon2') {
  $KW2 = $ad[1];
  $ARW2 = '<option value="9999"> ------- </option>';
  for($o=2;$o<$batas;$o++) {
   $bt = preg_replace('/[\r\n]+/','', $ad[$o]);
   $ARW2 .= '<option value="'.$bt.'">'.$bt.'</option>';
  }
 }
 if($ad[0]=='Waskon3') {
  $KW3 = $ad[1];
  $ARW3 = '<option value="9999"> ------- </option>';
  for($o=2;$o<sizeof($ad);$o++) {
   $bt = preg_replace('/[\r\n]+/','', $ad[$o]);
   $ARW3 .= '<option value="'.$bt.'">'.$bt.'</option>';
  }
 }
 if($ad[0]=='Eksten') {
  $KEX = $ad[1];
  $ARE = '<option value="9999"> ------- </option>';
  for($o=2;$o<sizeof($ad);$o++) {
   $bt = preg_replace('/[\r\n]+/','', $ad[$o]);
   $ARE .= '<option value="'.$bt.'">'.$bt.'</option>';
  }
 }
 if($ad[0]=='plh') {
  $plhnm = $ad[1];
  $plhnip = preg_replace('/[\r\n]+/','', $ad[2]);
 }
}
fclose($file);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Himbauan Pelaporan SPT</title>
<style>
body {
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}
input {
	background:yellow;
	color:blue;
	padding:0px 5px;
	border-radius:5px;
}
input:focus, select:focus {
	background:white;
}
.th1 {
	text-shadow:1px 1px 1px white;
	background-image: linear-gradient(rgb(190, 255, 249) 45%, rgb(27, 255, 222) 55%);
	background-origin: padding-box;
	font-family: lucida grande,tahoma,verdana,arial,sans-serif;
	line-height:30px;
	font-size:20px;
	border-bottom:1px solid;
}
.th2 {
	text-shadow:1px 1px 1px white;
	background-image: linear-gradient(rgb(210, 202, 255) 45%, rgb(156, 138, 255) 55%);
	background-origin: padding-box;
	font-family: lucida grande,tahoma,verdana,arial,sans-serif;
	border-bottom:1px solid;
}
.th3 {
	text-shadow:1px 1px 1px white;
	background-image: linear-gradient(rgb(210, 202, 255) 45%, rgb(156, 138, 255) 55%);
	background-origin: padding-box;
	font-family: lucida grande,tahoma,verdana,arial,sans-serif;
	border-bottom:1px solid;
}
.tb1 { 
	background:rgb(190,255,249);
	border:1px solid black;
	border-collapse:collapse;
	border-radius:10px;
}
.tb2 { 
	background:rgb(210,202,255);
	border:1px solid black;
	border-collapse:collapse;
}
select {
	font-size:14px;
}
label {
	cursor:pointer;
	padding-right:8px;
	border-radius:6px;
	background:#CCC;
	border:1px groove;
}
label:hover {
	background:pink;
	color:black;
}
.lpil {
	background:blue;
	color:white;
}
.lpil2 {
	background:#CCC;
	color:black;
}
.printr {
	background:black;
	border-radius:20px;
	cursor:pointer;
}
.printr:hover {
	background:yellow;
}
</style>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="cleave.js"></script>
<script type='text/javascript'>//<![CDATA[
window.onload=function(){
 var cleaveCustom = new Cleave('.input-npwp', {
  numericOnly: true,
  delimiters: ['.', '.','.', '-','.'],
  blocks: [2, 3, 3, 1, 3, 3],
 });
 setar();
}//]]> 
</script>
<script language="javascript">
var kakapnm = '<?php echo $kakapnm; ?>';
var kakapnip = '<?php echo $kakapnip; ?>';
var KW2 = '<?php echo $KW2; ?>';
var KW3 = '<?php echo $KW3; ?>';
var KEX = '<?php echo $KEX; ?>';
var ARW2 = '<?php echo $ARW2; ?>';
var ARW3 = '<?php echo $ARW3; ?>';
var ARE = '<?php echo $ARE; ?>';
var plhnm = '<?php echo $plhnm; ?>';
var plhnip = '<?php echo $plhnip; ?>';

function fcek(r) {
 t=(r.id);
 if($(r).prop('checked')) {
  $(r).parent().prop('class','lpil');
 } else {
  $(r).parent().prop('class','lpil2');
 }
 switch (t) {
  case 'i_BL':
   if($(r).prop('checked')) {
    for(a=1;a<=4;a++) {
	 $('#i_L'+a).prop('disabled',false);
	 //$('#i_L'+a).parent().css('background','yellow');
	}
   } else {
    for(a=1;a<=4;a++) {
	 $('#i_L'+a).prop('checked',false);
	 $('#i_L'+a).prop('disabled',true);
	 $('#i_L'+a).parent().prop('class','lpil2');
	}
   }
   break;
  case 'i_Pb':
   if($(r).prop('checked')) {
    $('#i_Pbt').prop('disabled',false);
    $('#i_Pbt').css({'background':'blue','color':'white'});
   } else {
    $('#i_Pbt').prop('disabled',true);
    $('#i_Pbt').val(9999);
    $('#i_Pbt').css({'background':'','color':'grey'});
   }
   break;
  case 'i_plhKp':
   if($(r).prop('checked')) {
    $('#i_NIPKP').val(plhnip);
    $('#i_NAMAKP').val(plhnm);
	$('#i_NIPKP').prop('disabled',false);
	$('#i_NAMAKP').prop('disabled',false);
	$('#i_NIPKP').focus();
   } else {
    $('#i_NIPKP').val(kakapnip);
    $('#i_NAMAKP').val(kakapnm);
	$('#i_NIPKP').prop('disabled',true);
	$('#i_NAMAKP').prop('disabled',true);
   }
   break;
 }
}
function kirim() {
 var vk=[],nk=[];
 nk= ['npwp','nama','alamat','kota','shm','xbl','xbl1','xbl2','xbl3','xbl4','xpb','seksi','ar','kasi','plh','nipk','nmk','thb'];
 vk[0]=$('#i_NPWP').val();
 if(vk[0].length<3) {
   alert('NPWP Salah!');
   $('#i_NPWP').focus();
   return false;
 }
 vk[1] = $('#i_NAMA').val().trim();
 if(vk[1].length<3) {
   alert('Nama WP Salah!');
   $('#i_NAMA').focus();
   return false;
 }
 vk[2] = $('#i_ALAMAT').val().trim();
 if(vk[2].length<3) {
   alert('Alamat Salah!');
   $('#i_ALAMAT').focus();
   return false;
 }
 vk[3] = $('#i_KOTA').val().trim();
 if(vk[3].length<3) {
   alert('Kota Salah!');
   $('#i_KOTA').focus();
   return false;
 }
 vk[4] = $('#i_SHM').val().trim();
 if(vk[4].length<3) {
   alert('Nomor SHM Salah!');
   $('#i_SHM').focus();
   return false;
 }
 vk[5]=0;
 vk[6]=vk[7]=vk[8]=vk[9]='';
 var xbl, xbl1, xbl2 , xbl3, xbl4, xcek, xpb;
 xbl = xbl1 = xbl2 = xbl3 = xbl4 = xcek = xpb = 0;
 if($('#i_BL').prop('checked')) {
  vk[5]=1;
  xbl=1;
  if($('#i_L4').prop('checked')) { xcek++;vk[6]=$('#i_L4').val(); }
  if($('#i_L3').prop('checked')) { xcek++;vk[7]=$('#i_L3').val(); }
  if($('#i_L2').prop('checked')) { xcek++;vk[8]=$('#i_L2').val(); }
  if($('#i_L1').prop('checked')) { xcek++;vk[9]=$('#i_L1').val(); }
  console.log(vk[6],vk[7],vk[8],vk[9]);
  if(xcek==0) {
   alert('Tahun SPT Belum Lapor masih kosong!');
   $('#i_BL').focus();
   return false;
  }
 }
 vk[10]=0;
 if($('#i_Pb').prop('checked')) { vk[10] = 1; }
 if(vk[5]+vk[10] ==0) {
   alert('Belum pilih Belum Lapor SPT/Pembetulan!');
   $('#i_BL').focus();
   return false;
 }
 vk[11] = $('#i_Seksi').val();
 vk[12] = $('#i_AR').val();
 if(parseInt(vk[12])==9999) {
   alert('Belum pilih AR!');
   $('#i_AR').focus();
   return false;
 }
 vk[13] = $('#i_Kasi').val();
 vk[14] = '';
 vk[15] = kakapnip; //plhnip;
 vk[16] = kakapnm; //plhnm
 if($('#i_plhKp').prop('checked')) {
  vk[14]='plh. ';
  vk[15] = $('#i_NIPKP').val().trim();
  if(vk[15].length!=18) {
   alert("NIP Salah\nNIP 18 digit!");
   $('#i_NIPKP').focus();
   return false;
  }
  vk[16] = $('#i_NAMAKP').val().trim();
  if(vk[16].length<5) {
   alert('Nama plh Kakap salah!');
   $('#i_NAMAKP').focus();
   return false;
  }
  if(vk[15]!=plhnip || vk[16]!=plhnm) {
   var yt = confirm("Simpan plh Kakap?\nPastikan NIP dan Nama sudah benar!");
   if(yt) {
    gantitxt('plh');
	plhnip = vk[15];
	plhnm = vk[16]
   }
  } else {
   vk[15] = plhnip;
   vk[16] = plhnm;
  }
 }
 vk[17] = '';
 console.log(parseInt($('#i_Pbt').val()));
 if($('#i_Pb').prop('checked')) {
  if(parseInt($('#i_Pbt').val())==9999) {
   alert('Tahun pembetulan belum dipilih!');
   $('#i_Pbt').focus();
   return false;
  }
  vk[17] = $('#i_Pbt').val();
 }
 var form = $('<form method="post" action="tcpdf_out.php" target="tcpdfku">');
 var ko = '';
 for(z=0;z<=17;z++) {
  ko = $('<input type="text" name="'+nk[z]+'" value="'+vk[z]+'">');
  form.append(ko);
 }
 $('#nutul').append(form);
 var buka = window.open('blong.htm','tcpdfku');
 if(buka) {
  form.submit();
  buka.focus();
 }
 form.remove();
 return false;
}
function gantiplh(opo) {

}
function gsar() {
 if($('#i_AR').val()=='9999') {
  $('#i_AR').css({'background':'#CCC','color':'black'});
 } else {
  $('#i_AR').css({'background':'yellow','color':'blue'});
 }
}
function gseksi(opo) {
 switch(opo) {
  case 'Pengawasan dan Konsultasi II':
   $('#i_AR').empty();
   $('#i_AR').append(ARW2);
   $('#i_Kasi').val(KW2);
   break;
  case 'Pengawasan dan Konsultasi III':
   $('#i_AR').empty();
   $('#i_AR').append(ARW3);
   $('#i_Kasi').val(KW3);
   break;
  case 'Ekstensifikasi dan Penyuluhan':
   $('#i_AR').empty();
   $('#i_AR').append(ARE);
   $('#i_Kasi').val(KEX);
   break;
 }
 gsar();
}
function setar() {
 $('#focusguard-2').on('focus', function() {
  $('#i_NPWP').focus();
 });

 $('#focusguard-1').on('focus', function() {
  $('#i_NAMAKP').focus();
 });
}
</script>
</head>

<body>
<form autocomplete="off" onsubmit="return false;">
<table style="border-collapse:collapse;margin:0;position:absolute;top:35%;left:50%;-ms-transform:translate(-50%, -50%);transform: translate(-50%, -50%);" align="center">
 <tr>
  <td colspan="2" align="center">
   <table class="tb1" cellpadding="3">
    <tr>
     <th colspan="2" align="center" class="th1">INPUT HIMBAUAN SPT</th>
    </tr>
    <tr>
     <td valign="bottom">NPWP</td>
     <td valign="bottom">
      <div id="focusguard-1" class="focusguard" tabindex="1"></div>
      <input type="text" id="i_NPWP" style="width:130px;" tabindex="2" class="input-npwp" onfocus="this.select()" autofocus="autofocus" autocomplete="off" placeholder="NPWP Pemohon" value="00.000.000.0-656.000" />
      <button type="reset" style="float:right;cursor:pointer;;border:1px;padding:0px 6px 0px 6px;border-radius:5px;background:yellowgreen;font-weight:bold;" id="button2"><img src="images/eraser.png" width="14" />&nbsp;Reset Form</button>
     </td>
    </tr>
    <tr>
     <td>Nama WP</td>
     <td><input type="text" autocomplete="off" onfocus="this.select()" style="width:390px;" id="i_NAMA" tabindex="3" placeholder="Nama WP/Pemohon" value="NAMA WAJIB PAJAK" /></td>
    </tr>
    <tr>
     <td>Alamat</td>
     <td><input type="text" autocomplete="off" onfocus="this.select()" style="width:390px;" id="i_ALAMAT" tabindex="4" placeholder="Alamat WP/Pemohon" value="JALAN PELAN-PELAN BANYAK ANAK KECIL NOMOR 56-A" /></td>
    </tr>
    <tr>
     <td>Kota</td>
     <td><input type="text" autocomplete="off" onfocus="this.select()" style="width:390px;" id="i_KOTA" tabindex="5" placeholder="Kota WP/Pemohon" value="SITUBONDO" /></td>
    </tr>
    <tr style="border-bottom:1px solid black;">
     <td colspan="2">
      No. Bukti Kepemilikan
      <input type="text" autocomplete="off" onfocus="this.select()" style="width:300px;" id="i_SHM" tabindex="6" placeholder="Nomor SHM/Petok/Girik/Pipil" value="656-12/2013" />
     </td>
    </tr>
    <tr>
     <td colspan="2">
      <table>
       <tr>
        <td><label><input type="checkbox" onclick="fcek(this)" id="i_BL" tabindex="7" />SPT belum lapor</label></td>
        <td>Tahun 
         <label>
          <input type="checkbox" onclick="fcek(this)" id="i_L1" tabindex="8" disabled="disabled" value="<?php echo $tahun; ?>" /><?php echo $tahun; ?>
         </label>
         <label>
          <input type="checkbox" onclick="fcek(this)" id="i_L2" tabindex="9" disabled="disabled" value="<?php echo $tahun -1; ?>" /><?php echo $tahun -1; ?>
         </label>
         <label>
          <input type="checkbox" onclick="fcek(this)" id="i_L3" tabindex="10" disabled="disabled" value="<?php echo $tahun -2; ?>" /><?php echo $tahun -2; ?>
         </label>
         <label>
          <input type="checkbox" onclick="fcek(this)"  id="i_L4" tabindex="11" disabled="disabled" value="<?php echo $tahun -3; ?>" /><?php echo $tahun -3; ?>
         </label>
        </td>
       </tr>
       <tr>
        <td colspan="2">
        <label><input type="checkbox" onclick="fcek(this)" id="i_Pb" tabindex="12" />Pembetulan SPT</label>
        <select id="i_Pbt" tabindex="13" style="background:yellow;color:blue;">
         <?php echo $pth; ?>
        </select>
        </td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td>
   <table class="tb2" align="center" style="box-shadow:3px 3px 3px grey;"><tr><td>
   <table cellpadding="3" class="tb2">
    <tr>
     <th colspan="2" class="th2">P E J A B A T</th>
    </tr>
    <tr>
     <td colspan="2">
      <table style="border-collapse:collapse">
       <tr>
        <td>Seksi</td>
        <td>
         <select id="i_Seksi" onchange="gseksi(this.value)" style="background:yellow;color:blue;" tabindex="14">
           <option value="Pengawasan dan Konsultasi II">Pengawasan dan Konsultasi II</option>
           <option value="Pengawasan dan Konsultasi III">Pengawasan dan Konsultasi III</option>
           <option value="Ekstensifikasi dan Penyuluhan">Ekstensifikasi dan Penyuluhan</option>
         </select>
         
        </td>
       </tr>
       <tr>
        <td>AR</td>
        <td>
         <select onchange="gsar()" style="background:#CCC;color:blue;" id="i_AR" tabindex="15">
          <?php echo $ARW2; ?>
         </select>
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr style="border-bottom:1px solid black;">
     <td>Kepala Seksi</td>
     <td><input type="text" id="i_Kasi" style="width:200px;" onfocus="this.select()" tabindex="16" value="<?php echo $KW2; ?>" disabled="disabled" />
     </td>
    </tr>
    <tr>
     <th colspan="2" style="background-image:linear-gradient(rgb(156, 138, 255) , rgb(210, 202, 255) )"><label>
       <input type="checkbox" onchange="fcek(this)" id="i_plhKp" tabindex="17" />
       Plh.</label>
       KEPALA KANTOR</th>
    </tr>
    <tr>
     <td colspan="2">
     <table>
      <tr>
      <td>NIP <span id="kplh"></span></td>
      <td>
       <input type="text" id="i_NIPKP" style="width:135px;" tabindex="18" onfocus="this.select()" value="<?php echo $kakapnip; ?>" maxlength="18" disabled="disabled" />
       <div id="focusguard-2" class="focusguard" tabindex="19"></div>
      </td>
      </tr>
      <tr>
      <td>Nama</td>
      <td> <input type="text" id="i_NAMAKP" style="width:250px;" tabindex="19" onfocus="this.select()" value="<?php echo $kakapnm; ?>" disabled="disabled" />
      </td>
      </tr>
     </table>
     </td>
    </tr>
   </table>
  </td>
  <td valign="top">
  <table cellpadding="3" class="tb2">
  <tr class="th2" style="border:1px solid black;">
   <th style="background: url(images/config_tool_icon_red.png) 0 0% no-repeat;background-size: 25px;padding:3px 0px;">Tools</th></tr>
  <tr><td align="center" style="padding-top:9px;">
  <button id="c_list" style="border-radius:8px;cursor:pointer;background:black;color:white;" title="Edit list pejabat">List Pegawai</button></td></tr>
  <tr><td align="center">
  <button class="printr" title="Cetak Himbauan" onclick="kirim()"><img src="images/printer.png" width="110" /></button>
  </td></tr></table>
  </td>
 </tr>
 </table>
   
  </td>
 </tr>
</table>
</form>
<div id="nutul" style="display:none;"></div>
</body>
</html>