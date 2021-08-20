

			<script>
				if (window.NodeList && !NodeList.prototype.forEach) {
					NodeList.prototype.forEach = Array.prototype.forEach;
				}
				window.self = {
					base_url: '<?php echo base_url(); ?>',
					page: '<?php echo $data['side_menu']; ?>',
					buttons: [],
					flags: {},
					token: "<?php echo $this->session->userdata('anahtar'); ?>"
				}
				console.log(window.self.token)
				var self = window.self;



<?php if ($data['side_menu'] == "Cari Ayarları") {?>

	self.modalText="Cari Hızlı İşlemler";

	self.buttons[0] = {
					group_name: 'Teklif',
					grup_buttons: [
						{name: 'Alınan Teklif ekle', link: 'yonetim/alinan_teklif_olustur', isSpecific: false, type: 'add',isIframe:true},
						{name: 'Verilen Teklif ekle', link: 'yonetim/verilen_teklif_olustur', isSpecific: false,isIframe:true},
						{name: 'Teklifler', link: 'yonetim/teklif', isSpecific: false},
					]
				}
				self.buttons[1] = {
					group_name: 'Sipariş',
					grup_buttons: [
						{name: 'Gelen Sipariş Ekle', link: 'yonetim/gelen_siparis_olustur', isSpecific: false,isIframe:true},
						{name: 'Giden Sipariş Ekle', link: 'yonetim/giden_siparis_olustur', isSpecific: false,isIframe:true},
						{name: 'Siparişler', link: 'yonetim/siparis', isSpecific: false},
					]
				}
				self.buttons[2] = {
					group_name: 'İrsaliye',
					grup_buttons: [
						{name: 'Satış İraliye Ekle', link: 'yonetim/satis_irsaliye_olustur', isSpecific: false,isIframe:true},
						{name: 'Alış İrsaliye Ekle', link: 'yonetim/alis_irsaliye_olustur', isSpecific: false,isIframe:true},
						{name: 'İrsaliyeler', link: 'yonetim/irsaliye', isSpecific: false},
					]
				}

				self.buttons[3] = {
					group_name: 'Fatura',
					grup_buttons: [
						{name: 'Satış Fatura Ekle', link: 'yonetim/satis_fatura_olustur', isSpecific: false,isIframe:true},
						{name: 'Alış Fatura Ekle', link: 'yonetim/alis_fatura_olustur', isSpecific: false,isIframe:true},
						{name: 'Faturalar', link: 'yonetim/fatura', isSpecific: false},
					]
				}

				self.buttons[4] = {
					group_name: 'Diğer',
					grup_buttons: [
						{name: 'Borç Alacak Ekle', link: 'yonetim/borc_alacak/add', isSpecific: false},
						{name: 'Borç Alacak', link: 'yonetim/borc_alacak', isSpecific: false},
						{name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},
						{name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay_git/', isSpecific: true},



					]
				}


<?php }?>



<?php if ($data['side_menu'] == "Kasa Ayarları") {?>

	self.modalText="Kasa Hızlı İşlemler";

	self.buttons[0] = {
					group_name: 'Hızlı İşlemler',
					grup_buttons: [
						{name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},
						{name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},
						{name: 'Gelir Gider Ekle', link: 'yonetim/gelir_gider/add', isSpecific: false},
						{name: 'Gelir Gider', link: 'yonetim/gelir_gider', isSpecific: false},
						{name: 'Gelir Gider Kategori', link: 'yonetim/gider_kategori', isSpecific: false},
						{name: 'Virman', link: 'yonetim/virman', isSpecific: false},
						{name: 'Kasa detay', link: 'yonetim/kasa_detay_git/', isSpecific: true},

					]
				}


<?php }?>




<?php if ($data['side_menu'] == "Hizmet Ürün Ayarları") {?>

	self.modalText="Hizmet Ürün Hızlı İşlemler";

	self.buttons[0] = {
				group_name: 'İrsaliye',
					grup_buttons: [
						{name: 'Satış İraliye Ekle', link: 'yonetim/satis_irsaliye_olustur', isSpecific: false,isIframe:true},
						{name: 'Alış İrsaliye Ekle', link: 'yonetim/alis_irsaliye_olustur', isSpecific: false,isIframe:true},
						{name: 'İrsaliyeler', link: 'yonetim/irsaliye', isSpecific: false},
					]
				}
				self.buttons[1] = {
					group_name: 'Fatura',
					grup_buttons: [
						{name: 'Satış Fatura Ekle', link: 'yonetim/satis_fatura_olustur', isSpecific: false,isIframe:true},
						{name: 'Alış Fatura Ekle', link: 'yonetim/alis_fatura_olustur', isSpecific: false,isIframe:true},
						{name: 'Faturalar', link: 'yonetim/fatura', isSpecific: false},
					]
				}

	self.buttons[2] = {
					group_name: 'Diğer',
					grup_buttons: [
						{name: 'Hizmet Ürün Kategori', link: 'yonetim/kategori', isSpecific: false},
						{name: 'Stok detay', link: 'yonetim/stok_detay_git/', isSpecific: true,isIframe:true},

					]
				}



<?php }?>




<?php if ($data['side_menu'] == "Teklif Ayarları") {?>

	self.modalText="Teklif Hızlı İşlemler";

	self.buttons[0] = {
				group_name: 'Teklif',
					grup_buttons: [
						{name: 'Teklif Düzenle', link: 'yonetim/teklif_duzenle', isSpecific: true,isIframe:true},

					]
				}

	self.buttons[1] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}
				self.buttons[2] = {
					group_name: 'Hizmet Ürün ',
					grup_buttons: [
						{name: 'Hizmet Ürün Ekle', link: 'yonetim/hizmet_urun/add', isSpecific: false},
						{name: 'Hizmet Ürün', link: 'yonetim/hizmet_urun', isSpecific: false},
						{name: 'Stok detay', link: 'yonetim/stok_detay/', isSpecific: false},
						{name: 'Hizmet Ürün Kategori', link: 'yonetim/kategori', isSpecific: false},
					]
				}

	self.buttons[3] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}





<?php }?>




<?php if ($data['side_menu'] == "Sipariş Ayarları") {?>

	self.modalText="Sipariş Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Sipariş',
					grup_buttons: [
						{name: 'Sipariş Düzenle', link: 'yonetim/siparis_duzenle', isSpecific: true,isIframe:true},

					]
				}



	self.buttons[1] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}
				self.buttons[2] = {
					group_name: 'Hizmet Ürün ',
					grup_buttons: [
						{name: 'Hizmet Ürün Ekle', link: 'yonetim/hizmet_urun/add', isSpecific: false},
						{name: 'Hizmet Ürün', link: 'yonetim/hizmet_urun', isSpecific: false},
						{name: 'Stok detay', link: 'yonetim/stok_detay/', isSpecific: false},
						{name: 'Hizmet Ürün Kategori', link: 'yonetim/kategori', isSpecific: false},
					]
				}
	self.buttons[3] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}



<?php }?>




<?php if ($data['side_menu'] == "İrsaliye Ayarları") {?>

	self.modalText="İrsaliye Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'İrsaliye',
					grup_buttons: [
						{name: 'İrsaliye Düzenle', link: 'yonetim/irsaliye_duzenle', isSpecific: true,isIframe:true},

					]
				}


	self.buttons[1] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},

					]
				}
				self.buttons[2] = {
					group_name: 'Hizmet Ürün ',
					grup_buttons: [
						{name: 'Hizmet Ürün Ekle', link: 'yonetim/hizmet_urun/add', isSpecific: false},
						{name: 'Hizmet Ürün', link: 'yonetim/hizmet_urun', isSpecific: false},
						{name: 'Stok detay', link: 'yonetim/stok_detay/', isSpecific: false},
						{name: 'Hizmet Ürün Kategori', link: 'yonetim/kategori', isSpecific: false},
					]
				}

	self.buttons[3] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}


<?php }?>





<?php if ($data['side_menu'] == "Fatura Ayarları") {?>

	self.modalText="Fatura Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Fatura',
					grup_buttons: [
						{name: 'Fatura Düzenle', link: 'yonetim/fatura_duzenle', isSpecific: true,isIframe:true},

					]
				}



	self.buttons[1] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}
				self.buttons[2] = {
					group_name: 'Hizmet Ürün ',
					grup_buttons: [
						{name: 'Hizmet Ürün Ekle', link: 'yonetim/hizmet_urun/add', isSpecific: false},
						{name: 'Hizmet Ürün', link: 'yonetim/hizmet_urun', isSpecific: false},
						{name: 'Stok detay', link: 'yonetim/stok_detay/', isSpecific: false},
						{name: 'Hizmet Ürün Kategori', link: 'yonetim/kategori', isSpecific: false},
					]
				}

	self.buttons[3] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}


<?php }?>



<?php if ($data['side_menu'] == "Borç Alacak Ayarları") {?>
		self.modalText="Borç Alacak Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}

	self.buttons[1] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}


<?php }?>



<?php if ($data['side_menu'] == "Tahsilat - Ödeme Ayarları") {?>
			self.modalText="Tahsilat - Ödeme Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}

	self.buttons[1] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}

					self.buttons[2] = {
					group_name: 'Çek Senet',
					grup_buttons: [

					    {name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},

					]
				}
						self.buttons[3] = {
					group_name: 'Gelir Gider',
					grup_buttons: [

					    {name: 'Gelir Gider Ekle', link: 'yonetim/gelir_gider/add', isSpecific: false},
						{name: 'Gelir Gider', link: 'yonetim/gelir_gider', isSpecific: false},
						{name: 'Gelir Gider Kategori', link: 'yonetim/gider_kategori', isSpecific: false},
					]
				}

<?php }?>





<?php if ($data['side_menu'] == "Çek Senet Ayarları") {?>
			self.modalText="Çek Senet Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}

	self.buttons[1] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}

					self.buttons[2] = {
					group_name: 'Tahsilat Ödeme',
					grup_buttons: [

					    {name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},

					]
				}
						self.buttons[3] = {
					group_name: 'Gelir Gider',
					grup_buttons: [

					    {name: 'Gelir Gider Ekle', link: 'yonetim/gelir_gider/add', isSpecific: false},
						{name: 'Gelir Gider', link: 'yonetim/gelir_gider', isSpecific: false},
						{name: 'Gelir Gider Kategori', link: 'yonetim/gider_kategori', isSpecific: false},
					]
				}

<?php }?>




<?php if ($data['side_menu'] == "Gelir - Gider Ayarları") {?>
				self.modalText="Gelir - Gider Hızlı İşlemler";
	self.buttons[0] = {
				group_name: 'Cari',
					grup_buttons: [
						{name: 'Cari Ekle', link: 'yonetim/cari/add', isSpecific: false},
						{name: 'Cariler', link: 'yonetim/cari', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay/', isSpecific: false},
					]
				}

	self.buttons[1] = {
					group_name: 'Diğer',
					grup_buttons: [

						{name: 'Kasa detay', link: 'yonetim/kasa_detay/', isSpecific: false},

					]
				}

					self.buttons[2] = {
					group_name: 'Çek Senet',
					grup_buttons: [

					    {name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},

					]
				}
						self.buttons[3] = {
			group_name: 'Tahsilat Ödeme',
					grup_buttons: [

					    {name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},

					]
				}

						self.buttons[4] = {
			group_name: 'Diğer',
					grup_buttons: [

		{name: 'Gelir Gider Kategori', link: 'yonetim/gider_kategori', isSpecific: false},

					]
				}



<?php }?>




<?php if ($data['side_menu'] == "Virman Ayarları") {?>

				self.modalText="Virman Hızlı İşlemler";
	self.buttons[0] = {
					group_name: 'Virman İşlemler',
					grup_buttons: [
						{name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},
						{name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},
						{name: 'Gelir Gider Ekle', link: 'yonetim/gelir_gider/add', isSpecific: false},
						{name: 'Gelir Gider Kategori', link: 'yonetim/gider_kategori', isSpecific: false},
						{name: 'Gelir Gider', link: 'yonetim/gelir_gider', isSpecific: false},
						{name: 'Kasa detay', link: 'yonetim/kasa_detay_git/', isSpecific: true},

					]
				}


<?php }?>


<?php if ($data['side_menu'] == "Personel Ayarları") {?>
				self.modalText="Personel Hızlı İşlemler";
	self.buttons[0] = {
					group_name: 'Aday',
					grup_buttons: [
						{name: 'Aday ekle', link: 'yonetim/aday/add', isSpecific: false, type: 'add'},
						{name: 'Adaylar', link: 'yonetim/aday', isSpecific: false},
					]
				}
				self.buttons[1] = {
					group_name: 'Zimmet',
					grup_buttons: [
						{name: 'Zimmet ekle', link: 'yonetim/zimmet/add', isSpecific: false, type: 'add'},
						{name: 'Zimmet', link: 'yonetim/zimmet', isSpecific: false},
					]
				}
				self.buttons[2] = {
					group_name: 'İzin',
					grup_buttons: [
							{name: 'İzin ekle', link: 'yonetim/izin/add', isSpecific: false, type: 'add'},
						{name: 'İzin', link: 'yonetim/izin', isSpecific: false},
					]
				}


				self.buttons[3] = {
					group_name: 'Diğer',
					grup_buttons: [
						{name: 'Borç Alacak Ekle', link: 'yonetim/borc_alacak/add', isSpecific: false},
						{name: 'Borç Alacak', link: 'yonetim/borc_alacak', isSpecific: false},
						{name: 'Tahsilat Ödeme Ekle', link: 'yonetim/tahsilat_odeme/add', isSpecific: false},
						{name: 'Tahsilat Ödeme', link: 'yonetim/tahsilat_odeme', isSpecific: false},
						{name: 'Çek Senet Ekle', link: 'yonetim/cek_senet/add', isSpecific: false},
						{name: 'Çek Senet', link: 'yonetim/cek_senet', isSpecific: false},
						{name: 'Cari detay', link: 'yonetim/cari_detay_git/', isSpecific: true},



					]
				}


<?php }?>




				function checkPage() {
					let page = window.self.page;
					switch(page) {
			//			case 'Kasa Ayarları':
				//			case 'Cari Ayarları':
			//			case 'Hizmet Ürün Ayarları':
			//			case 'Teklif Ayarları':
			//			case 'Sipariş Ayarları':
			//			case 'İrsaliye Ayarları':
			//			case 'Fatura Ayarları':
			//			case 'Borç Alacak Ayarları':
			//			case 'Tahsilat - Ödeme Ayarları':
			//			case 'Çek Senet Ayarları':
			//			case 'Gelir - Gider Ayarları':
			//			case 'Virman Ayarları':
				//		case 'Personel Ayarları':
						case '':


						document.querySelectorAll('.edit_button--settings').forEach(function (item) {
							(window !== window.top) ? item.removeAttribute('onclick') : item.style.display = 'block';

						});
						break;
						default:
						document.querySelectorAll('.edit_button--settings').forEach(function (item) {
							item.removeAttribute('onclick');
						});
						break;
					}
				}
			</script>
