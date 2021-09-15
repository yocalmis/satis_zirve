<!--
<div>
		<a href='<?php echo site_url('examples/customers_management') ?>'>Customers</a> |
		<a href='<?php echo site_url('examples/orders_management') ?>'>Orders</a> |
		<a href='<?php echo site_url('examples/products_management') ?>'>Products</a> |
		<a href='<?php echo site_url('examples/offices_management') ?>'>Offices</a> |
		<a href='<?php echo site_url('examples/employees_management') ?>'>Employees</a> |
		<a href='<?php echo site_url('examples/film_management') ?>'>Films</a> |
		<a href='<?php echo site_url('examples/multigrids') ?>'>Multigrid [BETA]</a>

</div>
-->

<script>
	window.self = {
		base_url: '<?php echo base_url(); ?>',
	}
	var self = window.self;
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/edit.css">
<div class="side-nav">
	<div class="s-n_h">
		<div class="s-n_h_t">
			<h3><?php echo PROGRAM_NAME; ?></h3>
		</div>
	</div>
	<ul class="side-nav--list scrollbar" data-simplebar>

		<li>
			<h2>
				<center><?php echo substr($this->session->userdata('bina_adi'), 0, 18); ?>
				
				
				</center>
			</h2>
		</li>
		<li>
			<a class="sidenav__link">
				<span class="icon icon--mr05" data-svg="outline-access_time-24px"></span>
				<?php $this->load->view('saat');?>
			</a>
		</li>

		<li>
			<a class="sidenav__link" href='<?php echo site_url('yonetim') ?>'>
				<span class="icon icon--mr05" data-svg="outline-home-24px"></span>
				Anasayfa
			</a>
			<a class="sidenav__link" href='<?php echo site_url('yonetim/akis') ?>'>
				<i class="material-icons-24px" style="margin-right:10px;">open_in_full </i>
				 Akış
			</a>
		</li>

		<li class="mine-trigger">
			<a class="sidenav__link">
				<span class="icon icon--mr05" data-svg="account_balance-24px"></span>
				Finans
			</a>
			<div class="mine-content">
				
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/cari') ?>'>
					<span class="icon icon--mr05" data-svg="outline-person_pin-24px"></span>
					Cari
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/kasa') ?>'>
					<span class="icon icon--mr05" data-svg="account_balance_wallet-24px"></span>
					Kasa
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/hizmet_urun') ?>'>
					<span class="icon icon--mr05" data-svg="ballot-24px"></span>
					Stok
				</a>
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/teklif') ?>'>
				<span class="icon icon--mr05" data-svg="feedback-24px"></span>
				Teklif
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/siparis') ?>'>
				<span class="icon icon--mr05" data-svg="local_grocery_store-24px"></span>
				Sipariş
			</a>
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/irsaliye') ?>'>
				<span class="icon icon--mr05" data-svg="local_shipping-24px"></span>
				İrsaliye
			</a>
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/fatura') ?>'>
				<span class="icon icon--mr05" data-svg="event_note-24px"></span>
				Fatura
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/borc_alacak') ?>'>
				<span class="icon icon--mr05" data-svg="outline-repeat-24px"></span>
				Borç - Alacak
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/tahsilat_odeme') ?>'>
				<span class="icon icon--mr05" data-svg="local_atm-24px"></span>
				Tahsilat - Ödeme
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/cek_senet') ?>'>
				<span class="icon icon--mr05" data-svg="dns-24px"></span>
				Çek - Senet
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/gelir_gider') ?>'>
				<span class="icon icon--mr05" data-svg="outline-swap_calls-24px"></span>
				Gelir - Gider
			</a>
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/virman') ?>'>
				<span class="icon icon--mr05" data-svg="cached-24px"></span>
				Virman
			</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/potansiyel') ?>'>


<i class="material-icons-24px" style="margin-right:10px;">accessibility</i>				Potansiyel
				</a>

			
		</div>
	</li>

	<li class="mine-trigger">
		<a class="sidenav__link">
			<span class="icon icon--mr05" data-svg="supervised_user_circle-24px"></span>
			Personel İşlemleri
		</a>
		<div class="mine-content">
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/personel') ?>'>
				<span class="icon icon--mr05" data-svg="supervisor_account-24px"></span>
				Personel
			</a>
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/aday') ?>'>
				<span class="icon icon--mr05" data-svg="emoji_people-24px"></span>
				Aday
			</a>

			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/zimmet') ?>'>
				<span class="icon icon--mr05" data-svg="phonelink_lock-24px"></span>
				Zimmet
			</a>
			<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/izin') ?>'>
				<span class="icon icon--mr05" data-svg="airline_seat_flat-24px"></span>
				İzin
			</a>
		</div>
	</li>




	<li class="mine-trigger">
		<a class="sidenav__link">
			<span class="icon icon--mr05" data-svg="calendar_today-24px"></span>
			Ajanda
		</a>
		<div class="mine-content">
				<!--<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/ornek_dosyalar') ?>'>
					<span class="sidenav__icon ico-folder_open"></span>
					Örnek Dosyalar
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/dosyalar') ?>'>
					<span class="sidenav__icon ico-create_new_folder"></span>
					Dosyalar
				</a>-->


				<!--<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/etkinlik') ?>'>
					<span class="icon icon--mr05" data-svg="date_range-24px"></span>
					Etkinlik Takvimi
				</a>-->
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/yapilacaklar') ?>'>
					<span class="icon icon--mr05" data-svg="list_alt-24px"></span>
					Kişisel Yapılacaklar
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/notlar') ?>'>
					<span class="icon icon--mr05" data-svg="bookmarks-24px"></span>
					Notlar
				</a>
								<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/zaman') ?>'>
			<i class="material-icons-24px" style="margin-right:10px;">av_timer</i>					Zaman Yönetimi
				</a>
			<!--	<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/mail') ?>'>
					<span class="icon icon--mr05" data-svg="send-24px"></span>
					Gönderiler
				</a>-->
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/gorusme') ?>'>
					<span class="icon icon--mr05" data-svg="contact_mail-24px"></span>
					Görüşmeler
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/arac') ?>'>
					<span class="icon icon--mr05" data-svg="directions_car-24px"></span>
					Araçlar
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/tartisma') ?>'>
					<span class="icon icon--mr05" data-svg="record_voice_over-24px"></span>
					Tartışmalar
				</a>

			</div>
		</li>


	<!--	<li>
			<a class="sidenav__link" target="_blank" href='<?php $em = explode("@", $this->session->userdata('email'));
echo base_url() . "zdrive/index/" . $this->session->userdata('id') . "/" . $em[0] . "/" . $em[1];?>'>
				<span class="icon icon--mr05" data-svg="filter_drama-24px"></span>
				Z-Drive
			</a>
		</li>-->
		<li>
			<a class="sidenav__link" href="<?php echo site_url('yonetim/mesaj') ?>">
				<span class="icon icon--mr05" data-svg="chat-24px"></span>
				Mesajlar
				<span id="istek"></span>
			</a>

		</li>


		<li class="mine-trigger">
			<a class="sidenav__link">
				<span class="icon icon--mr05" data-svg="insert_chart_outlined-24px"></span>
				Rapor
			</a>
			<div class="mine-content">
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/genel_rapor') ?>'>
					<span class="icon icon--mr05" data-svg="bar_chart-24px"></span>
					Genel Rapor
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/cari_detay') ?>'>
					<span class="icon icon--mr05" data-svg="contacts-24px"></span>
					Cari Rapor
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/kasa_detay') ?>'>
					<span class="icon icon--mr05" data-svg="table_chart-24px"></span>
					Kasa Rapor
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/stok_detay') ?>'>
					<span class="icon icon--mr05" data-svg="archive-24px"></span>
					Stok Rapor
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('rapor/index') ?>'>
					<span class="icon icon--mr05" data-svg="library_books-24px"></span>
					Tüm Raporlar
				</a>

			</div>
		</li>




		<li class="mine-trigger">
			<!--<a class="sidenav__link">
				<span class="icon icon--mr05" data-svg="insert_chart_outlined-24px"></span>
				E Fatura
			</a>-->
			<div class="mine-content">

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/orkestra_bilgi') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">info</i>Giriş Bilgileri
				</a>


				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_login') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">login</i>					Giriş Test
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_kontor_sorgu') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">account_balance_wallet</i>
					Kontör Sorgu
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_vkn_sorgu') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">assignment</i>
					Vergi No İle Sorgu
				</a>


				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_listele') ?>'>
						<i class="material-icons-24px" style="margin-right:10px;">menu</i>
					E Fatura İşlemleri
				</a>


				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_sorgu_gun_gonderilen') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">last_page</i>
					Gönderilen Faturalar
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_sorgu_gun_gelen') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">arrow_right_alt</i>
					Gelen Faturalar
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_sorgu_tum') ?>'>
					<i class="material-icons-24px" style="margin-right:10px;">clear_all</i>
					Tüm Faturalar
				</a>


			<!--

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/efatura_mail_gonder') ?>'>
					<span class="icon icon--mr05" data-svg="archive-24px"></span>
					Mail Gönder
				</a>

-->
			

			</div>
		</li>



		<li class="mine-trigger">
			<a class="sidenav__link">
				<span class="icon icon--mr05" data-svg="outline-settings-24px"></span>
				Ayarlar
			</a>
			<div class="mine-content">
				<?php if ($this->session->userdata('id') == 0) {?>
					<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/ayar') ?>'>
						<span class="icon icon--mr05" data-svg="settings_applications-24px"></span>
						Sistem Ayarları
					</a>
				<?php }?>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/firma') ?>'>
					<span class="icon icon--mr05" data-svg="business-24px"></span>
					Firma
				</a>
				<!--<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/aktarimlar') ?>'>
					<span class="icon icon--mr05" data-svg="category-24px"></span>
					Aktarımlar
				</a>-->
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/kategori') ?>'>
					<span class="icon icon--mr05" data-svg="category-24px"></span>
					Ürün Kategori
				</a>
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/gider_kategori') ?>'>
					<span class="icon icon--mr05" data-svg="compare_arrows-24px"></span>
					Gelir-Gider Kategori
				</a>

			<!--	<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/uyeler') ?>'>
					<span class="icon icon--mr05" data-svg="wc-24px"></span>
					Üyeler
				</a>-->
				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/sss') ?>'>
					<span class="icon icon--mr05" data-svg="help_outline-24px"></span>
					SSS
				</a>

				<a class="sidenav__link mine-content__link" href='<?php echo site_url('yonetim/log_goruntule') ?>'>
					<span class="icon icon--mr05" data-svg="receipt-24px"></span>
					Loglar
				</a>
				<!--<a class="sidenav__link mine-content__link" href='<?php echo site_url('yedek') ?>'>
					<span class="icon icon--mr05" data-svg="sd_card-24px"></span>
					Yedekler
				</a>-->

			</div>
		</li>


		<li class="mine-trigger">
			<a href="<?php echo base_url(); ?>yonetim/hata" class="sidenav__link">
				<span class="icon icon--mr05" data-svg="outline-settings-24px"></span>
				Hata Bildir
			</a>


		</li>


	</ul>
</div>

<div class="side-header">		
<img class="logo1" src="<?php echo base_url(); ?>assets/logo.png" alt="Zirve Kayseri"> 
<div class="button1"><b>
<?php if(($this->session->userdata('uye_turu')==0)or($this->session->userdata('uye_turu')==1)){ echo $this->session->userdata('satis'); } ?>
</b></div>

<div class="s-h_r">
	<div class="user-menu">
		<a class="user-menu__trigger waves-effect waves-light profil1">
		Profil
		</a>
		<div class="user-menu__inner">
			<div class="user-info user-menu__info">
				<span class="icon icon--mr05 user-info__user" data-svg="person-24px"></span>
				<div class="user-info__text">
				
				
				
					<h3 class="user-info__title">

						<?php echo $online = $this->session->userdata('adminonline'); ?>
						<script>
							self.onlineUser = '<?php $this->session->userdata('adminonline');?>';
						</script>
					</h3>
					<p class="user-info__yetki">
						<?php
if ($this->session->userdata('uye_turu') == 0) {echo "Süper Admin";}
if ($this->session->userdata('uye_turu') == 1) {echo "Firma Sahibi";}
if ($this->session->userdata('uye_turu') == 2) {

    if ($this->session->userdata('yetki') == 0) {echo "Firma Sorumlusu Tam Yetki";}
    if ($this->session->userdata('yetki') == 1) {echo "Firma Çalışanı Düzenler";}
    if ($this->session->userdata('yetki') == 2) {echo "Firma Çalışanı Görüntüler";}

}
?>
					</p>
				</div>

			</div>
			<p class="divider"></p>
			<ul class="user-info__apps">
			<!--		<li class="user-info__app">
						<a class="user-info__link" href="<?php echo base_url(); ?>yonetim/takvim"
						onclick="window.open(this.href, 'mywin','left=20,top=20,width=250,height=250,toolbar=1,resizable=0');
							 return false;">
							Takvim
						</a>
					</li>
					<li class="user-info__app">
						<a class="user-info__link waves-effect" href="<?php echo base_url(); ?>yonetim/kur"
							onclick="window.open(this.href, 'mywin','left=20,top=20,width=300,height=350,toolbar=1,resizable=0'); return false;">
							Kurlar
						</a>
					</li>
					<li class="user-info__app">
						<a href="<?php echo base_url(); ?>react-calculator/"
						class="iframeTrigger calculator user-info__link waves-effect">Hesapla</a>
					</li>
					<li class="user-info__app">
						<a href="<?php echo base_url(); ?>react-news/"
						class="iframeTrigger calculator user-info__link waves-effect">İki dakika ara !</a>
					</li>-->
				</ul>
				<p class="divider"></p>
				<ul class="user-info__apps mbd5">
					<li class="user-info__app">
						<a href="<?php echo site_url('yonetim/bilgi/edit/' . $this->session->userdata('id')) ?>" class="user-info__link waves-effect">
							<span class="icon icon--mr05" data-svg="lock_open-24px"></span>
							Bilgi Güncelle
						</a>
					</li>
				<!--	<li class="user-info__app">
						<a href="<?php echo site_url('odeme') ?>" class="user-info__link waves-effect">
							<span class="icon icon--mr05" data-svg="lock_open-24px"></span>
							Üyelik uzat
						</a>
					</li>
					<li class="user-info__app">
						<a href="<?php echo site_url('kullanici/index') ?>" class="user-info__link waves-effect">
							<span class="icon icon--mr05" data-svg="lock_open-24px"></span>
							Ek kullanıcı
						</a>
					</li>-->


					<li class="user-info__app">
						<a href="<?php echo site_url('yonetim/cikis') ?>" class="user-info__link waves-effect">
							<span class="icon icon--mr05" data-svg="exit_to_app-24px"></span>
							Çıkış
						</a>
					</li>
				</ul>
			</div>

		</div>



	</div>
</div>
<div class="iframeModal">
	<div class="iframeModal__header">
		<div>
			<h3 class="iframeModal__heading"></h3>
		</div>
		<a class="iframeModal__close">
			<span class="icon" data-svg="close-24px"></span>
		</a>
	</div>
	<div class="iframeModal__content">
		<iframe id="calculator" class="iframeModal__iframe" src="" frameborder="0"></iframe>
	</div>
</div>
<div class="iframeModal__backdrop"></div>
<main>
	<div class="pageInner" data-simplebar  background-color: #80cbc4;">
