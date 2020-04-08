<?php
session_start();
error_reporting(0);

include_once 'config/cek_sesi.php';

if (empty($_SESSION['username'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<html>
<head>
<title>Panel Kelola Aplikasi Quick Count Pemilu</title>
<script> 
function Count(){ 
	var karakter,maksimum; 
	maksimum = 160 
	karakter = maksimum-(document.form1.pesan.value.length); 
	if (karakter < 0) { 
		alert("Jumlah Maksimum Karakter: " +  maksimum + ""); 
		document.form1.pesan.value = document.form1.pesan.value.substring(0,maksimum); 
		karakter = maksimum-(document. form1.pesan.value.length); 
		document.form1.counter.value = karakter; 
	}
	else { 
	document.form1.counter.value = maksimum-(document.form1.pesan.value.length); 
		} 
	} 
</script> 
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">  	

	<div id="menu">
		<div class="left">
		<?php 
        include "menu.php"; ?>
		</div>
		<div class="right">
		 <ul class="topmenu">
		     <li><a href=logout.php>Logout</a></li>
     </ul>
		</div>
	</div>
</div>
<div id="wrap">
  <div id="content">
		<?php include "content.php"; ?>
  </div>
  
		<div id="footer">
			Copyright &copy; 2013 Buku Proyek Aplikasi SMS Quick Count Pemilu Dengan PHP.
		</div>
</div>
</body>
</html>
<?php
}
?>
