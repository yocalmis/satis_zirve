<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">

<?php

$n = 0;
if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
        $kalan = $dizi["adet"] - $dizi["aktarim"];
        if ($kalan <= 0) {continue;}
        $n = $n + 1;endforeach;endif;

if ($n == 0) {$aktarim = 0;} else { $aktarim = 1;}

?>

	<body>
		<?php if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi_fat): $fat_id = $dizi_fat["id"];?>


					<div class="material-container">

						<?php
        if ($data['side_menu'] == "Satış İrsaliye Ayarları") {
            $form_link_irsaliye = base_url() . 'yonetim/sat_irs_fat_akt/' . $fat_id;
            $heading_title      = 'Satış İrsaliyesi';
            if ($aktarim == 1) {
                $submit_button_value_irsaliye  = 'FATURA AKTAR';
                $irsaliye_input_name_irsaliye  = 'fatura';
                $irsaliye_input_value_irsaliye = 'satis';
            }
        }
        if ($data['side_menu'] == "Alış İrsaliye Ayarları") {
            $form_link_irsaliye = base_url() . 'yonetim/al_irs_fat_akt/' . $fat_id;
            $heading_title      = 'Alış İrsaliyesi';
            if ($aktarim == 1) {
                $submit_button_value_irsaliye  = 'FATURA AKTAR';
                $irsaliye_input_name_irsaliye  = 'fatura';
                $irsaliye_input_value_irsaliye = 'alis';
            }
        }
        ?>
						<h2 class="material-container__heading">
							<span class="material-container__title"><?php echo $heading_title ?></span>
							<form method="POST" action="<?php echo $form_link_irsaliye ?>">

								<input type="submit" value="<?php echo $submit_button_value_irsaliye ?>"/>
								<input type="hidden"
								name="<?php echo $irsaliye_input_name_irsaliye ?>"
								value="<?php echo $irsaliye_input_value_irsaliye ?>" />
							</form>
						</h2>



						<div class="material-container__row musteri_bilgi">

							<?php if ($data['side_menu'] == "Satış İrsaliye Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="İrsaliye Türü" class="material-container__input" />';}?>
							<?php if ($data['side_menu'] == "Alış İrsaliye Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="İrsaliye Türü" class="material-container__input" />';}?>

							<select id="mus"   readonly="true" name="mus" required placeholder="Müşteri" class="material-container__input">
								<option selected value="<?php echo $dizi_fat["cari_id"]; ?>"><?php echo $data["cari_ad"]; ?></option>

							</select>
							<!--	<input id="mus" name="mus" type="text" required placeholder="Müşteri" class="material-container__input" />-->



							<input  id="no"   readonly="true"  readonly="true" name="no" type="text" required placeholder="İrsaliye No" class="material-container__input" value="<?php echo $dizi_fat["irsaliye_no"]; ?>"/>



							<input
							id="duz_ta"
							name="duz_ta"   readonly="true"
							value="<?php $parca = explode("-", $dizi_fat["tarih"]);
        echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
							type="text"  required
							placeholder="Düzenleme Tarihi"
							class="material-container__input datepicke" />
							<input
							id="va_ta"
							name="va_ta"   readonly="true"
							value="<?php $parca = explode("-", $dizi_fat["vade_tarihi"]);
        echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
							type="text"  required
							placeholder="Vade Tarihi"
							class="material-container__input datepicke" />

							<input  id="seri"   readonly="true" name="il" type="text" required placeholder="İlçe/İl" value="<?php echo $dizi_fat["il"]; ?>" class="material-container__input" />

						</div>
						<div class="material-container__row">
							<input id="adr"   readonly="true" name="adr" type="text"  required placeholder="Adres" style="width: 100%" class="material-container__input" value="<?php echo $dizi_fat["adres"]; ?>" />

						</div>
						<div class="material-container__row">
							<input id="ack"   readonly="true" name="ack" type="text"  required placeholder="Açıklama" value="<?php echo $dizi_fat["aciklama"]; ?>" style="width: 100%" class="material-container__input" />

						</div>
						<?php $n = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi): ?>
							<div class="material-container__row fatura_row item">
								<div class="fatura_row__genel-bilgi">
									<!--	<input id="item" type="text" name="item_1"  required placeholder="Ürün/Hizmet #1" class="material-container__input" />-->



									<select id="item"   readonly="true" name="item_<?php echo $n + 1; ?>"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >

										<option selected value="<?php echo $dizi["hizmet_urun_id"]; ?>"><?php echo $data["urun_ad"][$n]; ?></option>
									</select>


									<input   readonly="true" id="des" type="text" name="des_<?php echo $n + 1; ?>" value="<?php echo $dizi["aciklama"]; ?>"   placeholder="Açıklama" class="material-container__input" />
									<input id="qt" type="number"   readonly="true" name="qty_1"  required min="0" placeholder="Miktar" class="material-container__input urunInput" value="<?php echo $dizi["adet"]; ?>"/>

									<input id="qt"   readonly="true" readonly="true" type="text" readonly="true" value="Aktarılan:<?php echo $dizi["aktarim"]; ?>"  required min="0" placeholder="Aktarılan:0" class="material-container__input urunInput" />

								</div>


							</div>

							<?php $n = $n + 1;endforeach;endif;?>



					<div class="material-container__row">


					</div>

					<div class="faturaSonuc">






						<input id="top_alan" type="hidden"  value="<?php echo count($data["irsaliye_item_getir_duzenle"]); ?>" name="top_alan" />
						<input id="fat_id" type="hidden" value="<?php echo $fat_id = $dizi_fat["id"]; ?>" name="fat_id" />
					</div>

					<div class="faturaGonder">
						<!--		<input type="submit" value="Faturayı Güncelle" class="flex-right">-->
					</div>

						<script
						src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
					</script>












			</form>


		<?php	endforeach;endif;?>




	<div id="tabs">
							<ul>
								<li><a href="#tabs-1">FATURALAR</a></li>
								<li><a href="#tabs-2">NOTLAR</a></li>

							</ul>
							<div id="tabs-1">

				Tarih - Fatura No - Açıklama<br><br>
				<?php $total = 0;
$n               = 0;if ($data["faturalar"]): foreach ($data["faturalar"] as $dizi_ft): ?>





					<div style="float:justify;">

						<?php echo $dizi_ft[$n]["tarih"]; ?> - <?php echo $dizi_ft[$n]["fatura_no"]; ?> - <?php echo $dizi_ft[$n]["aciklama"]; ?> - <a href="<?php echo base_url(); ?>yonetim/fatura_goruntule/<?php echo $dizi_ft[$n]["id"]; ?>"> Görüntüle </a>
						<br>
					</div>




				<?php	endforeach;endif;?>


							 </div>
<div id="tabs-2">

	<?php $n = 1;if ($data["fatura_not_getir"]): foreach ($data["fatura_not_getir"] as $dizi):

        echo $n . " : " . $dizi["tarih"] . " - " . $dizi["aciklama"] . " - <a href='" . base_url() . "yonetim/fat_not_sil/irsaliye/" . $dizi["fat_id"] . "/" . $dizi["id"] . "'>Sil</a><br>";

        $n = $n + 1;endforeach;endif;?>
	<br><br>
	<form method="post" action="<?php echo base_url(); ?>yonetim/fatura_not_al" class="input_form">
		<input type="text" name="task" class="task_input">
		<input type="hidden" name="fat_id"  value="<?php echo $fat_id; ?>" class="task_input">
		<input type="hidden" name="fat_turu"  value="irsaliye" class="task_input">
		<input type="submit" value="Ekle" name="submit">
	</form>


 </div>


</div>







</div>
</body>







<?php $this->load->view('footer_ozel.php');?>
<script
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>

<script>

	$(document).ready(function() {
				$("#tabs").tabs();
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