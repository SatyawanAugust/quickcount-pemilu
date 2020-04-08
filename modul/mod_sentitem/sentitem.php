<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_sentitem/aksi_sentitem.php";
    $p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);
    $tampil = mysql_query("SELECT * FROM sentitems ORDER BY ID DESC LIMIT $posisi,$batas");
	 	  
  echo "<h2>Sentitem</h2>";
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>ISI SMS</td>
		  <td class='left'>Waktu Terkirim</td>
		  <td class='left'>Tujuan</td>
		  <td class='left'>Status Kirim</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
		  
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){

	$phonebook = mysql_query("SELECT nama FROM sms_phonebook WHERE noTelp = '$r[DestinationNumber]'");
	$d=mysql_fetch_array($phonebook);
	if ($d['nama'] == "") $sendingname = $r['DetinationNumber'];
  	else $sendingname = $d['nama'];  
  
       echo "<td class='left'>$r[TextDecoded]</td>
			 <td class='left'>$r[SendingDateTime]</td>
			 <td class='left'>$sendingname</td>
			 <td class='left'>$r[Status]</td>
			 <td class='center' width='90'>
			 <a href=$aksi?module=sentitem&act=hapus&id=$r[ID]><img src='images/hapus.png' border='0' title='hapus' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM sentitems"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";

}
?>
