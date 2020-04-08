<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];

// Update admin
if ($module=='admin' AND $act=='update'){
  if (empty($_POST[password])) {
   mysql_query("UPDATE sms_user SET username   = '$_POST[username]'
                                WHERE id   = '$_POST[id]'");
	} else{
	 $pass=md5($_POST[password]);
	  mysql_query("UPDATE sms_user SET username   = '$_POST[username]',
                                      password = '$pass'
                              WHERE id   = '$_POST[id]'");
	 } 
	 ?>
	 <script language="javascript">
			alert("Data Admininstrator berhasil diubah!!");
			document.location="../../media.php?module=home";
	</script><?php
	}
}
?>