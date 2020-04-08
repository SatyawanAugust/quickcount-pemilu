<?php
error_reporting(0);
include "../../config/koneksi.php";
include "../../fusioncharts/class/FusionCharts_Gen.php";


?>
<html>
  <head>
    <title>Hasil Rekapitulasi Suara Quick Count Pemilu</title>
    <script language='javascript' src='../../fusioncharts/js/FusionCharts.js'></script>
	<link href='../../style.css' rel='stylesheet' type='text/css'>
  </head>
  <body>

  <?php
  # Include FusionCharts PHP Class
  # Create object for Column 3D chart
  $FC = new FusionCharts("Column3D","850","550");

  # Setting Relative Path of chart swf file.
  $FC->setSwfPath("../../fusioncharts/Charts/");

  # Store chart attributes in a variable
  $strParam="caption=Hasil Penghitungan Suara Quick Count; xAxisName=Nama Calon (Dalam Persentase) ;yAxisName=Persentase;decimalPrecision=2; formatNumberScale=0";

  # Set chart attributes
  $FC->setChartParams($strParam);
  
   	
$query = "SELECT * FROM sms_tps";
$hasil = mysql_query($query);
$total1=0;
$total2=0;
$total3=0;
$total4=0; 
while ($data = mysql_fetch_array($hasil))
{

  // membaca no pengirim
  $suara = $data['suara'];
 // memecah data suara
  $pecah = explode("#", $suara);
   		
	 $suara1 = $pecah[2];
	 $suara2 = $pecah[3];
	 $suara3 = $pecah[4];
	 $suara4 = $pecah[5];
	 
	 $total1 = $total1+$suara1;
	 $total2 = $total2+$suara2;
	 $total3 = $total3+$suara3;
	 $total4 = $total4+$suara4;
	 	
}
  $result = mysql_query('SELECT SUM(total_suara) AS total FROM sms_tps'); 
  $r = mysql_fetch_assoc($result); 
  $sum = $r['total'];

  $persentase1 = ($total1/$sum)*100;
  $persentase2 = ($total2/$sum)*100;
  $persentase3 = ($total3/$sum)*100;
  
  $persentase4 = ($total4/$sum)*100;

  $querycalon = mysql_query("SELECT calon, wacalon FROM sms_calon order by nomorcalon ASC");
	while ($r = mysql_fetch_array($querycalon)){

	$calon[] = $r['calon'];
	$wacalon[] = $r['wacalon'];

}
 # add chart values and category names
  $FC->addChartData("$persentase1","name=$calon[0] & $wacalon[0]");
  $FC->addChartData("$persentase2","name=$calon[1] & $wacalon[1]");
  $FC->addChartData("$persentase3","name=$calon[2] & $wacalon[2]");
 
    # Render Chart
    $FC->renderChart();
	
	$suaramsk = (($total1+$total2+$total3+$total4)/$sum)*100;
	$suaramasuk = sprintf('%0.2f', $suaramsk); 
	$suaratidaksah = sprintf('%0.2f', $persentase4);
	
	echo " Jumlah Suara Masuk ="; echo $suaramasuk; echo "%"; echo "<br>";
	echo " Jumlah Suara Tidak Sah = "; echo $suaratidaksah ; echo "%";
  ?>

  </body>
</html>