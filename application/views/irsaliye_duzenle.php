<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>
<?php if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi_fat): ?>
		<form action="<?php echo base_url(); ?>yonetim/irsaliye_guncelle" method="post" >

			<div class="material-container">

				<h2 class="material-container__heading">

		<?php if ($data['side_menu'] == "Satış İrsaliye Ayarları") {echo 'Satış İrsaliyesi';}?>
		<?php if ($data['side_menu'] == "Alış İrsaliye Ayarları") {echo 'Alış İrsaliyesi';}?>



				</h2>



				<div class="material-container__row musteri_bilgi">

		<?php if ($data['side_menu'] == "Satış İrsaliye Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="İrsaliye Türü" class="material-container__input" />';}?>
		<?php if ($data['side_menu'] == "Alış İrsaliye Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="İrsaliye Türü" class="material-container__input" />';}?>

					<select id="mus" name="mus" required placeholder="Müşteri" class="material-container__input">
	<option selected value="<?php echo $dizi_fat["cari_id"]; ?>"><?php echo $data["cari_ad"]; ?></option>

				<?php if ($data["cari_getir"]): foreach ($data["cari_getir"] as $dizi_cari): ?>
					<option value="<?php echo $dizi_cari["id"]; ?>"><?php echo $dizi_cari["adi_soyadi"]; ?></option>
					<?php endforeach;endif;?>
			</select>
				<!--	<input id="mus" name="mus" type="text" required placeholder="Müşteri" class="material-container__input" />-->


					<input  id="no" name="no" type="text" required placeholder="İrsaliye No" class="material-container__input" value="<?php echo $dizi_fat["irsaliye_no"]; ?>"/>


						<input
							id="duz_ta"
							name="duz_ta"
							value="<?php $parca = explode("-", $dizi_fat["tarih"]);
echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
							type="text"  required
							placeholder="Düzenleme Tarihi"
							class="material-container__input datepicker" />
						<input
							id="va_ta"
							name="va_ta"
							value="<?php $parca = explode("-", $dizi_fat["vade_tarihi"]);
echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
							type="text"  required
							placeholder="Vade Tarihi"
							class="material-container__input datepicker" />

	<input  id="seri" name="il" type="text" required placeholder="İlçe/İl" value="<?php echo $dizi_fat["il"]; ?>" class="material-container__input" />

			</div>
			<div class="material-container__row">
				<input id="adr" name="adr" type="text"  required placeholder="Adres" style="width: 100%" class="material-container__input" value="<?php echo $dizi_fat["adres"]; ?>" />

			</div>
			<div class="material-container__row">
				<input id="ack" name="ack" type="text"  required placeholder="Açıklama" value="<?php echo $dizi_fat["aciklama"]; ?>" style="width: 100%" class="material-container__input" />

			</div>
	<?php $n = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi): ?>
				<div class="material-container__row fatura_row item">
					<div class="fatura_row__genel-bilgi">
					<!--	<input id="item" type="text" name="item_1"  required placeholder="Ürün/Hizmet #1" class="material-container__input" />-->



							<select id="item"  name="item_<?php echo $n + 1; ?>"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >

				<option selected value="<?php echo $dizi["hizmet_urun_id"]; ?>"><?php echo $data["urun_ad"][$n]; ?></option>
				<?php if ($data["urun_getir"]): foreach ($data["urun_getir"] as $dizi_mus): ?>
					<option value="<?php echo $dizi_mus["id"]; ?>"><?php echo $dizi_mus["adi"]; ?></option>
					<?php endforeach;endif;?>
			</select>


					<input  id="des" type="text" name="des_<?php echo $n + 1; ?>" value="<?php echo $dizi["aciklama"]; ?>"   placeholder="Açıklama" class="material-container__input" />
						<input id="qt" type="number" name="qty_<?php echo $n + 1; ?>"  required min="0" placeholder="Miktar" class="material-container__input urunInput" value="<?php echo $dizi["adet"]; ?>"/>

				</div>


			</div>

			<?php $n = $n + 1;endforeach;endif;?>



			<div class="material-container__row">

				<input type='button' id='add' class="faturaItem faturaItem__add" value='Ürün/Hizmet Ekle' />
				<input type='button' id='del' class="faturaItem faturaItem__del" value='Ürün/Hizmet Sil' />

			</div>

			<div class="faturaSonuc">


				<input id="top_alan" type="hidden"  value="<?php echo count($data["irsaliye_item_getir_duzenle"]); ?>" name="top_alan" />
				<input id="fat_id" type="hidden" value="<?php echo $dizi_fat["id"]; ?>" name="fat_id" />
			</div>


				<div class="faturaGonder">
				<div class="small-loading" id="FormLoading" style="display: none;">
					Yükleniyor, veri kaydediliyor...
				</div>
				<input type="submit" value="İrsaliyeyi Güncelle" class="flex-right">
			</div>
			<div id="report-error" class="report-div error" style="display: none;">
				<p>Bir şeyler yanlış gitti.</p>
			</div>
			<div id="report-success" class="report-div success" style="display: none;">
				<p>Veri başarıyla veritabanına kaydedildi.</p>
			</div>

		</div>






	</form>
		<?php	endforeach;endif;?>
</body>







<?php $this->load->view('footer_ozel.php');?>
<script
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>
<script
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/') ?>/jquery.form.min.js">
</script>
<script>

	$(document).ready(function() {


		$('form').submit(function(e){
			var my_crud_form = $(this);

			$(this).ajaxSubmit({
				url: $(this).data('action'),
				dataType: 'json',
				cache: 'false',
				beforeSend: function(jqxhr, data) {
					$('#FormLoading').show();
				},
				success: function(data){
					$('#FormLoading').hide();
					$('#report-success').show();

					console.log(data)
				},
				error: function(data){
					$('#FormLoading').hide();
					console.log(data)

					console.log('oops we have error')
				}
			});
			return false;
		});


		$('.datepicker').datepicker();

		var faturaHesapla = function() {

				var
				itemsLength = $('.item').length,
				aratoplam	= Number(0),
				indirim		= Number(0),
				vergi		= Number(0),
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


		}



		$('body').on('keyup change', '.urunInput', faturaHesapla);

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