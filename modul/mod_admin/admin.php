<?php
$aksi="modul/mod_admin/aksi_admin.php";
    $sql  = mysql_query("SELECT * FROM sms_user LIMIT 1");
    $r    = mysql_fetch_array($sql);

    echo "<h2>Ganti Username & Password Administrator</h2>
          <form method=POST action=$aksi?module=admin&act=update>
          <input type=hidden name=id value=$r[id]>
          <table class='list'><tbody>
          <tr><td class='left'>Username</td><td> : <input type=text name='username' value='$r[username]' size=40></td></tr>
          <tr><td class='left'>Password</td><td> : <input type=text name='password'  size=40>*)</td></tr>
          <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br /><input type=submit value=Update>
                           <input type=button value=Batal onclick=self.history.back()></td></tr>
         <tbody></form></table>";
?>
