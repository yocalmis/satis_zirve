<?php error_reporting(0);if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>

<?php $this->load->view('header.php');?>
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/themes/default.css">

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Akış Şeması</h2>
	</div>
<div class="material-container">

	<?php
         $data["icerik"] = "";

         $islem="";
         $n=0; if ($siralama): foreach ($siralama as $dizi):
        $l=base_url()."yonetim/";
         if($dizi["vade_tarihi"]>date("Y-m-d")){ $renk="gray";}
         else if($dizi["vade_tarihi"]<date("Y-m-d")){ $renk="red";}   
         else{ $renk="black";}     
 
         if($dizi["fatura_turu"]=="Gider"){$islem="Gider Faturası"; $l.="gider_fatura_goruntule/".$dizi["id"];
         $n="ödemesi";}
         if($dizi["fatura_turu"]=="Alış"){ 
         	if($dizi["tur"]=="İrsaliye"){$islem="Alış İrsaliyesi"; $l.="irsaliye_goruntule/".$dizi["id"]; $n="işlemi";} 
         	else{$islem="Alış Faturası"; $l.="fatura_goruntule/".$dizi["id"]; $n="ödemesi"; } }
         if($dizi["fatura_turu"]=="Satış"){ 
         	if($dizi["tur"]=="İrsaliye"){$islem="Satış İrsaliyesi"; $l.="irsaliye_goruntule/".$dizi["id"];
         	$n="işlemi";} 
         	else{$islem="Satış Faturası"; $l.="fatura_goruntule/".$dizi["id"]; $n="tahsilatı"; } }
         if($dizi["fatura_turu"]=="AlınanTeklif"){ $islem="Alınan Teklif"; $l.="teklif_goruntule/".$dizi["id"]; 
         $n="yanıt verme"; }
          if($dizi["fatura_turu"]=="VerilenTeklif"){ $islem="Verilen Teklif"; $l.="teklif_goruntule/".$dizi["id"]; $n="yanıt verme"; }  
         if($dizi["fatura_turu"]=="GelenSiparis"){ $islem="Gelen Sipariş"; $l.="siparis_goruntule/".$dizi["id"];
         $n="yanıt verme"; }
         if($dizi["fatura_turu"]=="GidenSiparis"){ $islem="Giden Sipariş"; $l.="siparis_goruntule/".$dizi["id"];
         $n="yanıt verme"; }  
         if($dizi["fatura_turu"]=="0"){ 
         	$islem="Borçlanılan İşlem";
		if($dizi["tur"]=="Çek Senet"){ $l.="cek_senet/read/".$dizi["id"]; $n="ödemesi";}
		if($dizi["tur"]=="Borç Alacak"){ $l.="borc_alacak/read/".$dizi["id"]; $n="ödemesi";}				
          }           
         if($dizi["fatura_turu"]=="1"){ 
         	$islem="Alacaklanan İşlem"; 
		if($dizi["tur"]=="Çek Senet"){ $l.="cek_senet/read/".$dizi["id"]; $n="tahsilatı";}
		if($dizi["tur"]=="Borç Alacak"){ $l.="borc_alacak/read/".$dizi["id"]; $n="tahsilatı";}	


         }  
         if($dizi["fatura_turu"]==""){ $islem="Etkinliğiniz "; $l.="etkinlik"; $n="var";}           
  
  if($dizi["vade_tarihi"]!=""){
echo "<div style='color:".$renk.";'>".$dizi["vade_tarihi"]." tarihinde ".$islem." ".$n." yapılacak <a href='".$l."' style='text-decoration:none;'> Görüntüle</a></div>";
}


          $n=$n+1; endforeach;endif;

	?>

</div>


<script src="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.js"></script>

<?php $this->load->view('footer_ozel.php');?>
<script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/') ?>jquery.form.min.js"></script>