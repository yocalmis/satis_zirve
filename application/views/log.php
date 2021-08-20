<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/themes/flexigrid/css') ?>/flexigrid.css">
<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Log Geçmişi</h2>
</div>

<div class="flexigrid" style="width: 100%;" >
	<div id="hidden-operations" class="hidden-operations"></div>

	<div class="mDiv">
		<div class="ftitle inline">
			<input id="ftitle__geri" type="button" value="Geri" onclick="history.back(-1)">
		</div>
		<?php if ($this->session->userdata('yetki') == 0) {?>

			<form action="<?php echo base_url(); ?>yonetim/log_temizle" method="post" class="inline f-right p-06 m-0">

				<select id="tarih" name="tarih" required placeholder="Tarih Aralığı">
					<option value="0">Tarih Seçiniz</option>
					<option value="11">Son 1 Saat</option>
					<option value="44">Son 4 Saat</option>
					<option value="1">Son 1 Gün</option>
					<option value="7">Son 1 Hafta</option>
					<option value="30">Son 1 Ay</option>
					<option value="90">Son 3 Ay</option>
					<option value="365">Son 1 Yıl</option>
					<option value="100">Tüm Zamanlar</option>
				</select>

				<input type="submit" value="Log Temizle" class="btn btn-small btn-nonshadow"/>
			</form>
		<?php }?>
	</div>
	<div id="main-table-box" class="main-table-box">


	<div id="ajax_list" class="ajax_list">
		<div class="bDiv">
		<table cellspacing="0" cellpadding="0" border="0" id="flex1">
		<thead>
			<tr class="hDiv">
				<th width="26%">
					<div class="text-left">
						Kullanıcı
					</div>
				</th>
				<th width="26%">
					<div class="text-left">
						Tarih
					</div>
				</th>
				<th width="26%">
					<div class="text-left">
						İşlem Sayfası
					</div>
				</th>
				<th width="26%">
					<div class="text-left">
						İşlem Adı
					</div>
				</th>

				<th width="26%">
					<div class="text-left">
					Görüntüle
					</div>
				</th>



			</tr>
		</thead>
		<tbody>
			<?php $n = 1;if ($data["log"]): foreach ($data["log"] as $dizi): ?>
				<tr>
					<td width="26%">
						<div class="text-left"><?php echo $data["u_ad"][$n]; ?></div>
					</td>
					<td width="26%" class="">
						<div class="text-left"><?php echo $dizi["tarih"]; ?></div>
					</td>
					<td width="26%" class="">
						<div class="text-left"><?php echo $dizi["nerede"]; ?></div>
					</td>
					<td width="26%" class="">
						<div class="text-left"><?php echo $dizi["islem"]; ?></div>
					</td>
					<td width="26%" class="">
						<div class="text-left">
							<?php 


						if($dizi["tablo"]=="kasa"){echo "<a href='".base_url()."yonetim/kasa/edit/".$dizi["kayit_id"]."'>Git</a>"; }		
						if($dizi["tablo"]=="ayar"){echo "<a href='".base_url()."yonetim/ayar'>Git</a>"; }
						if($dizi["tablo"]=="uyeler"){echo "<a href='".base_url()."yonetim/bilgi/edit/".$this->session->userdata('kullanici_id')."'>Git</a>"; }
						if($dizi["tablo"]=="cari"){echo "<a href='".base_url()."yonetim/cari/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="potansiyel"){echo "<a href='".base_url()."yonetim/potansiyel/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="personel"){echo "<a href='".base_url()."yonetim/personel/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="aday"){echo "<a href='".base_url()."yonetim/aday/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="zimmet"){echo "<a href='".base_url()."yonetim/zimmet/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="izin"){echo "<a href='".base_url()."yonetim/izin/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="hizmet_urun"){echo "<a href='".base_url()."yonetim/hizmet_urun/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="gider_kategori"){echo "<a href='".base_url()."yonetim/gider_kategori/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="demirbas"){echo "<a href='".base_url()."yonetim/demirbas/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="komite"){echo "<a href='".base_url()."yonetim/komite/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="uyeler"){echo "<a href='".base_url()."yonetim/uyeler/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="ornek_dosyalar"){echo "<a href='".base_url()."yonetim/ornek_dosyalar/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="dosyalar"){echo "<a href='".base_url()."yonetim/dosyalar/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="kategori"){echo "<a href='".base_url()."yonetim/kategori/edit/".$dizi["kayit_id"]."'>Git</a>"; }

						if($dizi["tablo"]=="demirbas"){echo "<a href='".base_url()."yonetim/demirbas/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["nerede"]=="Gelir-Gider"){echo "<a href='".base_url()."yonetim/gelir_gider/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="virman"){echo "<a href='".base_url()."yonetim/virman/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["tablo"]=="borc_alacak"){echo "<a href='".base_url()."yonetim/borc_alacak/read/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["nerede"]=="Toplu Borç"){echo "<a href='".base_url()."yonetim/borc_alacak'>Git</a>"; }
						if($dizi["nerede"]=="Toplu Alacak"){echo "<a href='".base_url()."yonetim/borc_alacak'>Git</a>"; }
						if($dizi["nerede"]=="Tahsilat Ödeme"){echo "<a href='".base_url()."yonetim/tahsilat_odeme/edit/".$dizi["kayit_id"]."'>Git</a>"; }
						if($dizi["nerede"]=="Cari Tahsilat Ödeme"){echo "<a href='".base_url()."yonetim/tahsilat_odeme/edit/".$dizi["kayit_id"]."'>Git</a>"; }
					if($dizi["nerede"]=="Fatura Tahsilat Ödeme"){echo "<a href='".base_url()."yonetim/tahsilat_odeme/edit/".$dizi["kayit_id"]."'>Git</a>"; }
					if($dizi["nerede"]=="Fatura Tahsilat"){echo "<a href='".base_url()."yonetim/tahsilat_odeme'>Git</a>"; }			
					if($dizi["nerede"]=="Fatura Ödeme"){echo "<a href='".base_url()."yonetim/tahsilat_odeme/edit/".$dizi["kayit_id"]."'>Git</a>"; }
					if($dizi["tablo"]=="gorusme"){echo "<a href='".base_url()."yonetim/gorusme/edit/".$dizi["kayit_id"]."'>Git</a>"; }
					if($dizi["tablo"]=="notlar"){echo "<a href='".base_url()."yonetim/notlar/edit/".$dizi["kayit_id"]."'>Git</a>"; }
					if($dizi["tablo"]=="zaman"){echo "<a href='".base_url()."yonetim/zaman/edit/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["tablo"]=="fatura"){echo "<a href='".base_url()."yonetim/fatura_goruntule/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["tablo"]=="cek_senet"){echo "<a href='".base_url()."yonetim/cek_senet/edit/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["tablo"]=="arac"){echo "<a href='".base_url()."yonetim/arac/edit/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["tablo"]=="bakim"){echo "<a href='".base_url()."yonetim/bakim/edit/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["tablo"]=="km"){echo "<a href='".base_url()."yonetim/km/edit/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["tablo"]=="tartisma"){echo "<a href='".base_url()."yonetim/tartisma/edit/".$dizi["kayit_id"]."'>Git</a>"; }




			


					if($dizi["nerede"]=="Etkinlik"){echo "<a href='".base_url()."yonetim/etkinlik/'>Git</a>"; }


					if($dizi["nerede"]=="Fatura İrsaliye Ekleme"){echo "<a href='".base_url()."yonetim/fatura_goruntule/".$dizi["kayit_id"]."'>Git</a>"; }

	


					

				


					if($dizi["nerede"]=="İrsaliye Kayıt"){echo "<a href='".base_url()."yonetim/irsaliye_goruntule/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["nerede"]=="İrsaliye Güncelle"){echo "<a href='".base_url()."yonetim/irsaliye_goruntule/".$dizi["kayit_id"]."'>Git</a>"; }

			

					if($dizi["nerede"]=="Not Kaydı"){echo "<a href='".base_url()."yonetim/fatura_goruntule/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["nerede"]=="Sipariş Kayıt"){echo "<a href='".base_url()."yonetim/siparis_goruntule/edit/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["nerede"]=="Sipariş Güncelle"){echo "<a href='".base_url()."yonetim/siparis_goruntule/edit/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["nerede"]=="Teklif Kayıt"){echo "<a href='".base_url()."yonetim/teklif_goruntule/edit/".$dizi["kayit_id"]."'>Git</a>"; }


					if($dizi["nerede"]=="Teklif Aktar"){echo "<a href='".base_url()."yonetim/teklif_goruntule/edit/".$dizi["kayit_id"]."'>Git</a>"; }

					if($dizi["nerede"]=="Sipariş Aktar"){echo "<a href='".base_url()."yonetim/siparis_goruntule/edit/".$dizi["kayit_id"]."'>Git</a>"; }

		




							 ?>
							


						</div>
					</td>


				</tr>
			<?php $n = $n + 1;endforeach;endif;?>


		</table>
	</div>

	</div>
</div>
		<!-- <div class="material-container">

<?php $n = 1;if ($data["log"]): foreach ($data["log"] as $dizi):

        // echo $n . " : " . $dizi["tarih"] . " tarihinde " . $data["u_ad"][$n] . " adlı kullanıcı " . $dizi["nerede"] . " sayfasında " . $dizi["islem"] . " işlemi gerçekleştirdi. <!--" . $dizi["kayit_id"] . "--><br>";
        $n = $n + 1;endforeach;endif;?>
		</div> -->
</body>

<?php $this->load->view('footer_ozel.php');?>
