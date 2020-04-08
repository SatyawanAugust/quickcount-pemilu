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

// Input Relawan
if ($module=='relawan' AND $act=='input'){
	$nama = $_POST['nama'];
   $alamat = $_POST['alamat'];
   $tgllhr = $_POST['tgllhr'];
   
   $splittgl = explode('-', $tgllhr);
   $tgllhr = $splittgl[2]."-".$splittgl[1]."-".$splittgl[0]; 
   
   $notelp = $_POST['notelp'];
   
   if (substr($notelp, 0, 1) == '0')
   {
	$notelp[0] = "X";
	$notelp = str_replace("X", "+62", $notelp);
   }
   else $notelp = $notelp;

  mysql_query("INSERT INTO sms_relawan VALUES ('$notelp', '$nama', '$alamat', '$tgllhr')");
  header('location:../../media.php?module='.$module);
}

// Update Relawan
elseif ($module=='relawan' AND $act=='update'){
	$notelplama = str_replace(" ","+", $_POST['notelplama']);
	$notelp = str_replace(" ","+", $_POST['notelp']);
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	
	$tgllhr = $_POST['tgllhr'];
   
    $splittgl = explode('-', $tgllhr);
    $tgllhr = $splittgl[2]."-".$splittgl[1]."-".$splittgl[0];
	
	if (substr($notelp, 0, 1) == '0')
   {
	$notelp[0] = "X";
	$notelp = str_replace("X", "+62", $notelp);
   }
   else $notelp = $notelp;

	mysql_query("UPDATE sms_relawan SET nama='$nama', datebirth='$tgllhr', noTelp='$notelp', alamat='$alamat' WHERE noTelp = '$notelplama'");
  header('location:../../media.php?module='.$module);
}

// Hapus Relawan
elseif ($module=='relawan' AND $act=='hapus'){
  $id = str_replace(" ","+", $_GET['id']);
  mysql_query("DELETE FROM sms_relawan WHERE noTelp = '$id'");
  header('location:../../media.php?module='.$module);
}
// Kirim SMS 
elseif ($module=='relawan' AND $act=='kirimsms'){
  $noTujuan = str_replace(" ","+", $_POST['phone']);
  $pesan = $_POST['pesan'];
	mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$noTujuan', '$pesan', 'Gammu')");
   ?>
	 <script language="javascript">
			alert("SMS dikirim!!");
			document.location="../../media.php?module=relawan";
	</script><?php
}

// Kirim SMS Ke Semua Relawan
elseif ($module=='relawan' AND $act=='kirimsemua'){
  $noTujuan = str_replace(" ","+", $_POST['phone']);
  $pesan = $_POST['pesan'];
  
   $query = mysql_query("SELECT * FROM sms_relawan");
   while ($r=mysql_fetch_array($query)){
	mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$r[noTelp]', '$pesan', 'Gammu')");
	}
    ?>
	 <script language="javascript">
			alert("SMS Semua Relawan dikirim!!");
			document.location="../../media.php?module=relawan";
	</script><?php
}

}
?>
