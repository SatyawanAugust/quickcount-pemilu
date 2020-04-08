<?php
include "config/koneksi.php";
include_once 'config/cek_sesi.php';

echo "<ul> 
        <li><a href=?module=home>Home</a></li>
		<li><a href=?module=group>Group</a></li>
		<li><a href=?module=phonebook>Phonebook</a></li>
		<li><a href=?module=calon>Data Calon</a></li>
		<li><a href=?module=tps>Data TPS</a></li>
		<li><a href=?module=relawan>Data Relawan</a></li>
		<li><a href=modul/mod_auto/autosuara.php target=_blank>Service AutoReply</a></li>
		<li><a href=?module=admin>Ubah Password</a></li>

</ul>";
 
?>
