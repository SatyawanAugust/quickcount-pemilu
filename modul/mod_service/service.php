<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_service/aksi_service.php";
switch($_GET[act]){
  // Tampil service
default:
// menjalankan command untuk mengenerate file service.log
passthru("net start > service.log");

// membuka file service.log
$handle = fopen("service.log", "r");

// status awal = 0 (dianggap servicenya tidak jalan)
$status = 0;

// proses pembacaan isi file
while (!feof($handle))
{
   // baca baris demi baris isi file
   $baristeks = fgets($handle);
   if (substr_count($baristeks, 'Gammu SMSD Service (GammuSMSD)') > 0)
   {
     // jika ditemukan baris yang berisi substring 'Gammu SMSD Service (GammuSMSD)'
     // statusnya berubah menjadi 1
     $status = 1;
   }
}
// menutup file
fclose($handle);

// jika status terakhir = 1, maka gammu service running
if ($status == 1) {
echo "<h2>Service Gammu</h2>";	  	  
echo "<form method='post' action='?module=service&act=status'>";
echo "<input type='submit' name='stop' value='Hentikan Service Gammu'>";
echo "</form>";
}
// jika status terakhir = 0, maka service gammu berhenti
else if ($status == 0) {
echo "<h2>Service Gammu</h2>";	  	  
echo "<form method='post' action='?module=service&act=status'>";
echo "<input type='submit' name='start' value='Jalankan Service Gammu'>";
echo "</form>";

}

break;

case "status":
echo "<h2>Service Gammu</h2>";	  
if ($_POST['start'])
{
   passthru("c:\gammu\bin\gammu-smsd -c smsdrc -s");
}

else if ($_POST['stop'])
{
   passthru("c:\gammu\bin\gammu-smsd -k");
}
break; 
}
}

?>
