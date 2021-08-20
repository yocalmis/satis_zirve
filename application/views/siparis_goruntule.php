<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">

<?php

$n       = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
        $kalan = $dizi["adet"] - $dizi["aktarim"];
        if ($kalan <= 0) {continue;}
        $n = $n + 1;endforeach;endif;

if ($n == 0) {$aktarim = 0;} else { $aktarim = 1;}

?>

<body> <?php if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi_fat): $irs_durum = $dizi_fat["irsaliye_durum"];
        $fat_id                                                                                                           = $dizi_fat["id"];
        $iade_fat                                                                                                         = $dizi_fat["iade_fat"];?>


		<div class="material-container">

			<?php

                $submit_button_value_irsaliye  = '';
                $irsaliye_input_name_irsaliye  = '';
                $irsaliye_input_value_irsaliye = '';

                $submit_button_value_fatura  = '';
                $irsaliye_input_name_fatura  = '';
                $irsaliye_input_value_fatura = '';



        if ($data['fat_turu'] == "GelenSiparis") {
            $form_link_irsaliye = base_url() . 'yonetim/gel_sip_irs_akt/' . $fat_id;
            $form_link_fatura   = base_url() . 'yonetim/gel_sip_fat_akt/' . $fat_id;
            $heading_title      = 'Gelen Sipariş';
            if ($aktarim == 1) {
                $submit_button_value_irsaliye  = 'İRSALİYE AKTAR';
                $irsaliye_input_name_irsaliye  = 'irsaliye';
                $irsaliye_input_value_irsaliye = 'alinan';

                $submit_button_value_fatura  = 'FATURA AKTAR';
                $irsaliye_input_name_fatura  = 'fatura';
                $irsaliye_input_value_fatura = 'Satış';
            }
        }
        if ($data['fat_turu'] == "GidenSiparis") {
            $form_link_irsaliye = base_url() . 'yonetim/gid_sip_irs_akt/' . $fat_id;
            $form_link_fatura   = base_url() . 'yonetim/gid_sip_fat_akt/' . $fat_id;
            $heading_title      = 'Giden Sipariş';
            if ($aktarim == 1) {
                $submit_button_value_irsaliye  = 'İRSALİYE AKTAR';
                $irsaliye_input_name_irsaliye  = 'irsaliye';
                $irsaliye_input_value_irsaliye = 'verilen';

                $submit_button_value_fatura  = 'FATURA AKTAR';
                $irsaliye_input_name_fatura  = 'fatura';
                $irsaliye_input_value_fatura = 'Alış';
            }
        }


          if ($aktarim == 1) {


        ?>

			<h2 class="material-container__heading">
				<span class="material-container__title"><?php echo $heading_title; ?></span>
				<form
				action="<?php echo $form_link_irsaliye ?>"
				method="POST">
					<input type="submit" value="<?php echo $submit_button_value_irsaliye; ?>"/>
					<input type="hidden"
					name="<?php echo $irsaliye_input_name_irsaliye; ?>"
					value="<?php echo $irsaliye_input_value_irsaliye; ?>" />
				</form>
				<form
					action="<?php echo $form_link_fatura ?>"
					method="POST">
						<input type="submit" value="<?php echo $submit_button_value_fatura; ?>"/>
						<input type="hidden"
						name="<?php echo $irsaliye_input_name_fatura; ?>"
						value="<?php echo $irsaliye_input_value_fatura; ?>" />
				</form>
			</h2>

     <?php
}
        
        ?>


		<form action="<?php echo base_url(); ?>yonetim/siparis_guncelle" method="post" >

			<div class="material-container__row musteri_bilgi">

				<input id="fat_turu" readonly="true" name="fat_turu" value="Sipariş" type="hidden" placeholder="Fatura Türü" class="material-container__input" />

				<select id="mus" readonly="true" name="mus" required placeholder="Müşteri" class="material-container__input">
					<option selected value="<?php echo $c_id = $dizi_fat["cari_id"]; ?>"><?php echo $c_ad = $data["cari_ad"]; ?></option>

				</select>
				<!--	<input id="mus" name="mus" type="text" required placeholder="Müşteri" class="material-container__input" />-->







				<input readonly="true" id="seri" name="seri" type="text" value="<?php $fat_id = $dizi_fat["id"];
        echo $dizi_fat["seri_no"];?>" required placeholder="Seri No" class="material-container__input" />
				<input readonly="true" id="no" name="no" type="text" required value="<?php echo $dizi_fat["fatura_no"]; ?>" placeholder="Fatura No" class="material-container__input" />
				<input
				id="duz_ta"
				name="duz_ta"  readonly="true"
				value="<?php $parca = explode("-", $dizi_fat["tarih"]);
        echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
				type="text"  required
				placeholder="Düzenleme Tarihi"
				class="material-container__input datepicke" />
				<input
				id="va_ta"
				name="va_ta"  readonly="true"
				value="<?php $parca = explode("-", $dizi_fat["vade_tarihi"]);
        echo $parca[1] . "/" . $parca[2] . "/" . $parca[0];?>"
				type="text"  required
				placeholder="Vade Tarihi"
				class="material-container__input datepicke" />



			</div>
			<div class="material-container__row">
				<input id="ack" readonly="true" name="ack" type="text"  required placeholder="Açıklama" value="<?php echo $dizi_fat["aciklama"]; ?>" style="width: 100%" class="material-container__input" />

			</div>
			<?php $n = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi): ?>
				<div class="material-container__row fatura_row item">
					<div class="fatura_row__genel-bilgi">
						<!--	<input id="item" type="text" name="item_1"  required placeholder="Ürün/Hizmet #1" class="material-container__input" />-->



						<select id="item" readonly="true"  name="item_<?php echo $n + 1; ?>"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >

							<option selected value="<?php echo $dizi["hizmet_urun_id"]; ?>"><?php echo $data["urun_ad"][$n]; ?></option>
						</select>


						<input readonly="true" id="des" type="text" name="des_<?php echo $n + 1; ?>" value="<?php echo $dizi["aciklama"]; ?>"   placeholder="Açıklama" class="material-container__input" />

					</div>
					<div class="fatura_row__genel-veriler">
						<input id="pr" readonly="true" type="number" name="prc_<?php echo $n + 1; ?>" value="<?php echo $dizi["birim_fiyat"]; ?>"  required min="0" placeholder="Fiyat" class="material-container__input urunInput" />
						<input id="qt" readonly="true" type="number" name="qty_<?php echo $n + 1; ?>" value="<?php echo $dizi["adet"]; ?>"  required min="0" placeholder="Miktar" class="material-container__input urunInput" />
						<input id="qt"  readonly="true" type="text" readonly="true" value="Aktarılan:<?php echo $dizi["aktarim"]; ?>"  required min="0" placeholder="Aktarılan:0" class="material-container__input urunInput" />
						<input id="dis" readonly="true" type="number" name="discount_<?php echo $n + 1; ?>" value="<?php echo $dizi["indirim"]; ?>"  required min="0" placeholder="İndirim" class="material-container__input urunInput" />
						<input id="tx" readonly="true" type="number" name="tax_<?php echo $n + 1; ?>" value="<?php echo $dizi["vergi"]; ?>"  min="0" placeholder="Vergi " class="material-container__input urunInput" />
						<span> <span id="tot" class="totalSpan total_<?php echo $n + 1; ?>"><?php echo $dizi["tutar"] . " " . $this->session->userdata('para_birim'); ?></span></span>
						<input readonly="true" id="tot_hidden" type="hidden" value="<?php echo $dizi["tutar"]; ?>" name="total_<?php echo $n + 1; ?>"/>
					</div>

				</div>

				<?php $n = $n + 1;endforeach;endif;?>



		<div class="material-container__row">


		</div>

		<div class="faturaSonuc">


			<div class="faturaSonuc__row">
				<span class="faturaSonuc__title">Ara Toplam </span>
				<span class="faturaSonuc__number ara_toplam"><?php echo $dizi_fat["tutar"] . " " . $this->session->userdata('para_birim'); ?></span>
			</div>
			<div class="faturaSonuc__row">
				<span class="faturaSonuc__title">İndirim </span>
				<span class="faturaSonuc__number indirim"><?php echo $dizi_fat["indirim"] . " " . $this->session->userdata('para_birim'); ?></span>
			</div>
			<div class="faturaSonuc__row">
				<span class="faturaSonuc__title">Vergi </span>
				<span class="faturaSonuc__number vergi"><?php echo $dizi_fat["vergi"] . " " . $this->session->userdata('para_birim'); ?></span>
			</div>
			<div class="faturaSonuc__row">
				<span class="faturaSonuc__title">Toplam </span>
				<span class="faturaSonuc__number toplam"><?php echo $dizi_fat["toplam"] . " " . $this->session->userdata('para_birim'); ?></span>
			</div>

			<input id="ara_toplam" type="hidden" value="<?php echo $dizi_fat["tutar"]; ?>" name="ara_toplam" />
			<input id="indirim" type="hidden" value="<?php echo $dizi_fat["indirim"]; ?>" name="indirim" />
			<input id="vergi" type="hidden"  value="<?php echo $dizi_fat["vergi"]; ?>" name="vergi" />
			<input id="toplam" type="hidden"  value="<?php echo $fat_toplam = $dizi_fat["toplam"]; ?>" name="toplam" >
			<input id="top_alan" type="hidden"  value="<?php echo count($data["siparis_item_getir_duzenle"]); ?>" name="top_alan" />
			<input id="fat_id" type="hidden" value="<?php echo $fat_id = $dizi_fat["id"]; ?>" name="fat_id" />
		</div>

		<div class="faturaGonder">
			<!--		<input type="submit" value="Faturayı Güncelle" class="flex-right">-->
		</div>









	</form><br><br>





	<?php	endforeach;endif;?>




</body>



<br><br><h2>
	TÜM NOTLAR
</h2>

<?php $n = 1;if ($data["fatura_not_getir"]): foreach ($data["fatura_not_getir"] as $dizi):

        echo $n . " : " . $dizi["tarih"] . " - " . $dizi["aciklama"] . " - <a href='" . base_url() . "yonetim/fat_not_sil/siparis/" . $dizi["fat_id"] . "/" . $dizi["id"] . "'>Sil</a><br>";

        $n = $n + 1;endforeach;endif;?>
<br><br>
<form method="post" action="<?php echo base_url(); ?>yonetim/fatura_not_al" class="input_form">
	<input type="text" name="task" class="task_input">
	<input type="hidden" name="fat_id"  value="<?php echo $fat_id; ?>" class="task_input">
	<input type="hidden" name="fat_turu"  value="siparis" class="task_input">
	<input type="submit" value="Ekle" name="submit">
</form>


</div>




<?php $this->load->view('footer_ozel.php');?>
<script
src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui') ?>/jquery-ui-1.10.3.custom.min.js">
</script>

<script>

	$(document).ready(function() {

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