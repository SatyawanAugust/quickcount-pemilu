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
if ($module=='group' AND $act=='input'){
  mysql_query("INSERT INTO sms_group VALUES(NULL,'$_POST[namagroup]')");
  header('location:../../media.php?module='.$module);
}

// Update Group
elseif ($module=='group' AND $act=='update'){
	$id = $_POST['id'];
	$idgroup = $_POST['idgroup'];
	$group = $_POST['namagroup'];
  mysql_query("UPDATE sms_group SET sms_group.group = '$group' WHERE idgroup = '$id'");
  header('location:../../media.php?module='.$module);
}

// Hapus Group
elseif ($module=='group' AND $act=='hapus'){
  mysql_query("DELETE FROM sms_group WHERE idgroup='$_GET[idgroup]'");
  header('location:../../media.php?module='.$module);
}
}
?>
