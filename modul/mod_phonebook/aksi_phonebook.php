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

// Input Group
if ($module=='phonebook' AND $act=='input'){
	$nama = $_POST['nama'];
   $alamat = $_POST['alamat'];
   $tgllhr = $_POST['tgllhr'];
   
   $splittgl = explode('-', $tgllhr);
   $tgllhr = $splittgl[2]."-".$splittgl[1]."-".$splittgl[0]; 
   
   $group = $_POST['group'];
   
   if (!empty($group))
   {
   foreach($group as $namagroup)
   {
      $listgroup .= $namagroup.'|';
   }
   $listgroup = '|'.$listgroup;
   }
   else $listgroup = '';
   
   $notelp = $_POST['notelp'];
   
   if (substr($notelp, 0, 1) == '0')
   {
	$notelp[0] = "X";
	$notelp = str_replace("X", "+62", $notelp);
   }
   else $notelp = $notelp;

  mysql_query("INSERT INTO sms_phonebook VALUES ('$notelp', '$nama', '$alamat', '$listgroup', '$tgllhr')");
  header('location:../../media.php?module='.$module);
}

// Update Phonebook
elseif ($module=='phonebook' AND $act=='update'){
	$notelplama = str_replace(" ","+", $_POST['notelplama']);
	$notelp = str_replace(" ","+", $_POST['notelp']);
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$group = $_POST['group'];
	$grouplama = $_POST['grouplama'];
	
	$tgllhr = $_POST['tgllhr'];
   
    $splittgl = explode('-', $tgllhr);
    $tgllhr = $splittgl[2]."-".$splittgl[1]."-".$splittgl[0];
	
	$listgroup = '';
	if (!empty($group))
    {
	foreach($group as $namagroup)
	{
	   $listgroup .= $namagroup.'|';
	}
	$listgroup = '|'.$listgroup;
	}
	
	 if (substr($notelp, 0, 1) == '0')
   {
	$notelp[0] = "X";
	$notelp = str_replace("X", "+62", $notelp);
   }
   else $notelp = $notelp;

	mysql_query("UPDATE sms_phonebook SET nama='$nama', datebirth='$tgllhr', noTelp='$notelp', alamat='$alamat', idgroup='$listgroup' WHERE noTelp = '$notelplama'");
  header('location:../../media.php?module='.$module);
}

// Hapus Phonebook
elseif ($module=='phonebook' AND $act=='hapus'){
  $id = str_replace(" ","+", $_GET['id']);
  mysql_query("DELETE FROM sms_phonebook WHERE noTelp = '$id'");
  header('location:../../media.php?module='.$module);
}
// Kirim SMS
elseif ($module=='phonebook' AND $act=='kirimsms'){
  $noTujuan = str_replace(" ","+", $_POST['phone']);
  $pesan = $_POST['pesan'];
	mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID) VALUES ('$noTujuan', '$pesan', 'Gammu')");
    ?>
	 <script language="javascript">
			alert("SMS dikirim!!");
			document.location="../../media.php?module=phonebook";
	</script><?php
}
}
?>
