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
if($module=='sms' AND $act=='kirimsms'){
  
   $tujuan=$_POST['tujuan'];
   $pesan = $_POST['pesan'];
   
	if($tujuan){
	 foreach ($tujuan as $t){
	 mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$t', '$pesan', 'Gammu')");
	 }?>
	 <script language="javascript">
			alert("SMS dikirim!!");
			document.location="../../media.php?module=home";
	</script><?php
	}
  }
}
?>