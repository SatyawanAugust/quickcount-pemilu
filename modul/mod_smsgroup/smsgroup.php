<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_smsgroup/aksi_smsgroup.php";
     echo "<h2>Kirim SMS Group</h2>";
   		echo"<div><form name=form1 method=POST action=$aksi?module=smsgroup&act=kirimsmsgroup>
          <table class='list'>
		  <tr><td class='left'><b>Pilih Group Tujuan :<br> 
		  <select name='group'>
		   <option value=0 selected>- Pilih Group -</option>";		    
 		 $query = "SELECT * FROM sms_group order by idgroup asc";
  		 $hasil = mysql_query($query);
  		 while ($r  = mysql_fetch_array($hasil)) {
		 echo "<option value='$r[idgroup]'>$r[group]</option>";
		  }
		  echo"</select>
		  </td></tr>
          <tr><td class='left'>Message  : </td></tr>
          <tr><td><textarea name='pesan' style='width: 350px; height: 120px;' OnFocus='Count();' OnClick='Count();' onKeydown ='Count(); OnChange='Count();' onKeyup='Count();'></textarea></td></tr>
          <tr><td class='left'>Panjang SMS : <input type='text' readonly name='counter' size='3' value='0' /> </td></tr>
		  <tr><td class='left' colspan=2><input type=submit value=Kirim SMS>
          <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form></div>";   

}
?>
