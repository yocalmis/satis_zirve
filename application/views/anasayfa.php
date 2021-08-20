<?php $this->load->view('header_ozel.php');?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!--
<div class="heading" >

<div class="col-md-1 btn">
    <a  href="<?php BASE_URL; ?>" class="btn btn-primary">
   Ana Menü
    </a>
</div>	
<div class="col-md-10"></div>
<div class="col-md-1 btn" >	
    <a onclick="history.go(-1)" class="btn btn-danger">Geri</a>
</div>



</div>	
-->




<div class="container">
  <div class="row">
    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/firma') ?>"><article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
FİRMA
		</h2>
	</article></a>
    </div>

    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/uyeler') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ÜYELİK
		</h2>
	</article></a>
    </div>
	
	
	
		   <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/kat/1') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
KATEGORİ
		</h2>
	</article></a>
    </div>
	
	
	
	
	   <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/hizmet_urun/1') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
STOK
		</h2>
	</article></a>
    </div>
	
	
    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/cari') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
CARİ
		</h2>
	</article></a>
    </div>	
		
	
    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/fatura') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
SİPARİŞ
		</h2>
	</article></a>
    </div>
 
	
    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/ayar') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
AYARLAR
		</h2>
	</article></a>
    </div>		
	


 <!--
   <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/kasa') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
KASA
		</h2>
	</article></a>
    </div>		
	


   <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/teklif') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
TEKLİF
		</h2>
	</article></a>
    </div>		
	


    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/siparis') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
SİPARİŞ
		</h2>
	</article></a>
    </div>		
	


    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/irsaliye') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
İRSALİYE
		</h2>
	</article></a>
    </div>		
	



    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/borc_alacak') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
BORÇ ALACAK
		</h2>
	</article></a>
    </div>		
	



    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/tahsilat_odeme') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
TAHSİLAT ÖDEME
		</h2>
	</article></a>
    </div>	


    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/gelir_gider') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
	GELİR GİDER
		</h2>
	</article></a>
    </div>	



    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/virman') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
VİRMAN
		</h2>
	</article></a>
    </div>	


    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/cek_senet') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ÇEK SENET
		</h2>
	</article></a>
    </div>	

    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/personel') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
PERSONEL
		</h2>
	</article></a>
    </div>	
	
	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/aday') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ADAY
		</h2>
	</article></a>
    </div>	
	
	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/zimmet') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ZİMMET
		</h2>
	</article></a>
    </div>	
	
	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/izin') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
İZİN
		</h2>
	</article></a>
    </div>	
	
		    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/yapilacaklar') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
YAPILACAKLAR
		</h2>
	</article></a>
    </div>	
	
	
	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/notlar') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
NOTLAR
		</h2>
	</article></a>
    </div>	


	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/zaman') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ZAMAN YÖNETİMİ
		</h2>
	</article></a>
    </div>		
	
	
		    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/gorusme') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GÖRÜŞMELER
		</h2>
	</article></a>
    </div>	
	
	
	
	    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/arac') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ARAÇLAR
		</h2>
	</article></a>
    </div>		
	
	-->
		    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/tartisma') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
TARTIŞMALAR
		</h2>
	</article></a>
    </div>	
	
			    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/mesaj') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
MESAJLAR
		</h2>
	</article></a>
    </div>	
	
	
	<!--
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/genel_rapor') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GENEL RAPOR
		</h2>
	</article></a>
    </div>	
	
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/cari_detay') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
CARİ RAPOR
		</h2>
	</article></a>
    </div>	
	
	
			    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/kasa_detay') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
KASA RAPOR
		</h2>
	</article></a>
    </div>	

			    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/stok_detay') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
STOK RAPOR
		</h2>
	</article></a>
    </div>	

			    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
TÜM RAPORLAR
		</h2>
	</article></a>
    </div>		
	
	
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/orkestra_bilgi') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GİRİŞ BİLGİLERİ
		</h2>
	</article></a>
    </div>
	
	
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_login') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GİRİŞ TEST
		</h2>
	</article></a>
    </div>
	
	
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_kontor_sorgu') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
KONTÖR SORGU
		</h2>
	</article></a>
    </div>
	
	
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_vkn_sorgu') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
VERGİ NO İLE SORGU
		</h2>
	</article></a>
    </div>
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_listele') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
E FATURA İŞLEMLERİ
		</h2>
	</article></a>
    </div>
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_sorgu_gun_gonderilen') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GÖNDERİLEN FATURALAR
		</h2>
	</article></a>
    </div>
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_sorgu_gun_gelen') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GELEN FATURALAR
		</h2>
	</article></a>
    </div>
	
	
				    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_sorgu_tum') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
TÜM FATURALAR
		</h2>
	</article></a>
    </div>
	
	
					    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/efatura_mail_gonder') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
E FATURA MAİL GÖNDER
		</h2>
	</article></a>
    </div>
	
	
					    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php $em = explode("@", $this->session->userdata('email'));
echo base_url() . "zdrive/index/" . $this->session->userdata('id') . "/" . $em[0] . "/" . $em[1];?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
DRİVE
		</h2>
	</article></a>
    </div>
	
	
		<?php if ($this->session->userdata('id') == 0) {?>
						    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/ayar') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
SİSTEM AYARLARI
		</h2>
	</article></a>
    </div>
	<?php }?>
	

							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/kategori') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
ÜRÜN KATEGORİ
		</h2>
	</article></a>
    </div>
	
	
							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/gider_kategori') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
GELİR GİDER KATEGORİ
		</h2>
	</article></a>
    </div>
	
	
							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/aktarimlar') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
AKTARIMLAR
		</h2>
	</article></a>
    </div>
	
	
							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/sss') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
SSS
		</h2>
	</article></a>
    </div>
	
							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yonetim/log_goruntule') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
LOGLAR
		</h2>
	</article></a>
    </div>
	
							    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo site_url('yedek') ?>">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
YEDEKLER
		</h2>
	</article></a>
    </div>
	-->
	
								    <div class="col-md-3" style="margin-top:10px; height:120px;">
	<a href="<?php echo base_url(); ?>yonetim/hata">	<article class="info info--primary" style="height:100%">
		<h2 class="info__heading">
HATA BİLDİR
		</h2>
	</article></a>
    </div>
	
	
	
	
	
	
	
  </div>
</div>








<section class="index-info">
		
	
	
	
</section>

<div class="main-content">




</div>

<?php $this->load->view('footer_ozel.php');?>
