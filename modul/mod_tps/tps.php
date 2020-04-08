<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
//cek jka tps sudah dibuat atau belum
$cektps = "SELECT * FROM sms_tps";
$hasil = mysql_query($cektps);
$num_rows = mysql_num_rows($hasil);

if ($num_rows<1) {
$aksi="modul/mod_tps/aksi_tps.php";
    echo "<h2>Perhitungan TPS Sampel</h2>
          <form method=POST action='$aksi?module=tps&act=hitung'>
          <table class='list'>
     	  <tr><td class='left'>Tingkat Kepercayaan</td> 
		  <td> : <select name='percaya'>
		   <option value=0 selected>- Pilih Tk. Kepercayaan -</option>	    
		   <option value=1>90%</option>
		   <option value=2>95%</option>
		   <option value=3>99%</option>
		  </select>
		  </td></tr>
		  <tr><td>Sampling Error </td>     <td> : <input type=text name='error'> *) 0 - 1 (dalam  persen, gunakan koma jika nilai dibawah 1)</td></tr>
		   <tr><td>Jumlah Pemilih </td>     <td> : <input type=text name='pemilih'> *) tanpa pemisah koma (contoh : 12000,50000,100000)</td></tr>
		   <tr><td>Jumlah TPS </td>     <td> : <input type=text name='tps'> *) tanpa pemisah koma (contoh : 1250, 850) </td></tr>
		   <tr><td colspan=2><input type=submit value=Buat>
           <input type=button value=Batal onclick=self.history.back()></td></tr>
		  </table></form>";
}
if ($num_rows>=1) {
$aksi="modul/mod_tps/aksi_tps.php";
switch($_GET[act]){
  // Tampil tps
  default:
  echo "<h2>Data Sampel TPS</h2>";
  
  $result = mysql_query('SELECT SUM(total_suara) AS total FROM sms_tps'); 
  $r = mysql_fetch_assoc($result); 
  $sum = $r['total'];
  
  echo" <div class='box'><div class='left'> <b> Total Suara : $sum </b></div> <div class='right'><form method=get action='$_SERVER[PHP_SELF]'>
          <input type=hidden name=module value=tps>
          Masukkan Nama TPS : <input type=text name='nama'> <input type=submit value=Cari>
          </form></div></div>";
		 if (empty($_GET['kata'])){   
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>No</td>
          <td class='left'>Nama TPS</td>
		  <td class='left'>Lokasi</td>
		  <td class='left'>Total Suara</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
		  

  	$p      = new Paging;
    $batas  = 35;
    $posisi = $p->cariPosisi($batas);
    $tampil = mysql_query("SELECT * FROM sms_tps WHERE nama_tps LIKE '%$_GET[nama]%' ORDER BY id_tps  ASC LIMIT $posisi,$batas");
	  	  
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<td class='left'  width='25'>$no</td>
             <td class='left'>$r[nama_tps]</td>
			 <td class='left'>$r[lokasi]</td>
			 <td class='left'>$r[total_suara]</td>
             <td class='center' width='90'><a href=?module=tps&act=edittps&id=$r[id_tps]><img src='images/edit.png' border='0' title='edit' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM sms_tps"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";
    break;
 
  }
  
  case "edittps":
    $edit=mysql_query("SELECT * FROM sms_tps WHERE id_tps='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Data TPS</h2>
          <form method=POST action=$aksi?module=tps&act=update>
          <table class='list'>
          <tr><td class='left'>Nama TPS</td>     <td> : <input type=text name='nama' value='$r[nama_tps]' disabled> </td></tr>
          <tr><td class='left'>Lokasi TPS</td>     <td> : <input type=text name='lokasi' value='$r[lokasi]' size='70'> </td></tr>
          <tr><td class='left'>Total Suara</td>     <td> : <input type=text name='total' value='$r[total_suara]'> </td></tr>
		  <tr><td>Nama Relawan</td>  <td> : <select name='relawan'>";
 
          $tampil=mysql_query("SELECT * FROM sms_relawan ORDER BY nama ASC");
          if ($r[noTelp]==0){
            echo "<option value=0 selected>- Pilih Relawan -</option>";
          }   

          while($w=mysql_fetch_array($tampil)){
            if ($r[noTelp]==$w[noTelp]){
              echo "<option value=$w[noTelp] selected>$w[nama]</option>";
            }
            else{
              echo "<option value=$w[noTelp]>$w[nama]</option>";
            }
          }

    echo "</select></td></tr>
		  <input type='hidden' name='id' value='$r[id_tps]'>
		<tr><td class='left' colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
   break;  
}

}

}
?>
