<?php
//============================================================+
// File name   : tcpdf_out.php
// Begin       : 2018-10-20
// Last Update : 2018-10-20
//
// Description : Template Surat Himbauan spt
//
//
// Author: mbahfelix
//============================================================+
include('include.php');
//   ${'var'.$i};
foreach($_POST as $key => $value) {
 ${$key} = htmlspecialchars($value);
}
//['npwp','nama','alamat','kota','shm','xbl','xbl1','xbl2','xbl3','xbl4','xpb','seksi','ar','kasi','plh','nipk','nmk']
if($thb!='') { $thb = ' tahun '.$thb; }
$acek = '<img src="images/acek.png">';
$bcek = '<img src="images/acek.png">';
$thl = '';
if($xbl==1) {
 $acek = '<img src="images/bcek.png">';
 for($i=1;$i<=4;$i++) {
  if(${'xbl'.$i} != '') {
   if(strlen($thl)>1) {
    $thl .= ', '.${'xbl'.$i};
   } else {
    $thl = ' tahun '.${'xbl'.$i};
   }
  }
 }
}
if($xpb==1) { $bcek = '<img src="images/bcek.png">'; }
$QDate = date('Y-m-d'); //'2018-04-20';
$date = strtotime($QDate);
$tgl = date('d',$date);
$bln = date('m',$date);
$thn = date('Y',$date);
$hars = date('w',$date);
$jams = date('H:i',$date);
switch ($hars) {
 case 0:
  $hari='Minggu';
  break;
 case 1:
  $hari='Senin';
  break;
 case 2:
  $hari='Selasa';
  break;
 case 3:
  $hari='Rabu';
  break;
 case 4:
  $hari='Kamis';
  break;
 case 5:
  $hari='Jumat';
  break;
 case 6:
  $hari='Sabtu';
}
$ctgl = $hari.', '.$tgl.'/'.$bln.'/'.$thn.' '.$jams;
$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$blns = intval($bln);
// Include the main TCPDF library (search for installation path).

require_once('../tcpdf/tcpdf_include.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('mbahfelix');
$pdf->SetTitle('Surat Himbauan');
$pdf->SetSubject('Aplikasi Antrian');
$pdf->SetKeywords('TCPDF, PDF');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
$pdf->SetMargins(20, 10, 15, false);
//$pdf->SetAutoPageBreak(false);
// set font
$pdf->SetFont('Arial', '', 6);
//$pdf->SetFont(‘times’, ‘BI’, 20, “, ‘false’);

$pdf->AddPage('P', 'A4');

$tbl = <<<EOD
<style>
.ns {
  font-family:Arial;
  font-size:11pt;
}
.k1 {
  font-family:Arial, Helvetica, sans-serif;
  font-size:14pt;
  font-weight:bold;
}
.k2 {
  font-family:Arial, Helvetica, sans-serif;
  font-weight:bold;
  font-size:13pt;
}
.k3 {
  font-family:Arial, Helvetica, sans-serif;
  font-weight:bold;
  font-size:11pt;
}
.k4 {
  font-family:Arial, Helvetica, sans-serif;
  font-size:7pt;
}
.pn {
  text-indent: 15 em;
  text-align: justify;
  line-height: 1.5;
}
.ps {
  text-align: justify;
  line-height: 1.5;
}
.tt {
	line-height: 1;
}
sela {
	font-size:2pt;
	height:1pt;
    line-height: 0.7;
}
</style>
<table style="font-size:10px;" cellpadding="0" cellspacing="0" border="0">
 <tr>
  <td style="border-bottom:1px solid black;width:120px;" align="center"><img src="images/logokmk.JPG" width="100" height="100"></td>
  <td align="center" style="border-bottom:1px solid black;width:500px;">
   <span class="k1">KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</span><br>
   <span class="k3">DIREKTORAT JENDERAL PAJAK<br>
    KANTOR WILAYAH DJP JAWA TIMUR III</span><br>
   <span class="k2">KANTOR PELAYANAN PAJAK PRATAMA SITUBONDO</span><br>
   <span class="k4">JALAN  ARGOPURO NO.41, SITUBONDO - 68322<br>
    TELEPON (0338) 671969, 671800; FAKSIMILE (0338) 673701; SITUS www.pajak.go.id<br>
    LAYANAN INFORMASI DAN KELUHAN KRING PAJAK (021)1500200;<br>
    EMAIL pengaduan@pajak.go.id, informasi@pajak.go.id
   </span>
  </td>
 </tr>
</table>
<div align="right" class="ns">$tgl $bulan[$blns] $thn</div>

<table class="ps ns">
 <tr>
  <td width="15%">Nomor</td>
  <td width="60%">: S-.............../WPJ.12/KP.15/$thn</td>
 </tr>
 <tr>
  <td>Lampiran</td>
  <td>: -</td>
 </tr>
 <tr>
  <td>Hal.</td>
  <td>: Himbauan Penyampaian/Pembetulan SPT Tahunan</td>
 </tr>
</table>

<br><br>
<div class="ns ps">
Yth. Sdr/i. $nama<br>
NPWP $npwp<br>
$alamat<br>
$kota<br>
</div>
<div class="ns pn">
Pajak adalah kontribusi wajib pajak kepada negara yang terutang oleh orang pribadi atau badan yang bersifat memaksa 
berdasarkan Undang-undang dan digunakan untuk keperluan Negara bagi sebesar-besarnya kemakmuran rakyat.
</div>
<div class="pn ns">
Sehubungan dengan permohonan penelitian bukti pemenuhan kewajiban penyetoran Pajak Penghasilan atas pengalihan 
hak atas tanah dan/atau bangunan atau perubahan perjanjian pengikatan jual beli atas tanah dan/atau bangunan yang 
Saudara/i ajukan atas tanah dan/atau bangunan dengan bukti kepemilikan nomor $shm, 
disampaikan bahwa berdasarkan penelitian pada Sistem Informasi Direktorat Jenderal Pajak diketahui:
</div>
<table class="ps ns" width="100%">
 <tr>
  <td style="width:24px;text-align:center;" align="center">$acek</td>
  <td style="width:560px;padding-left:30px;">Saudara belum melaporkan SPT Tahunan$thl.</td>
 </tr>
 <tr>
  <td style="width:24px;text-align:center;" align="center">$bcek</td>
  <td valign="top">Tanah dan/atau Bangunan yang Saudara alihkan tersebut belum dilaporkan dalam SPT Tahunan.</td>
 </tr>
</table>
<br>
<div class="pn ns">
Sesuai ketentuan pasal 4 ayat(1) Undang-undang Nomor 6 Tahun 1983 tentang Ketentuan Umum dan Tata Cara Perpajakan sebagaimana telah diubah terakhir dengan Undang-undang Nomor 16 Tahun 2009 dijelaskan bahwa Wajib Pajak"<b>wajib</b>" mengisi dan menyampaikan <b>Surat Pemberitahuan (SPT) Tahunan Pajak Penghasilan</b> dengan benar, lengkap, jelas, dan menandatanganinya. Bersama ini dihimbau agar Saudara segera menyampaikan/membetulkan SPT Tahunan Pajak Penghasilan$thb.</div>
<-- Perlu diingatkan bahwa setiap Wajib Pajak yang dengan sengaja tidak menyampaikan dan/atau menyampaikan Surat Pemberitahuan dan/atau keterangan yang isinya tidak benar atau tidak lengkap sehingga dapat menimbulkan kerugian pada pendapatan Negara, dapat dikenakan sanksi administrasi dan/atau sanksi pidana sesuai dengan ketentuan perundang-undangan yang berlaku.<br>
-->
<div class="pn ns">
Dalam hal diperlukan penjelasan lebih lanjut, silakan menghubungi Sdr. $kasi, Kepala seksi $seksi KPP Pratama Situbondo, atau Sdr. $ar, <i>Account Representative</i>, di nomor telepon (0338) 471969.
<--Sebagai bagian dari upaya kami untuk memberikan pelayanan yang baik kepada Wajib pajak dan dalam rangka penerapan Kode Etik Pegawai, dengan ini disampaikan komitmen kami bahwa semua pelayanan perpajakan yang kami berikan tidak dikenakan biaya.<br>-->
</div>
<div class="pn ns">
Demikian disampaikan, atas perhatiannya kami ucapkan terima kasih.
</div>
<br><br>
<br>
<table align="right" class="tt ns">
<tr><td width="60%" align="right"></td><td align="left">$plh Kepala Kantor,<br><br><br><br><br>
$nmk<br>
NIP $nipk
</td></tr>
</table>

EOD;
//$tbl = utf8_decode($tbl);
$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();

//$pdf->Button('print', 30, 10, 'Print', 'Print()', array('lineWidth'=>2, 'borderStyle'=>'beveled', 'fillColor'=>array(128, 196, 255), 'strokeColor'=>array(64, 64, 64)));

$js = <<<EJS
// print();
EJS;

$pdf->IncludeJS($js);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('tt_temp.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>
