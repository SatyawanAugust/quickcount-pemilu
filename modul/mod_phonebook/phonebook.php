<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_phonebook/aksi_phonebook.php";
switch($_GET[act]){
  // Tampil phonebook
  default:
  echo "<h2>Phonebook</h2>";
  echo" <div class='box'><div class='left'><input type=button value='Tambah Phonebook' onclick=\"window.location.href='?module=phonebook&act=tambahphonebook';\"></div>
		  <div class='right'><form method=get action='$_SERVER[PHP_SELF]'>
          <input type=hidden name=module value=phonebook>
          Masukkan Nama Phonebook : <input type=text name='nama'> <input type=submit value=Cari>
          </form></div></div>";
		 if (empty($_GET['kata'])){   
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>No</td>
          <td class='left'>Nama</td>
		  <td class='left'>Nomor HP</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
		  

  	$p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);
    $tampil = mysql_query("SELECT * FROM sms_phonebook WHERE nama LIKE '%$_GET[nama]%' ORDER BY NAMA ASC LIMIT $posisi,$batas");
	  	  
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<td class='left'  width='25'>$no</td>
             <td class='left'>$r[nama]</td>
			 <td class='left'>$r[noTelp]</td>
             <td class='center' width='90'><a href=?module=phonebook&act=editphonebook&id=$r[noTelp]><img src='images/edit.png' border='0' title='edit' /></a>
			 <a href=$aksi?module=phonebook&act=hapus&id=$r[noTelp]><img src='images/hapus.png' border='0' title='hapus' /></a>
			  <a href=?module=phonebook&act=kirimsms&id=$r[noTelp]><img src='images/sms.png' border='0' title='kirim sms' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM sms_phonebook"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";
    break;
  }
  case "tambahphonebook":
    echo "<h2>Tambah Phonebook</h2>
          <form method=POST action='$aksi?module=phonebook&act=input'>
          <table class='list'>
         <tr><td>Nama </td>     <td> : <input type=text name='nama'></td></tr>
		  <tr><td>Alamat </td>     <td> : <input type=text name='alamat'></td></tr>
		   <tr><td>Nomor Handphone </td>     <td> : <input type=text name='notelp'></td></tr>
		   <tr><td>Group</td><td>:";
			$query = "SELECT * FROM sms_group";
			$hasil = mysql_query($query);
			while ($r = mysql_fetch_array($hasil))
			{
		  echo "<input type=checkbox name='group[]' value='".$r['idgroup']."'> ".$r['group']."&nbsp;";
		    }
echo"</td></tr>
<tr><td>Tanggal lahir </td>     <td> : <input type=text name='tgllhr'><br>Format: DD-MM-YYYYY, Contoh: 01-12-1988</td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          
		   
		  </table></form>";
     break;
    
  case "editphonebook":
    $id = str_replace(" ","+", $_GET['id']);
    $edit=mysql_query("SELECT * FROM sms_phonebook WHERE noTelp='$id'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Phonebook</h2>
          <form method=POST action=$aksi?module=phonebook&act=update>
          <table class='list'>
          <tr><td class='left'>Nama</td>     <td> : <input type=text name='nama' value='$r[nama]'> </td></tr>
          <tr><td class='left'>Alamat</td>     <td> : <input type=text name='alamat' value='$r[alamat]'> </td></tr>
          <tr><td class='left'>Nomor Telepon</td>     <td> : <input type=text name='notelp' value='$r[noTelp]'> </td></tr>
		   <tr><td class='left'>Group</td><td>:";
		  $splittgl = explode('-', $r['datebirth']);
  			 if (count($splittgl) == 3) $tgllhr = $splittgl[2]."-".$splittgl[1]."-".$splittgl[0]; 
  			 else $tgllhr = "00-00-0000";

 			$group = explode('|', $r['idgroup']);

		$query2 = "SELECT * FROM sms_group";
		$hasil2 = mysql_query($query2);
		while ($r2 = mysql_fetch_array($hasil2))
		{
  		 if (in_array($r2['idgroup'], $group)) echo "<input type='checkbox' name='group[]' value='".$r2['idgroup']."' checked> ".$r2['group']."&nbsp;";
  		 else echo "<input type='checkbox' name='group[]' value='".$r2['idgroup']."'> ".$r2['group']."&nbsp;";
		}
echo"</td></tr>
		  <tr><td>Tanggal lahir </td>     <td> : <input type=text name='tgllhr' value='$tgllhr'><br>Format: DD-MM-YYYYY, Contoh: 01-12-1988</td></tr>
		<input type='hidden' name='notelplama' value='$r[noTelp]'>
		<input type='hidden' name='grouplama' value='$r[idgroup]'>
		<tr><td class='left' colspan=2><input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
   break;  
   
  case "kirimsms":
  $hptujuan = str_replace(" ", "+", $_GET['id']);
  $query = "SELECT nama FROM sms_phonebook WHERE noTelp = '$hptujuan'";
  $hasil = mysql_query($query);
  $r  = mysql_fetch_array($hasil);
  $nama = $r['nama'];
      echo "<h2>Kirim SMS</h2>	  	  
          <form name=form1 method=POST action=$aksi?module=phonebook&act=kirimsms>
          <table class='list'>
		  <input type='hidden' name='phone' value='$hptujuan'>
		  <tr><td class='left'><b>Nomor Tujuan :</b> ".$nama." (".$hptujuan.")</td></tr>
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
