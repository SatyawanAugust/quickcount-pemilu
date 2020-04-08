<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_sms/aksi_sms.php";
     echo "<h2>Kirim SMS Semua Relawan</h2>";
   		echo"<div><form name=form1 method=POST action=$aksi?module=sms&act=kirimsms>
          <table class='list'>
		  <tr><td class='left'><b>Pilih Nomor Tujuan :<br> 
		  <select name='tujuan[]' multiple='multiple' size='6' style='height: 100%; width= 100%'>";
		  		    
 		 $query = "SELECT noTelp,nama FROM sms_phonebook order by nama asc";
  		 $hasil = mysql_query($query);
  		 while ($r  = mysql_fetch_array($hasil)) {
		 echo "<option value='$r[noTelp]'>$r[nama]</option>";
		  }
		  echo"</select>
		  </br> *)Gunakan tombol Ctrl+Click Untuk mengirim lebih dari 1 tujuan.</td></tr>
          <tr><td class='left'>Message  : </td></tr>
          <tr><td><textarea name='pesan' style='width: 350px; height: 120px;' OnFocus='Count();' OnClick='Count();' onKeydown ='Count(); OnChange='Count();' onKeyup='Count();'></textarea></td></tr>
          <tr><td class='left'>Panjang SMS : <input type='text' readonly name='counter' size='3' value='0' /> </td></tr>
		  <tr><td class='left' colspan=2><input type=submit value=Kirim SMS>
          <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div>";   

}
?>
