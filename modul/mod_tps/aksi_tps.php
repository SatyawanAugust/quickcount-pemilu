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

// Hitung Dan Buat TPS sampel
if ($module=='tps' AND $act=='hitung'){
   
   $percaya = $_POST['percaya'];
   $error = $_POST['error'];
   $pemilih = $_POST['pemilih'];
   $tps =$_POST['tps'];

	if ($percaya==1)  $percaya=1.65;
	else if ($percaya==2)  $percaya=1.96;
	else if ($percaya==3)  $percaya=2.58;
	else $percaya==0; 
	
	$error = $error/100;
	   
  if(is_numeric($percaya) && is_numeric($pemilih) && is_numeric($tps) && is_numeric($error) && $percaya!=0){
  //1. menghitung populasi sampel
  $sampel_pemilih = round(($percaya*$percaya*(0.5*(1-0.5))*$pemilih) / ($percaya*$percaya*(0.5*(1-0.5))+(($pemilih-1)*$error*$error)));
  //2. menghitung rata-rata pemilih	
  $rata_pemilih = round($pemilih/$tps);
  //3. menghitung jumlah sampel tps
  $sampel_tps = round($sampel_pemilih/$rata_pemilih);	
  //3.1. Menentukan interval sampel
  $interval = round($tps/$sampel_tps);
  //3.2. memilih sampel pertama secara random
  $random = (rand(1,$interval));
  //3.3. memilih secara acak/random sampel selanjutnya sebanyak jumlah tps sampel
  $counter=0;
  for ($i=$random;$i<=$tps;$i+=$interval) {
	if($counter==$sampel_tps) { break; }
   mysql_query("INSERT INTO sms_tps(nama_tps) VALUES ('TPS $i')");
  $counter++;
  }

}  
  else{
  ?>
	 <script language="javascript">
			alert("Kesalahan pengisian field, harap ulangi lagi!!");
			document.location="../../media.php?module=tps";
	</script><?php
  }
header('location:../../media.php?module='.$module);
  }

// Edit dan lengkapi lokasi dan jumlah suara masing-masing tps terpilih
if ($module=='tps' AND $act=='update'){

$lokasi=$_POST['lokasi'];
$totalsuara=$_POST['total'];
$notelp=$_POST['relawan'];
mysql_query("UPDATE `sms_tps` SET lokasi = '$lokasi', 
					`total_suara` =  '$totalsuara',
					`noTelp` = '$notelp' 
					WHERE `id_tps` = '$_POST[id]'");
header('location:../../media.php?module='.$module);

}


}
?>
