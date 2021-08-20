<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php

	$sunucu_adi = "localhost";
	$kullanici_adi= "root";
	$sifre = "123456rte";
	$vt = "zirve_satis_destek";

	$baglanti = new mysqli($sunucu_adi, $kullanici_adi, $sifre, $vt);

	mysqli_set_charset($baglanti,"utf8");
	if ($baglanti->connect_error)
		die("bağlantı sağlanamadı".$baglanti->connect_error);

include("src/SimpleXLSX.php");

if ( $xlsx = SimpleXLSX::parse('ff.xlsx') ) {
    //print_r( $xlsx->rows() );
	//echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
	foreach( $xlsx->rows() as $r ) {
		//echo '<tr><td>'.implode('</td><td>', $r ).'</td></tr>';
		//print_r( $r[1]."<br>" );
		echo $r[0]."<br>" ;
		
		/*		$kayit_sql = "INSERT INTO `memleket` (`idmemleket`, `memleket`) VALUES (NULL, '".$_POST['memleket']."')";
			$baglanti->query($kayit_sql);	
		*/
		
	}
	echo '</table>';
	// or $xlsx->toHTML();	
	
} else {
    echo SimpleXLSX::parse_error();
}



?>

</body>
</html>