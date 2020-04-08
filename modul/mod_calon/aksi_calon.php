<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/fungsi_thumb.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus calon
if ($module=='calon' AND $act=='hapus'){
  $data=mysql_fetch_array(mysql_query("SELECT foto FROM sms_calon WHERE id_calon='$_GET[id]'"));
  if ($data['foto']!=''){
     mysql_query("DELETE FROM sms_calon WHERE id_calon='$_GET[id]'");
     unlink("foto/$_GET[namafile]");   
	 unlink("foto/medium_$_GET[namafile]");
     unlink("foto/small_$_GET[namafile]");   
  }
  else{
     mysql_query("DELETE FROM sms_calon WHERE id_calon='$_GET[id]'");
  }
  header('location:../../media.php?module='.$module);
}

// Input calon
elseif ($module=='calon' AND $act=='input'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 


  // Apabila ada foto yang diupload
  if (!empty($lokasi_file)){
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
    echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        window.location=('../../media.php?module=calon)</script>";
    }
    else{
    UploadImage($nama_file_unik);

    mysql_query("INSERT INTO sms_calon(nomorcalon,
                                    calon,
                                    wacalon,
                                    foto) 
                            VALUES('$_POST[nomor]',
                                   '$_POST[calon]',
                                   '$_POST[wacalon]',
                                   '$nama_file_unik')");
  header('location:../../media.php?module='.$module);
  }
  }
  else{
 mysql_query("INSERT INTO sms_calon(nomorcalon,
                                    calon,
                                    wacalon) 
                            VALUES('$_POST[nomor]',
                                   '$_POST[calon]',
                                   '$_POST[wacalon]')");
  header('location:../../media.php?module='.$module);
  }
}

// Update calon
elseif ($module=='calon' AND $act=='update'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file; 

   // Apabila foto tidak diganti
  if (empty($lokasi_file)){
    mysql_query("UPDATE sms_calon SET nomorcalon = '$_POST[nomor]',
                                   calon   = '$_POST[calon]', 
                                   wacalon = '$_POST[wacalon]' 
                             WHERE id_calon   = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
  }
  else{
    if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
    echo "<script>window.alert('Upload Gagal, Pastikan File yang di Upload bertipe *.JPG');
        window.location=('../../media.php?module=calon')</script>";
    }
    else{
    UploadImage($nama_file_unik);
    mysql_query("UPDATE sms_calon SET nomorcalon = '$_POST[nomor]',
                                   calon   = '$_POST[calon]', 
                                   wacalon = '$_POST[wacalon]', 
                                   foto      = '$nama_file_unik'   
                             WHERE id_calon   = '$_POST[id]'");
   header('location:../../media.php?module='.$module);
   }
  }
}
}
?>
