<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";
$module=$_GET['module'];
$act=$_GET['act'];

// Kirim SMS
if($module=='smsgroup' AND $act=='kirimsmsgroup'){
  
   $tujuan=$_POST['group'];
   $pesan = $_POST['pesan'];
   
	$query = "SELECT * FROM sms_phonebook";
  	$hasil = mysql_query($query);
	while ($r  = mysql_fetch_array($hasil)) {
	$group = explode('|', $r['idgroup']);
	if (in_array($tujuan, $group)) {
	mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$r[noTelp]', '$pesan', 'Gammu')");
	}
 }
?>
	 <script language="javascript">
			alert("SMS Group dikirim!!");
			document.location="../../media.php?module=home";
	</script><?php
  }
}
?>