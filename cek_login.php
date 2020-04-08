<?php
include "config/koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
$login=mysql_query("SELECT * FROM sms_user WHERE username='$username' AND password='$pass'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  $_SESSION[login] = 1;
  $_SESSION[username]     = $r[username];
  $_SESSION[passuser]     = $r[password];
  
  header('location:media.php?module=home'); 
}
else{
   // Login gagal
	?>
  <script language="javascript">
			alert("Maaf, Username atau Password Anda salah!!");
			document.location="index.php";
	</script>
  <?php  
}
}
?>
