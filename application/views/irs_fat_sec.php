<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>

	<form action="<?php echo base_url(); ?>yonetim/irsaliye_getir" method="post" >

		<div class="material-container">

			<h2 class="material-container__heading">

	<?php if ($data['side_menu'] == "Satış Fatura Ayarları") {echo 'Satış Faturası';}?>
	<?php if ($data['side_menu'] == "Alış Fatura Ayarları") {echo 'Alış Faturası';}?>
	<?php if ($data['side_menu'] == "İrsaliye Fatura Ayarları") {echo 'İrsaliye Faturası';}?>



			</h2>



			<div class="material-container__row musteri_bilgi">

	<?php if ($data['side_menu'] == "Satış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="Fatura Türü" class="material-container__input" />';}?>
	<?php if ($data['side_menu'] == "Alış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="Fatura Türü" class="material-container__input" />';}?>




	<!--
				<select id="mus" name="mus" required placeholder="Müşteri" class="material-container__input">
						<option value="">Cari Seçiniz</option>
			<?php if ($data["cari_getir"]): foreach ($data["cari_getir"] as $dizi): ?>
				<option value="<?php echo $dizi["id"]; ?>"><?php echo $dizi["adi_soyadi"]; ?></option>
				<?php endforeach;endif;?>
			</select>
						<select id="fat_turu" name="fat_turu" required placeholder="Fatura Türü" class="material-container__input">
						<option value="">Fatura Türü Seçiniz</option>
			<option value="Alış">Alış</option>
			<option value="Satış">Satış</option>
			</select>
					-->






			</div>

		<div class="fatura_row__genel-bilgi">
		<?php if ($data["musteri"]): ?>			<br>
		Seçili Müşteri: <?php echo $data["musteri"]; ?>
	<?php endif;?>
		<?php if ($data["fat_turu"]): ?>		<br>
		 Seçili Fatura Türü:	<?php echo $data["fat_turu"]; ?>
		<?php endif;?>
					<br>



		</div>


		<!--	<div class="faturaGonder">
				<input type="submit" value="İrsaliyeleri Getir" class="flex-right">
			</div>
		-->
	</form>
	<form action="<?php echo base_url(); ?>yonetim/fat_irs_ekle" method="post" >
			<?php if ($data["irsaliye"]): ?>
	Tarih - İrsaliye No - Açıklama<br><br>
	<?php endif;?>
					<?php $s = 0;
$n            = 0;if ($data["irsaliye"]): foreach ($data["irsaliye"] as $dizi):
        if ($data["fat_durum"][$n] == "Kapalı") {
            $n = $n + 1;
            continue;}
        ?>



				<input type="checkbox" name='irsaliye[]' value="<?php echo $dizi["id"]; ?>">
				<?php echo $dizi["tarih"]; ?> - <?php echo $dizi["irsaliye_no"]; ?> - <?php echo $dizi["aciklama"]; ?>
		 - <a href="<?php echo base_url(); ?>yonetim/irsaliye_goruntule/<?php echo $dizi["id"]; ?>"> Görüntüle </a>
				<br>
					<?php $s = 1;
        $n          = $n + 1;endforeach;?>
	<input id="fat_turu" name="fat_turu" value="<?php echo $data["fat_turu"]; ?>" type="hidden" placeholder="Fatura Türü" class="material-container__input" />

	<input id="mus_id" name="mus_id" value="<?php echo $data["musteri_id"]; ?>" type="hidden" class="material-container__input" />

	<input id="fat_id" name="fat_id" value="<?php echo $data["fat_id"]; ?>" type="hidden" class="material-container__input" />


	<input id="mus" name="mus" value="<?php echo $data["musteri"]; ?>" type="hidden" class="material-container__input" /><br><br>

			<?php if ($s == 1) {?>
					<input type="submit" value="Seçilileri Faturaya Ekle" class="flex-right">

			<?php }?>

			</div>



		</form>

	<?php endif;?>


</body>







<?php $this->load->view('footer_ozel.php');?>
<script
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>

<script>

	$(document).ready(function() {

		$('.datepicker').datepicker();

			$('body').on('keyup change', '.urunInput', function() {
				var
				itemsLength = $('.item').length,
				aratoplam	= Number(0),
				indirim		= Number(0),
				vergi			= Number(0),
				toplam		= Number(0);




				for(var n=1; n <= itemsLength; n++ ){


					var
					prc			= Number($("input[name*='prc_"+n+"']").val()),
					qty			= Number($("input[name*='qty_"+n+"']").val()),
					tax			= Number($("input[name*='tax_"+n+"']").val()),
					dis			= Number($("input[name*='discount_"+n+"']").val());


					var
					total			= prc * qty,
					aratoplam	= aratoplam + total;

					var
					dis_amount	= total / 100,
					dis_amount	= dis_amount * dis;
					indirim = indirim + dis_amount;

					total = total - dis_amount;

					var
					tax_amount = total / 100,
					tax_amount = tax_amount * tax;
					vergi = vergi + tax_amount;

					total = total + tax_amount;
					toplam = toplam + total;

					$(".total_" + n).text(total.toFixed(2));
					$("input[name*='total_"+n+"']").val(total.toFixed(2));


					$(".indirim").text(indirim.toFixed(2));
					$(".vergi").text(vergi.toFixed(2));
					$(".toplam").text(toplam.toFixed(2));
					$(".ara_toplam").text(aratoplam.toFixed(2));

					$("#indirim").val(indirim.toFixed(2));
					$("#vergi").val(vergi.toFixed(2));
					$("#toplam").val(toplam.toFixed(2));
					$("#ara_toplam").val(aratoplam.toFixed(2));


					$("#top_alan").val(itemsLength);

				}




		});

	});




	$('#add').click(function () {
		var
		n		= $('.item').length + 1,
		temp	= $('.item:first').clone();

		$('input:first', temp).attr('placeholder', 'Ürün/Hizmet #' + n);


		/*$('#des', temp).attr('placeholder', 'Açıklama #' + n);
		$('#pr', temp).attr('placeholder', 'Fiyat #' + n);
		$('#qt', temp).attr('placeholder', 'Miktar #' + n);
		$('#tx', temp).attr('placeholder', 'Vergi & #' + n);
		$('#dis', temp).attr('placeholder', 'İndirim #' + n);
		$('#tot', temp).attr('placeholder', 'Toplam #' + n);*/

		$('#des', temp).attr({
			'placeholder': 'Açıklama #' + n,
			'name': 'des_' + n
		}).val('');

		$('#pr', temp).attr({
			'placeholder': 'Fiyat #' + n,
			'name': 'prc_' + n
		}).val('');

		$('#qt', temp).attr({
			'placeholder': 'Miktar #' + n,
			'name': 'qty_' + n
		}).val('');

		$('#tx', temp).attr({
			'placeholder': 'Vergi & #' + n,
			'name': 'tax_' + n
		}).val('');


		$('#dis', temp).attr({
			'placeholder': 'İndirim #' + n,
			'name': 'discount_' + n
		}).val('');


		$('#tot', temp).attr('class', 'totalSpan total_' + n).text('0.00');

		$('#tot_hidden', temp).attr('name', 'total_' + n).val(0.00);

		$('#item', temp).attr('name', 'item_' + n).val('');

		/*$('#des', temp).attr('name', 'des_' + n).val('');
		$('#pr', temp).attr('name', 'prc_' + n).val('');
		$('#qt', temp).attr('name', 'qty_' + n).val('');
		$('#tx', temp).attr('name', 'tax_' + n).val('');
		$('#dis', temp).attr('name', 'discount_' + n).val('');
		$('#tot', temp).attr('name', 'total_' + n).val('');*/




		$('.item:last').after(temp);
					$("#top_alan").text(n);

	});
/*
	function hesapla (){
		items();
		totals();
	}

	function items (){

		var uzunluk = $('.item').length;
		//alert(uzunluk);


	for(var n=1; n<=uzunluk; n++ ){

		var prc = Number($("input[name*='prc_"+n+"']").val());
		var qty = Number($("input[name*='qty_"+n+"']").val());
		var tax = Number($("input[name*='tax_"+n+"']").val());
		var dis = Number($("input[name*='discount_"+n+"']").val());



		var total = prc * qty ;

		var dis_amount = total / 100;
		dis_amount = dis_amount * dis;

		total = total - dis_amount;

		var tax_amount = total / 100;
		tax_amount = tax_amount * tax;


		total = total + tax_amount;

		$("input[name*='total_"+n+"']").val(total.toFixed(2));


	}

}

function totals (){



	var
	uzunluk		= $('.item').length;
	aratoplam	= Number(0),
	indirim		= Number(0),
	vergi			= Number(0),
	toplam		= Number(0);

	for(var n=1; n<=uzunluk; n++ ){

		var prc = Number($("input[name*='prc_"+n+"']").val());
		var qty = Number($("input[name*='qty_"+n+"']").val());
		var tax = Number($("input[name*='tax_"+n+"']").val());
		var dis = Number($("input[name*='discount_"+n+"']").val());


		var total = prc * qty ;
		aratoplam = aratoplam + total;


		var dis_amount = total / 100;
		dis_amount = dis_amount * dis;
		indirim = indirim + dis_amount;

		total = total - dis_amount;

		var tax_amount = total / 100;
		tax_amount = tax_amount * tax;
		vergi = vergi + tax_amount;

		total = total + tax_amount;

		toplam = toplam + total;



	}

	// alert(aratoplam);
	//sayi.toFixed(2);

	$("input[name*='indirim']").val(indirim.toFixed(2));
	$("input[name*='vergi']").val(vergi.toFixed(2));
	$("input[name*='toplam']").val(toplam.toFixed(2));
	$("input[name*='ara_toplam']").val(aratoplam.toFixed(2));
}

*/

$('#del').click(function () {
	var n = $('.item').length;
	if(n!=1){$('.item:last').remove();
		$("#top_alan").text(n);
}

});



</script>