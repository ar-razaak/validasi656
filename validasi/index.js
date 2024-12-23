/* index.js */
var bgf='';
var bgl=999;
var bgi='';
var lastm = '';
var ch_name=cspGet('ch_n','');
var chet=true;

function hcet() {
 if(chet) {
  $('#ch_isi').hide(200);
  $('#chin').hide(200);
  $('#ch_judul').prop('title','Buka');
 } else {
  $('#ch_isi').show(200);
  $('#chin').show(200);
  $('#ch_judul').prop('title','Tutup');
 }
 chet=!chet;
}
function delawal() {
 $('#chin_f').val(ch_name);
 setTimeout(function() {hcet()},2000);
}
function cspSet(key,val) {
 return localStorage[key]=val;
}
function cspGet(key,def) {
 return localStorage[key] || def;
}
function menu(mn,opo) {
// $("[id^='menu_']").css({'background':'#FFFFEA','color':'black'});
// $('#'+mn.id).css({'background':'blue','color':'yellow'});
 if(opo==0) {
  location.href='/sptlb';
 }
 if(opo==1) {
  $('#konten').attr('src','lista.php');
  $('#judulmn').html('Monitoring Layanan: '+$('#'+mn.id).html());
  ubahlayar();
 }
 if(opo==2) {
  $('#konten').attr('src','impor-fs.php');
  $('#judulmn').html('Upload Tabel SPT-LB: '+$('#'+mn.id).html());
  ubahlayar();
 }
}