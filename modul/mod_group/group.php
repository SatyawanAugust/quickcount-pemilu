<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_group/aksi_group.php";
switch($_GET[act]){
  // Tampil group
  default:
  
  	$p      = new Paging;
    $batas  = 15;
    $posisi = $p->cariPosisi($batas);
      $tampil = mysql_query("SELECT * FROM sms_group ORDER BY idgroup ASC LIMIT $posisi,$batas");
      echo "<h2>Group Phonebook</h2>
          <input type=button value='Tambah group' onclick=\"window.location.href='?module=group&act=tambahgroup';\">";
   
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>ID Group</td>
          <td class='left'>Nama Group</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
    $no = $posisi+1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<td class='left'  width='25'>$r[idgroup]</td>
             <td class='left'>$r[group]</td>
             <td class='center' width='70'><a href=?module=group&act=editgroup&idgroup=$r[idgroup]><img src='images/edit.png' border='0' title='edit' /></a>
			 <a href=$aksi?module=group&act=hapus&idgroup=$r[idgroup]><img src='images/hapus.png' border='0' title='hapus' /></a>
			 </td></tr>";
      $no++;
    }
    echo "</table>";
	
    $jmldata = mysql_num_rows(mysql_query("SELECT * FROM sms_group"));
   
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

echo "<div class=\"pagination\"> $linkHalaman</div>";
    break;
  
  case "tambahgroup":
    echo "<h2>Tambah Group</h2>
          <form method=POST action='$aksi?module=group&act=input'>
          <table class='list'>
         <tr><td>Nama Group</td>     <td> : <input type=text name='namagroup'></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
  case "editgroup":
    $edit=mysql_query("SELECT * FROM sms_group WHERE idgroup='$_GET[idgroup]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Group</h2>
          <form method=POST action=$aksi?module=group&act=update>
          <table class='list'>
          <tr><td class='left'>ID Group</td>     <td> : <input type=text name='idgroup' value='$r[idgroup]' disabled> </td></tr>
          <tr><td class='left'>Nama Group</td>     <td> : <input type=text name='namagroup' value='$r[group]'> </td></tr>
		  <input type='hidden' name='id' value='$r[idgroup]'>";
		  echo "<tr><td class='left' colspan=2><input type=submit value=Update>
               <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
   break;  
}
}
?>
