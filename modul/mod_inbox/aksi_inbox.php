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

// Hapus SMS
if ($module=='inbox' AND $act=='hapus'){
  mysql_query("DELETE FROM inbox WHERE ID = '$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
// Reply SMS
elseif ($module=='inbox' AND $act=='replysms'){
  $noTujuan =$_POST['notelp'];
  $pesan = $_POST['pesan'];
	mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$noTujuan', '$pesan', 'Gammu')");
     ?>
	 <script language="javascript">
			alert("SMS dikirim!!");
			document.location="../../media.php?module=inbox";
	</script><?php
}
}
?>
