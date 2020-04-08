<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_outbox/aksi_outbox.php";
    $p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);
    $tampil = mysql_query("SELECT * FROM outbox ORDER BY ID DESC LIMIT $posisi,$batas");
	 	  
  echo "<h2>Outbox</h2>";
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>ISI SMS</td>
		  <td class='left'>Tanggal Kirim</td>
		  <td class='left'>Tujuan</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
		  
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){

	$phonebook = mysql_query("SELECT nama FROM sms_phonebook WHERE noTelp = '$r[DestinationNumber]'");
	$d=mysql_fetch_array($phonebook);
	if ($d['nama'] == "") $sendingname = $r['DestinationNumber'];
  	else $sendingname = $d['nama'];  
  
       echo "<td class='left'>$r[TextDecoded]</td>
			 <td class='left'>$r[SendingDateTime]</td>
			 <td class='left'>$sendingname</td>
			 <td class='center' width='90'>
			 <a href=$aksi?module=outbox&act=hapus&id=$r[ID]><img src='images/hapus.png' border='0' title='hapus' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM outbox"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";

}
?>
