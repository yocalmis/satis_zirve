<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Mevcut Yedekler </h2>


		<a class="sidenav__link mine-content__link" href='<?php echo site_url('yedek/yedek_al') ?>'>
					<button >
					Yeni Yedek Al</button>
				</a>





	<div style="float:right; margin-left:auto; margin-right:0;">



	</div>
</div>

		<div class="material-container">

<?php

foreach ($data['yedekler'] as $dosya) {
    echo $dosya . " <a href='assets/uploads/yedek/" . $dosya . "'>İndir</a> - <a href='" . base_url() . "yedek/yedek_sil/" . $dosya . "'>Sil</a> <br>";

}

?>
<br><br>

 		  - <?php echo count($data['yedekler']); ?> yedek dosyası mevcut.
		  <br>- Bu işlem yetki gerektirir.
		  <br>- 1 saatte sadece 1 yedek alabilirsiniz.
		  <br>- Maksimum 5 yedek saklayabilirsiniz.5 adet yedeğiniz varsa yeni yedek alındığında en eskisi silinecektir.

		</div>



</body>







<?php $this->load->view('footer_ozel.php');?>




















