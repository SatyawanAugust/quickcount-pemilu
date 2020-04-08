<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_inbox/aksi_inbox.php";
switch($_GET[act]){
  // Tampil inbox
  default:
    $p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);
    $tampil = mysql_query("SELECT * FROM inbox ORDER BY ID DESC LIMIT $posisi,$batas");
	 	  
  echo "<h2>Inbox</h2>";
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>ISI SMS</td>
		  <td class='left'>Tanggal</td>
		  <td class='left'>Pengirim</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
		  
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){

	$phonebook = mysql_query("SELECT nama FROM sms_phonebook WHERE noTelp = '$r[SenderNumber]'");
	$d=mysql_fetch_array($phonebook);
	if ($d['nama'] == "") $sendername = $r['SenderNumber'];
  	else $sendername = $d['nama'];  
  
       echo "<td class='left'>$r[TextDecoded]</td>
			 <td class='left'>$r[ReceivingDateTime]</td>
			 <td class='left'>$sendername</td>
			 <td class='center' width='90'>
			 <a href=$aksi?module=inbox&act=hapus&id=$r[ID]><img src='images/hapus.png' border='0' title='hapus' /></a>
			  <a href=?module=inbox&act=replysms&id=$r[ID]><img src='images/reply.png' border='0' title='balas sms' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM inbox"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";
    break;
	
	case "replysms":
    $reply=mysql_query("SELECT * FROM inbox WHERE id='$_GET[id]'");
    $r=mysql_fetch_array($reply);
      echo "<h2>Reply SMS</h2>	  	  
          <form name=form1 method=POST action=$aksi?module=inbox&act=replysms>
          <table class='list'>
		  <input type='hidden' name='id' value='$r[id]'>
		  <input type='hidden' name='notelp' value='$r[SenderNumber]'>";		  
		  $phonebook = mysql_query("SELECT nama FROM sms_phonebook WHERE noTelp = '$r[SenderNumber]'");
			$d=mysql_fetch_array($phonebook);
			if ($d['nama'] == "") $sendername = $r['SenderNumber'];
  			else $sendername = $d['nama'];  
		  echo"<tr><td class='left'><b>Nomor Tujuan :</b> $sendername </td></tr>
          <tr><td class='left'>Message  : </td></tr>
          <tr><td><textarea name='pesan' style='width: 350px; height: 120px;' OnFocus='Count();' OnClick='Count();' onKeydown ='Count(); OnChange='Count();' onKeyup='Count();'></textarea></td></tr>
          <tr><td class='left'>Panjang SMS : <input type='text' readonly name='counter' size='3' value='0' /> </td></tr>
		  <tr><td class='left' colspan=2><input type=submit value=Kirim SMS>
          <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";   
  break;
 
}
}
?>
