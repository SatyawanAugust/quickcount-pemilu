<?php    
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_calon/aksi_calon.php";
switch($_GET[act]){
  // Tampil calon
  default:
    echo "<h2>Data Calon dan Wakil Calon Pemilu</h2>";
	echo" <div class='box'><div class='left'><input type=button value='Tambah Calon' onclick=\"window.location.href='?module=calon&act=tambahcalon';\"></div></div>";
  
      echo "<table class='list'><thead>  
          <tr><td class='left' width='75'>Nomor Calon</td>
          <td class='left'>Nama Calon</td>
          <td class='left'>Nama Wakil Calon</td>
		  <td class='center'>Foto</td>
          <td class='center'>aksi</td>
          </tr></thead>";

      $tampil = mysql_query("SELECT * FROM sms_calon ORDER BY id_calon ASC");

    while($r=mysql_fetch_array($tampil)){

      echo "    <td class='left'>$r[nomorcalon]</td>
                <td class='left'>$r[calon]</td>
				<td class='left'>$r[wacalon]</td>
				<td class='center'><img src='modul/mod_calon/foto/small_$r[foto]'> </td>
		            <td class='center' width='85'><a href=?module=calon&act=editcalon&id=$r[id_calon]><img src='images/edit.png' border='0' title='edit' /></a>
		                <a href=\"$aksi?module=calon&act=hapus&id=$r[id_calon]&namafile=$r[foto]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapus data calon?')\"><img src='images/hapus.png' border='0' title='hapus' /></a></td>
		        </tr>";
    }
    echo "</table>";
 break;    


  case "tambahcalon":
    echo "<h2>Tambah Calon</h2>
          <form method=POST action='$aksi?module=calon&act=input' enctype='multipart/form-data'>
          <table class='list'><tbody>
          <tr><td width=70>Nomor Calon</td>     <td> : <input type=text name='nomor'> *) Isi Dengan 1,2,3...dst</td></tr>
        <tr><td width=70>Nama Calon</td>     <td> : <input type=text name='calon' size='60'></td></tr>
		<tr><td width=70>Nama Wakil Calon</td>     <td> : <input type=text name='wacalon' size='60'></td></tr>
          <tr><td>Foto</td>      <td> : <input type=file name='fupload' size=40> 
                                          <br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>
		</td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </tbody></table></form>";
     break;
    
    
  case "editcalon":
      $edit = mysql_query("SELECT * FROM sms_calon WHERE id_calon='$_GET[id]'");
      $r    = mysql_fetch_array($edit);

    echo "<h2>Edit Data Calon</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=calon&act=update>
          <input type=hidden name=id value=$r[id_calon]>
          <table class='list'><tbody>
          <tr><td width=70>Nomor Calon</td>     <td> : <input type=text name=\"nomor\" value=\"$r[nomorcalon]\"></td></tr>
         </td></tr>
		 <tr><td width=70>Nama Calon</td>     <td> : <input type=text name=\"calon\" value=\"$r[calon]\"></td></tr>
         </td></tr>
		 <tr><td width=70>Nama Wakil Calon</td>     <td> : <input type=text name=\"wacalon\" value=\"$r[wacalon]\"></td></tr>
         </td></tr>
		 
        <tr><td>Foto</td>       <td> :  ";
          if ($r[foto]!=''){
              echo "<img src='modul/mod_calon/foto/$r[foto]'>";  
          }
    echo "</td></tr>
          <tr><td>Ganti Foto</td>    <td> : <input type=file name='fupload' size=30> *)Apabila foto tidak diubah, dikosongkan saja.</td></tr>";

    echo  "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </tbody></table></form>";
    break;  
}

}
?>
