<html>
<head>
<!-- refresh script setiap 30 detik -->
<meta http-equiv="refresh" content="10; url=<?php $_SERVER['PHP_SELF']; ?>">
</head>
<body>
<h1>SMS server running....</h1>
<h1>Jangan Tutup Browser ini selama waktu pengiriman data suara dari relawan....</h1>

<?php
include "../../config/koneksi.php";
// query untuk membaca SMS yang belum diproses
$query = "SELECT * FROM inbox WHERE Processed = 'false'";
$hasil = mysql_query($query);
while ($data = mysql_fetch_array($hasil))
{

  // membaca ID Pesan
  $id = $data['ID'];

  // membaca no pengirim
  $noPengirim = $data['SenderNumber'];

  // membaca pesan SMS dan mengubahnya menjadi kapital
  $pesan = strtoupper($data['TextDecoded']);

  // proses parsing 

  // memecah pesan berdasarkan karakter <#>
  $pecah = explode("#", $pesan);

  //Format Quick Count 
  // QC#NOMOR TPS#SUARA A#SUARA B#SUARA C#SUARA TIDAK SAH
  
  // jika kata terdepan dari SMS adalah 'NILAI' maka cari nilai Kalkulus
  if ($pecah[0] == "QC")
  {
     // baca Nomor TPS dari pesan SMS
     $tps 	 = $pecah[1];
	 $suara1 = $pecah[2];
	 $suara2 = $pecah[3];
	 $suara3 = $pecah[4];
	 $suara4 = $pecah[5];

     // cari Nomor TPS dan realwan berdasar Pesan
     $query2 = "SELECT * FROM sms_tps WHERE nama_tps = '$tps' AND noTelp = '$noPengirim'";
     $hasil2 = mysql_query($query2);
	 $r=mysql_fetch_array($hasil2);
	 $total_suara=$r['total_suara'];

     // cek bila data TPS dan relawan 
	 //jika tps atau relawan tidak ditemukan 
     if (mysql_num_rows($hasil2) == 0) $reply = "Nomor TPS Atau Relawan tidak ditemukan";
     else
     {
	 	// bila data TPS ditemukan
	 	//Validasi jika total suara yang dikirim melebihi/kurang dari total suara
		$totaldikirim = $suara1+$suara2+$suara3+$suara4;
		if ($total_suara==$totaldikirim) {
		// jika total suara di database sama dengan total suara dikirim , maka update data suara ke field suara di tabel sms_tps
	  	$query6 = "UPDATE sms_tps SET suara = '$pesan' WHERE nama_tps = '$tps' AND noTelp = '$noPengirim'";
  	  	$hasil6 = mysql_query($query6);
	  	$reply = "Data TPS Anda sudah masuk dalam sistem";
		}else //jika format atau total suara salah dikirim
		$reply = "Cek lagi suara yg dikirim, data salah/kurang/melebihi total suara di tps Anda";
	 }
 // membuat SMS balasan
  $query3 = "INSERT INTO outbox(DestinationNumber, TextDecoded) VALUES ('$noPengirim', '$reply')";
  $hasil3 = mysql_query($query3);
  }
  // ubah nilai 'processed' menjadi 'true' untuk setiap SMS yang telah diproses
  $query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
  $hasil3 = mysql_query($query3);
}

?>

</body>
</html>