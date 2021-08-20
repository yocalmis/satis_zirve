<?php
/**
 * ORKESTRA EFATURACIM PHP API DEMOSU
 * @author Volkan  GUNAYDIN
 * 
 * GUNCEL KUTUPHANE : https://efaturacim.orkestra.com.tr/servis.php?action=download
 * DEMO SCRIPT : https://efaturacim.orkestra.com.tr/servis.php?action=demo
 * 
 */

// KUTUPHANEYI YUKLEYIN
require_once("efaturacim_service.php");
$conf = array("musteri"=>"zirveinternet","kullanici"=>"zirveinternet","sifre"=>"958162","url"=>"https://b2.orkestra.com.tr/efaturacim/servis.php","apikey"=>"93a1683d714b01643de1eca115ca3e5aab43be602f137a6f2a101dc05ffed49851e9607306d6685d8cfc33e9dc98866314b612a88e05c1899123eb5ea3fdcf1d62e3fdc1f5265b813c4da1cf203896c5ce4f369e716be911523cb2d29819a505f2db4e155fe65d4bbb2dbabfe8b29b5b13556856457e554b53e64e8e48f0be07c07bbd798998cc250b2a971307b038d0");

$efaturacim  = new EFATURACIM_ISTEMCI($conf);

// ALTTAKI 3 SATIR SADECE LINK OLUSTURMA AMACLIDIR 
$MYSCRIPT_NAME   = "efaturacim_service_demo.php";
$ORG_SCRIPTNAME = @$_SERVER["SCRIPT_NAME"];
if(substr($ORG_SCRIPTNAME, -1*strlen($MYSCRIPT_NAME))!==$MYSCRIPT_NAME){ $MYSCRIPT_NAME = substr($ORG_SCRIPTNAME, strrpos($ORG_SCRIPTNAME, '/') + 1); }


function getOrnekFaturaArray(){
	$FATURA_DATA = array(
			"FATURA NO"=>"OTOMATİK",
			"FATURA TARİHİ"=>date("Y-m-d"),
			"CARİ ADI"=>"TEST A.Ş.",
			"CARİ VERGİNO"=>"65401211066",
			"CARİ VERGİ DAİRESİ"=>"Mutlu Vergi Dairesi",
			"ADRES CADDE"=>"Olmayan Mahalle",
			"ADRES SOKAK"=>"Çıkmaz Sokak No:5",	
			"ADRES İL"=>"Ankara",
			"ADRES İLÇE"=>"Çankaya",
			"SATIR 1 KOD"=>"KOD1",
			"SATIR 1 AÇIKLAMA"=>"ACIKLAMA 1",
			"SATIR 1 MİKTAR"=>"3",
			"SATIR 1 BİRİM"=>"ADET",
			"SATIR 1 BİRİM FİYAT"=>5,
			"SATIR 1 KDV ORANI"=>8,
			"SATIR 2 KOD"=>"KOD2",
			"SATIR 2 AÇIKLAMA"=>"ACIKLAMA 2",
			"SATIR 2 MİKTAR"=>"7",
			"SATIR 2 BİRİM"=>"ADET",
			"SATIR 2 BİRİM FİYAT"=>10,
			"SATIR 2 KDV ORANI"=>18,
			"FATURA SENARYOSU"=>"TİCARİ",
	);
	return $FATURA_DATA;
}

// ORNEK ISLEMLERI DAHA KOLAY KULLANMAK ICIN AYRI AYRI SAYFA CAGIRIYORUZ
$sayfa = @$_GET["sayfa"];
if($sayfa==""){
	// MENU GOSTER
	$btnStyle = ' style="text-align:left;margin-top:10px;" ';
	$htmlStr = '<div class="container">';
	$htmlStr .= '<h2>E-FATURACIM ÖRNEK UYGULAMA EKRANI</h2>';
	$htmlStr .= '<div>';
	$htmlStr .= '<b>Sunucu Adresi : </b>'.$efaturacim->_baseUrl;
	$htmlStr .= '<br/><b>Kullanıcı Bilgisi: </b>'.$efaturacim->_musteri."|".$efaturacim->_kullanici;
	$htmlStr .= '</div>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=login" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >KULLANICI ADI VE ŞİFRE KONTROLÜ</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=kontor" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Kontör Sorgulama</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=vkn_sorgu" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Vergi Kimlik Numarası Sorulama</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=fatura_sorgula" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Sorgulama</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=fatura_sorgula2" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Sorgulama * (Alternatif Arama)</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=fatura_bilgisi" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Sorgulama ( XML ve HTML )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=fatura_sorgula_son" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Sorgulama ( Son Gönderilen/Alınan Faturalar )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=etiket" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Etiket Sorgulama</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=kabul" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Kabul</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=red" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Red</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=gonder_onizleme" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Önizleme</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=gonder_array" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Gönder ( Array )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=gonder_csv" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Gönder ( CSV )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=gonder_xml" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Gönder ( XML )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=gonder_dosya" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >Fatura Gönder ( Dosya )</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=earsiv_params" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >E-Arşiv Parametrelerinin Eklenmesi</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=eposta_gonder1" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >E-Arşiv Faturası Posta Gönderimi</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=eposta_gonder2" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >E-Fatura Posta Gönderimi</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=earsiv_iptal" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >E-Arşiv Fatura İptali</a>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=earsiv_cikart" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >E-Arşiv Fatura Çıkartma</a>';
	$htmlStr .= '<hr/>';
	$htmlStr .= '<a href="'.$MYSCRIPT_NAME.'?sayfa=sms" class="btn btn-block btn-primary" '.$btnStyle.' target="_blank" >SMS Gönder</a>';
	$htmlStr .= '<br/>&nbsp;<br/>&nbsp;<br/>';
	$htmlStr .= '</div>';
	$efaturacim->showAsHtml($htmlStr,"E-FATURACIM ÖRNEK UYGULAMA EKRANI");
}else if ($sayfa=="login"){
	// Bu fonksiyon sonucunda boolean *( true/false ) doner
	$sonuc = $efaturacim->login();
	// Bu fonksiyon ile çıkış yapılır.
	$efaturacim->logout();
	// login ve logout isteğe bağlı olarak kullanılır. işlem login gerektiriyorsa otomatik login çağırılır.
	// login fonksiyonunu çok sık kullanmayınız. Saatlik kullanım adetidolduğu zaman api kullanımı kısıtanacaktır.  
	if($sonuc){
		$efaturacim->showAsHtml("Kullanıcı adı ve şifre doğru.","E-FATURACIM ÖRNEK UYGULAMA EKRANI","success");
	}else{
		$efaturacim->showAsHtml("Kullanıcı adı ve şifreniz uygun değil.<br/>Gelen cevap:<br/>".$efaturacim->_lastMsg,"E-FATURACIM ÖRNEK UYGULAMA EKRANI","danger");
	}
}else if ($sayfa=="kontor"){
	$kalanKontor = $efaturacim->kalanKontorSayisi();
	$detayliKontor = $efaturacim->kontorDetayi();
	$efaturacim->showVariablesAsHtml(
			array("kalanKontor"=>$kalanKontor,"detayliKontor"=>$detayliKontor),
			"E-FATURACIM KONTÖR SORGULAMA"
	);
}else if ($sayfa=="vkn_sorgu"){	
	$gyazilim = $efaturacim->vknSorgula("9980743690");
	$maliye    = $efaturacim->vknSorgula("9980743690");
	$tc_kimlik = $efaturacim->vknSorgula("9980743690");
	$efaturacim->showVariablesAsHtml( 
			array("gyazilim"=>$gyazilim,"maliye"=>$maliye,"tc_kimlik"=>$tc_kimlik),
			"E-FATURACIM VKN SORGULAMA SONUÇLARI" 
	);
}else if ($sayfa=="fatura_sorgula"){	
	//faturaSorgula($baslangic=null,$bitis=null,$tip="hepsi",$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi="",$kayitNo=""){
	// tip : [ gelen,giden,hepsi ]
	// tarihler yil-ay-gun formatinda verilmelidir. 
	$fatura_sorgusu = $efaturacim->faturaSorgula();
	$basilacak= array();
	if($fatura_sorgusu["isok"] && count($fatura_sorgusu["data"])>0 && count(@$fatura_sorgusu["data"]["efatura"])>0){
		$basilacak["efatura_ornegi"] = @$fatura_sorgusu["data"]["efatura"][0];
	}
	if($fatura_sorgusu["isok"] && count($fatura_sorgusu["data"])>0 && count(@$fatura_sorgusu["data"]["earsiv"])>0){
		$basilacak["earsiv_ornegi"] = @$fatura_sorgusu["data"]["earsiv"][0];
	}
	$basilacak["fatura_sorgusu"] = $fatura_sorgusu;
	$efaturacim->showVariablesAsHtml($basilacak,"E-FATURACIM FATURA SORGULAMA SONUÇLARI");
}else if ($sayfa=="fatura_sorgula2"){
	//gelenFaturalar($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi=""){
	//gelenFaturaListesi($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi=""){
	$gelen_faturalar= $efaturacim->gelenFaturaListesi();	
	$giden_faturalar= $efaturacim->gidenFaturaListesi();
	$efaturacim->showVariablesAsHtml(array("gelen_faturalar"=>$gelen_faturalar,"giden_faturalar"=>$giden_faturalar),"E-FATURACIM FATURA SORGULAMA SONUÇLARI");
}else if ($sayfa=="fatura_sorgula_son"){
	$gunSayisi = 7;
	$gelen_faturalar = $efaturacim->sonAlinanFaturalar($gunSayisi);
	$giden_faturalar = $efaturacim->sonGonderilenFaturalar($gunSayisi);
	$efaturacim->showVariablesAsHtml(array("gelen_faturalar"=>$gelen_faturalar,"giden_faturalar"=>$giden_faturalar),"E-FATURACIM FATURA SORGULAMA SONUÇLARI");
}else if ($sayfa=="fatura_bilgisi"){
	$htmlPost = "";
	$basilacak= array();
	$gelen_faturalar = $efaturacim->gelenFaturaListesi();	
	if(count($gelen_faturalar)>0 ){
		$basilacak["fatura"] = $gelen_faturalar[0];		
		$fatura_al = $efaturacim->faturaAl(@$basilacak["fatura"]["kayitno"],"efatura");
		$xml_data   = @$fatura_al["data"]["efatura_xml"];
		$html_data = @$fatura_al["data"]["efatura_html"];
		$htmlPost = '<div class="container"><b>FATURA GÖRÜNTÜSÜ</b><br/><iframe src="'.$MYSCRIPT_NAME.'?sayfa=fatura_bilgisi&show=html" frameborder="0" style="width:100%;height:1800px;" ></iframe></div>';
		if(@$_GET["show"]=="html"){
			echo $html_data;
			die("");
		}
	}	
	$efaturacim->showVariablesAsHtml($basilacak,"E-FATURACIM FATURA SORGULAMA SONUÇLARI",null,$htmlPost);
}else if ($sayfa=="etiket"){
	$etiket  =$efaturacim->etiketListele();
	$efaturacim->showVariablesAsHtml(array("etiket"=>$etiket),"E-FATURACIM ETİKET SONUÇLARI");
}else if ($sayfa=="kabul"){
	$sonuc = $efaturacim->faturaKabul("KABUL EDILDI","EFA2016000000028");
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"FATURA KABUL SONUCU");
}else if ($sayfa=="red"){
	$sonuc = $efaturacim->faturaRed("RED EDILDI","ORK2016000000009");
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"FATURA RED SONUCU");
}else if ($sayfa=="gonder_onizleme"){		
	// faturaYukleArrayData($faturaData,$previewOnly=false){
	// faturaYukleXmlString($xmlAsString="",$postaKutusu=null,$earsivParmetreleri=null,$previewOnly=false){
	// faturaYukleDosyadan($dosyaYolu,$postaKutusu=null,$earsivParmetreleri=null,$previewOnly=false){
	$faturaData = getOrnekFaturaArray();
	$sonuc        = $efaturacim->faturaYukleArrayData($faturaData,true);
	$htmlString = $sonuc["data"]["html"];	
	$efaturacim->showVariablesAsHtml(array("faturaData"=>$faturaData,"sonuc"=>$sonuc,"htmlString"=>$htmlString),"FATURA ÖNİZLEME");
}else if ($sayfa=="gonder_array"){	
	$faturaData = getOrnekFaturaArray();
	$sonuc        = $efaturacim->faturaYukleArrayData($faturaData);
	$efaturacim->showVariablesAsHtml(array("faturaData"=>$faturaData,"sonuc"=>$sonuc),"FATURA GÖNDER ( ARRAY )");
}else if ($sayfa=="gonder_csv"){
	$faturaData   = getOrnekFaturaArray();
	$csvString    = $efaturacim->createCsvFromArray($faturaData);
	$sonuc        = $efaturacim->faturaYukleCsvData($csvString);
	$efaturacim->showVariablesAsHtml(array("csvString"=>@$csvString,"sonuc"=>@$sonuc),"FATURA GÖNDER ( CSV )");
}else if ($sayfa=="gonder_xml"){		
	$dosya = "efatura.xml";
	if(file_exists($dosya)){
		$xmlAsString = readfile($dosya);
		$sonuc        = $efaturacim->faturaYukleXmlString($xmlAsString);
		$efaturacim->showVariablesAsHtml(array("xmlAsString"=>@$xmlAsString,"sonuc"=>@$sonuc),"FATURA GÖNDER ( XML )");
	}else{
		$efaturacim->showAsHtml("XML dosyası buunamdı.","E-FATURACIM FATURA GÖNDERME","danger");
	}
}else if ($sayfa=="gonder_dosya"){
	// XML DOSYA GONDERIMI
	$dosyaYolu = "efatura.xml";
	$sonuc        = $efaturacim->faturaYukleDosyadan($dosyaYolu);
	$efaturacim->showVariablesAsHtml(array("dosyaYolu"=>@$dosyaYolu,"sonuc"=>@$sonuc),"FATURA GÖNDER ( DOSYADAN )");
}else if ($sayfa=="earsiv_params"){	
	// EARSIV PARAMETRELERI ICIN FONKSIYON YADA ARRAY KULLANILABILIR
	//  faturaYukleXmlString($xmlAsString="",$postaKutusu=null,$earsivParmetreleri=null,$previewOnly=false);

	// DAHA GÜVENLİ YOL ; FONKSİYON ÇAĞIRMAKTIR
	$efaturacim->earsiv_set_odeme("eft","2016-05-11","Banka dan ödenmiştir.");
	// BENZER FONKSIYONLAR
	//	earsiv_set_odeme_as_eft($odemeTarihi=null,$aciklama="");
	//	earsiv_set_odeme_as_kredikarti($odemeTarihi=null,$aciklama="")
	// earsiv_set_odeme_as_kapida($odemeTarihi=null,$aciklama=""){
	// earsiv_set_odeme_as_araci($odemeTarihi=null,$aciklama=""){
	// earsiv_set_odeme_as_diger($odemeTarihi=null,$aciklama=""){
	$efaturacim->earsiv_set_gonderim_as_kagit();
	$efaturacim->earsiv_set_gonderim_as_elektronik("volkan@gyazilim.com","2016-09-23 12:00:00");
	$efaturacim->earsiv_set_gonderim_zamani("2016-09-23 12:00:00"); // Yukaridaki satirda zaten verilmisti.
	$efaturacim->earsiv_set_satisyeri_as_magaza();
	$efaturacim->earsiv_set_satisyeri_as_web("https://efaturacim.orkestra.com.tr");
	$efaturacim->earsiv_set_kargo("HIZLI KARGOCU","12345678901");
	$efaturacim->earsiv_set_odeme_as_diger(null,"Diğer ödeme açıklaması");
	$efaturacim->earsiv_set_odeme_as_araci(null,"Aracı ödeme açıklaması");
	$faturaData = getOrnekFaturaArray();
	$sonuc        = $efaturacim->faturaYukleArrayData($faturaData);
	//$sonuc = $efaturacim->callTestFunction();	
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-ARŞİV PARAMETRELERİ");
}else if ($sayfa=="eposta_gonder1"){
	// Ornek Efatura no : EFA2016000000023
	// Ornek earsiv fatura no : EAR2016000000058
	//epostaGonder($kayitNoVeyaFaturaNo,$tip="earsiv",$gonderilecekAdresler=null,$konu=null){
	$kayitNoVeyaFaturaNo = "EAR2016000000058";
	$sonuc = $efaturacim->epostaGonder($kayitNoVeyaFaturaNo,"earsiv","efaturacim@efaturacim.com","Örnek E-Fatura Gönderim");
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-FATURA GÖNDERİMİ");
}else if ($sayfa=="eposta_gonder2"){
	$kayitNoVeyaFaturaNo = "EFA2016000000023";
	$sonuc = $efaturacim->epostaGonder($kayitNoVeyaFaturaNo,"efatura","efaturacim@efaturacim.com","Örnek E-Fatura Gönderim");
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-FATURA GÖNDERİMİ");	
}else if ($sayfa=="earsiv_iptal"){	
	$faturaData = getOrnekFaturaArray();
	$csvString   = $efaturacim->createCsvFromArray($faturaData);
	$yeniFatura = $efaturacim->faturaYukleCsvData($csvString);	
	$sonuc = $efaturacim->earsivFaturaIptali(@$yeniFatura["data"]["faturano"]);
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-ARŞİV FATURA İPTALİ");
}else if ($sayfa=="earsiv_cikart"){
	$faturaData = getOrnekFaturaArray();
	$csvString   = $efaturacim->createCsvFromArray($faturaData);
	$yeniFatura = $efaturacim->faturaYukleCsvData($csvString);
	$sonuc = $efaturacim->earsivFaturasiniSil(@$yeniFatura["data"]["faturano"]);
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-ARŞİV FATURA SİLME");
}else if ($sayfa=="sms"){
	$sonuc = $efaturacim->sendSms("deneme mesaji","05355554979","mylabel");
	$efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"SMS GONDERIM");
}else{	
	$efaturacim->showAsHtml("Sayfa algılanamadı.","E-FATURACIM ÖRNEK UYGULAMA EKRANI","danger");
}
?>