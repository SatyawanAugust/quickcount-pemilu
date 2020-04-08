<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";
include "class_paging.php";
include_once 'config/cek_sesi.php';

// Bagian Home
if ($_GET['module']=='home'){
$jam=date("H:i:s");
$tgl=tgl_indo(date("Y m d")); 	
  echo "<br /><p align=center>Hai <b>$_SESSION[namauser]</b>, selamat datang di halaman Administrator. 
Silahkan klik menu pilihan yang berada di bagian header dan cpanel untuk mengelola content website pemilu. <br /> <b>$hari_ini, $tgl, $jam </b>WIB</p><br />";



  echo "<table class='list'><thead>
		<td class='center' colspan=7><center>Control Panel</center></td></thead>
		<tr>
				  <td width=120 align=center><a href=media.php?module=service><img src=images/modem.png border=none><br /><b>Service Gammu</b></a></td> 
		  <td width=120 align=center><a href=media.php?module=inbox><img src=images/inbox.png border=none><br /><b>Inbox</b></a></td>
		  <td width=120 align=center><a href=media.php?module=outbox><img src=images/outbox.png border=none><br /><b>Outbox</b></a></td>
		  <td width=120 align=center><a href=media.php?module=sentitem><img src=images/sentitems.png border=none><br /><b>Sent Item</b></a></td>
		  <td width=120 align=center><a href=media.php?module=group><img src=images/group.jpg border=none><br /><b>Group Phonebook</b></a></td>
		  <td width=120 align=center><a href=media.php?module=phonebook><img src=images/phonebook.png border=none><br /><b>Phonebook</b></a></td>
 <td width=120 align=center><a href=media.php?module=sms><img src=images/smsicon.png border=none><br /><b>Kirim SMS</b></a></td>
    </tr>
		<tr>
		<td width=120 align=center><a href=media.php?module=smsgroup><img src=images/smsgroup.png border=none><br /><b>Kirim SMS Group</b></a></td>
		  <td width=120 align=center><a href=media.php?module=smsrelawan><img src=images/kotaksuara.png border=none><br /><b>SMS Relawan</b></a></td>

		  <td width=120 align=center><a href=media.php?module=calon><img src=images/user.jpg border=none><br /><b>Data Calon</b></a></td>
		  <td width=120 align=center><a href=media.php?module=relawan><img src=images/saksi.png border=none><br /><b>Data Relawan</b></a></td>
		  <td width=120 align=center><a href=media.php?module=tps><img src=images/tps.png border=none><br /><b>Data TPS</b></a></td>
		  		 
		 <td width=120 align=center><a href=modul/mod_auto/autosuara.php target=_blank><img src=images/autoreply.jpg border=none><br /><b>Service Autoreply</b></a></td>
		  <td width=120 align=center><a href=modul/mod_hasil/hasilpemilu.php target=_blank><img src=images/poling.png border=none><br /><b>Hasil Pemilu</b></a></td>
    </tr>
    </table>";
}

// Bagian Group
elseif ($_GET['module']=='group'){
    include "modul/mod_group/group.php";
}

// Bagian Phonebook
elseif ($_GET['module']=='phonebook'){
    include "modul/mod_phonebook/phonebook.php";
}


// Bagian Kirim SMS
elseif ($_GET['module']=='sms'){
    include "modul/mod_sms/sms.php";
}

// Bagian Kirim SMS Group
elseif ($_GET['module']=='smsgroup'){
    include "modul/mod_smsgroup/smsgroup.php";
}

// Bagian inbox
elseif ($_GET['module']=='inbox'){
    include "modul/mod_inbox/inbox.php";
}

// Bagian outbox
elseif ($_GET['module']=='outbox'){
    include "modul/mod_outbox/outbox.php";
}

// Bagian sentitem
elseif ($_GET['module']=='sentitem'){
    include "modul/mod_sentitem/sentitem.php";
}

// Bagian Service gammu
elseif ($_GET['module']=='service'){
    include "modul/mod_service/service.php";
}

// Bagian Admin
elseif ($_GET['module']=='admin'){
    include "modul/mod_admin/admin.php";
}

// Bagian Relawan
elseif ($_GET['module']=='relawan'){
    include "modul/mod_relawan/relawan.php";
}

// Bagian Calon 
elseif ($_GET['module']=='calon'){
    include "modul/mod_calon/calon.php";
}

// Bagian SMS Relawan 
elseif ($_GET['module']=='smsrelawan'){
    include "modul/mod_smsrelawan/smsrelawan.php";
}

// Bagian data tps
elseif ($_GET['module']=='tps'){
    include "modul/mod_tps/tps.php";
}

// Bagian hasil pemilu
elseif ($_GET['module']=='hasil'){
    include "modul/mod_hasil/hasil.php";
}

// Bagian Service autoreply
elseif ($_GET['module']=='autoreply'){
   include "modul/mod_auto/autosuara.php";
}

// Bagian Hasil Pemilu
elseif ($_GET['module']=='hasilpemilu'){
    include "modul/mod_hasil/hasilpemilu.php";
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}
?>
