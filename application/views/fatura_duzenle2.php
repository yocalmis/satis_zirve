<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>

<?php if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi_fat): ?>
	<form action="<?php echo base_url(); ?>yonetim/fatura_guncelle" method="post" >

<!--
<input  type="checkbox" id="new" name="new" value="1">
-->
<label id="top_box" for="vehicle1"> Yeni Müşteri </label><br>

<input id="ccid" name="ccid" type="hidden" value="<?php echo $data["cari_id"] ?>" required placeholder="New_Status" style="width: 100%" class="material-container__input" />			
				
		<div class="material-container" id="tb2" style="display: none;">
			<div id="top_box2" class="material-container__row">
<label id="top_box2" for="vehicle1">  </label><br>
		</div>	
		</div>

	<?php if ($data['side_menu'] == "Satış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="Sipariş Türü" class="material-container__input" />';}?>
		<?php if ($data['side_menu'] == "Alış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="Sipariş Türü" class="material-container__input" />';}?>


		<div class="material-container"  id="newform">

			<div class="material-container__row">
				<input id="new_status" name="new_status" type="hidden"  required placeholder="New_Status" style="width: 100%" class="material-container__input" />			
				<input id="ad" name="ad" type="text"  required placeholder="Adı Soyadı / Ünvanı" style="width: 100%" class="material-container__input" />
				<input id="yet" name="yet" type="text"  required placeholder="Yetkili / Kullanıcı" style="width: 100%" class="material-container__input" />
				<input id="vd" name="vd" type="text"  required placeholder="Vergi Dairesi" style="width: 100%" class="material-container__input" />
				<input id="vn" name="vn" type="number"  required placeholder="Vergi No" style="width: 100%" class="material-container__input" />
				<input id="mn" name="mn" type="number"  required placeholder="Müşteri No" style="width: 100%" class="material-container__input" />			
		</div>
			<div class="material-container__row">	
				<input id="tc" name="tc" type="number"  placeholder="Şahıs İse Tc No" style="width: 100%" class="material-container__input" />			
				<input id="ep" name="ep" type="email"  required placeholder="E-Posta Adresi" style="width: 100%" class="material-container__input" />
				<input id="cp" name="cp" type="number"  required placeholder="Cep Telefonu" style="width: 100%" class="material-container__input" />
				<input id="tl" name="tl" type="number"  required placeholder="Telefon" style="width: 100%" class="material-container__input" />
		
			</div>			
			<div class="material-container__row">
							<input id="fx" name="number" type="text"  placeholder="Fax" style="width: 100%" class="material-container__input" />				
				<input id="il" name="il" type="text"  required placeholder="Şehir" style="width: 100%" class="material-container__input" />		
				<input id="ilc" name="ilc" type="text"  required placeholder="İlçe" style="width: 100%" class="material-container__input" />
				<input id="adr" name="adr" type="text"  required placeholder="Adres" style="width: 100%" class="material-container__input" />
				
			</div>				
		
			<div class="material-container__row">
				<input id="fkd" name="fkd" type="text"  required placeholder="Faaliyet Kodu" style="width: 100%" class="material-container__input" />
				<input id="fad" name="fad" type="text"  required placeholder="Faaliyet Adı" style="width: 100%" class="material-container__input" />
			
			</div>	
		
		</div>	
			
			
			
			


		<div class="material-container">

			<h2 class="material-container__heading">

	<?php if ($data['side_menu'] == "Satış Fatura Ayarları") {echo 'Sipariş';}?>
	<?php if ($data['side_menu'] == "Alış Fatura Ayarları") {echo 'Alış Faturası';}?>



			</h2>



			<div class="material-container__row musteri_bilgi">

	<?php if ($data['side_menu'] == "Satış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Satış" type="hidden" placeholder="Sipariş Türü" class="material-container__input" />';}?>
	<?php if ($data['side_menu'] == "Alış Fatura Ayarları") {echo '<input id="fat_turu" name="fat_turu" value="Alış" type="hidden" placeholder="Sipariş Türü" class="material-container__input" />';}?>

				<select id="mus" name="mus" required="required" placeholder="Müşteri" class="material-container__input">
					<option selected value="<?php echo $dizi_fat["cari_id"]; ?>"><?php echo $data["cari_ad"]; ?></option>
			</select>
				<!--	<input id="mus" name="mus" type="text" required placeholder="Müşteri" class="material-container__input" />-->







					<input  id="seri" name="seri" type="text" value="<?php echo $dizi_fat["seri_no"]; ?>" required placeholder="Seri No" class="material-container__input" />
					<input  id="no" name="no" value="<?php echo $dizi_fat["fatura_no"]; ?>" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
    type = "number"
    maxlength = "6" required placeholder="Sipariş No" class="material-container__input" />
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
							type="hidden"  required value="2050-31-12"
							placeholder="Vade Tarihi"
							class="material-container__input datepicker" />



			</div>
			<div class="material-container__row">
				<input id="ack" name="ack" type="text"  required placeholder="Açıklama" value="<?php echo $dizi_fat["aciklama"]; ?>" style="width: 100%" class="material-container__input" />

			</div>


<div class="material-container__row">

	<select id="caty"  name="caty"  placeholder="Ürün/Hizmet #1" class="material-container__input" >
		

			                          </select>
			</div>		


	<?php $n = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi): ?>
<div class="material-container__row fatura_row item">
				<div class="fatura_row__genel-bilgi">
				<!--	<input id="item" type="text" name="item_1"  required placeholder="Ürün/Hizmet #1" class="material-container__input" />-->


						<select id="item"  name="item_<?php echo $n + 1; ?>"  required placeholder="Ürün/Hizmet #1" onclick="changeFunc(<?php echo $n + 1; ?>);" class="material-container__input ss" >
				<option selected value="<?php echo $dizi["hizmet_urun_id"]; ?>"><?php echo $data["urun_ad"][$n]; ?></option>
				
				
				
			</select>


					<input  id="des" type="text" name="des_<?php echo $n + 1; ?>" value="<?php echo $dizi["aciklama"]; ?>"   placeholder="Açıklama" class="material-container__input" />

				</div>
				
		<div id="ekvknnumber"    class="fatura_row__genel-veriler ek_1">
			
		<?php if($data["ek_vkn"][$n]!=""){ ?>	
<input id="ekvkn" type="number" value="<?php echo $data["ek_vkn"][$n]; ?>" name="ekvkn_<?php echo $n + 1; ?>" min="1111111111" max="9999999999" required  placeholder="Vergi Kimlik no" class="material-container__input" />			
			<?php } ?>			
				</div>						
				
				
				<div class="fatura_row__genel-veriler">
					<input id="pr" type="number" onkeyup="changeprc(<?php echo $n + 1; ?>);" name="prc_<?php echo $n + 1; ?>" value="<?php echo $dizi["birim_fiyat"]; ?>"  required min="0" placeholder="Fiyat" class="material-container__input urunInput" />
				<input id="prh" type="hidden" name="prch_<?php echo $n + 1; ?>" value="<?php echo $dizi["birim_fiyat"]; ?>"  required  placeholder="Fiyath" class="material-container__input urunInput" />	
					<input id="qt" type="number" name="qty_<?php echo $n + 1; ?>" value="<?php echo $dizi["adet"]; ?>"  required min="0" placeholder="Miktar" class="material-container__input urunInput" />
					<input id="dis" type="number" name="discount_<?php echo $n + 1; ?>" value="<?php echo $dizi["indirim"]; ?>"  required min="0" placeholder="İndirim" class="material-container__input urunInput" />
		

					<input id="tx" type="number" name="tax_<?php echo $n + 1; ?>" value="<?php echo $dizi["vergi"]; ?>" onkeyup	="myFunction2()" min="0" max="18"  placeholder="Vergi" class="material-container__input urunInput" />
					<script>
				function myFunction2 ()
				{
				 var str = $("#tx").val();
       			 if((str!=1) &&	(str!=8) &&	(str!=18) ) {  $("#tx").val(0); }

				}
				</script>


					<span> <span id="tot" class="totalSpan total_<?php echo $n + 1; ?>"><?php echo $dizi["tutar"] . " " . $this->session->userdata('para_birim'); ?></span></span>
					<input id="tot_hidden" type="hidden" name="total_<?php echo $n + 1; ?>"/>
					</div>

			</div>

			<?php $n = $n + 1;endforeach;endif;?>




	


			<div class="fatura_row__genel-veriler full-width fatura_row-standart">


	<!--						<select id="item"  onchange="myFunction()"  name="durum"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >
									<option value="">Fatura Durumu</option>
   			                        <option value="0">Kapalı</option>
   			                        <option value="1">Açık</option>
 <script>
				function myFunction ()
				{

if($('select[name=durum]').val()=="0"){
$('select[name=kasa]').css("visibility","visible");
 $('select[name=kasa]').prop('required',true);

}

if($('select[name=durum]').val()=="1"){
$('select[name=kasa]').css("visibility","hidden");
 $('select[name=kasa]').prop('required',false);

}



					/*
					if($('select[name=durum]').val()=="0"){

					if($('select[name=kasa]').val()==""){

                    $('select[name=kasa]').prop('required',true);
					}

					}
					*/
				}
			</script>
			                          </select>

			<select id="item" style="visibility: hidden;"  name="kasa" placeholder="Ürün/Hizmet #1" class="material-container__input" >
									<option value="">Kasa Banka Seçin (Fatura Durumu Kapalıysa)</option>
			<?php if ($data["kasa_getir"]): foreach ($data["kasa_getir"] as $dizi): ?>
				<option value="<?php echo $dizi["id"]; ?>"><?php echo $dizi["adi"]; ?></option>
				<?php endforeach;endif;?>
			</select>

										<select id="item"  name="irs_durum"  required placeholder="Ürün/Hizmet #1" class="material-container__input" >
									<option value="">İrsaliye Durumu</option>
   			                        <option value="0">İrsaliyeli (Ayrıca irsaliye eklenmez-stok çıkışı fatura ile yapılır.)</option>
   			                        <option value="1">İrsaliyesiz (Stok çıkışı yapılmaz-irsaliye eklenebilir.)</option>
			                          </select>-->

									<!--	<select id="item"  name="personel" placeholder="Personel" class="material-container__input" >
									<option value="">İlgili Personel</option>
			<?php  if ($data["personel_getir"]): foreach ($data["personel_getir"] as $dizi): ?>
				<option value="<?php echo $dizi["id"]; ?>"><?php echo $dizi["adi_soyadi_unvan"]; ?></option>
				<?php endforeach;endif;?>

			                          </select>-->
		<select id="odeme"  name="odeme" placeholder="Ödeme Şekli" class="material-container__input" >
				<option value="1">Peşin Ödeme (Nakit/Kredi Kartı)</option>
				<option value="6">Kredi Kartı 6 Taksit</option>
				<option value="9">Kredi Kartı 9 Taksit</option>				
			                          </select>

			</div>
			
					<div>
					<?php if($data["uye_turu"]!=2){ ?>
<input  type="checkbox" id="adm" name="adm" value="1">Admin Siparişi olarak kaydet
					<?php } ?>
</div>			
			
					<div>
				<input type='button' id='add' class="faturaItem faturaItem__add" value='Ürün/Hizmet Ekle' />
				<input type='button' id='del' class="faturaItem faturaItem__del" value='Ürün/Hizmet Sil' />
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
				<input id="toplam" type="hidden"  value="<?php echo $dizi_fat["toplam"]; ?>" name="toplam" >
				<input id="top_alan" type="hidden"  value="<?php echo count($data["fatura_item_getir_duzenle"]); ?>" name="top_alan" />
				<input id="fat_id" type="hidden" value="<?php echo $dizi_fat["id"]; ?>" name="fat_id" />

	<input id="irs_durum" type="hidden" value="<?php echo $dizi_fat["irsaliye_durum"]; ?>" name="irs_durum" />

			</div>


			<div class="faturaGonder">
				<div class="small-loading" id="FormLoading" style="display: none;">
					Yükleniyor, veri kaydediliyor...
				</div>
				<input type="submit" value="Siparişi Güncelle" class="flex-right">
			</div>
			<div id="report-error" class="report-div error" style="display: none;">
				<p>Bir şeyler yanlış gitti.</p>
			</div>
			<div id="report-success" class="report-div success" style="display: none;">
				<p>Veri başarıyla veritabanına kaydedildi.</p>
			</div>

		</div>






	</form>
	<?php endforeach;endif;?>
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
				
					var length = $('.item').length;
			for(var k=1; k<=length; k++){
				
				
				if($("select[name*='item_"+k+"']").val()==null){
					
					exit;
					
				}

		         if($("select[name*='item_"+k+"']").val()==""){
					
					exit;
					
				}
				
			         if($("input[name*='prc_"+k+"']").val()==""){
					
					exit;
					
				}			
			         if($("input[name*='qty_"+k+"']").val()==""){
					
					exit;
					
				}				
				

			}						
				
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
					console.log(data); 
				
					
				},
				error: function(data){ 
					$('#FormLoading').hide();
					console.log(data);

					console.log('oops we have error')
				}
			});
			
			
	
			
			
			setTimeout(() => { 
			alert("Sipariş Başarıyla Kaydedildi");
	         
			}, 1000);
			

			return false;
		});


		$('.datepicker').datepicker();

			$('body').on('keyup change', '.urunInput', function() {
			

hesap();


		});

	});



 function hesap(){
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

                    var prch	= Number($("input[name*='prch_"+n+"']").val());
				    prc = prch;
					
					
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


	$('#add').click(function () {
		

		
		
		var
		n		= $('.item').length + 1,
		temp	= $('.item:first').clone();

		$('input:first', temp).attr('placeholder', 'Ürün/Hizmet #' + n);
		

		         if($("select[name*='item_"+$('.item').length+"']").val()==null){
					
					exit;
					
				}

		         if($("select[name*='item_"+$('.item').length+"']").val()==""){
					
					exit;
					
				}
				
			         if($("input[name*='prc_"+$('.item').length+"']").val()==""){
					
					exit;
					
				}			
			         if($("input[name*='qty_"+$('.item').length+"']").val()==""){
					
					exit;
					
				}				
				
				


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
		
		$('#prh', temp).attr({
			'placeholder': 'Fiyath #' + n,
			'name': 'prch_' + n
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

		$('#tot_hidden', temp).attr('name', 'total_' + n).val("0.00");

		//$('#item', temp).attr('name', 'item_' + n).val('');


		$('#item', temp).attr({
			'onclick': 'changeFunc('+n+');',
			'name': 'item_' + n
		}).val('');

		$('#ekvknnumber', temp).attr({

			'class': 'fatura_row__genel-veriler ek_' + n
		}).val('');

		$('.item:last').after(temp);
					$("#top_alan").text(n);
					
					
				
			 kat2();			
					
					
					

	});


$('#del').click(function () {
	var n = $('.item').length;
	if(n!=1){$('.item:last').remove();
		$("#top_alan").text(n);
}

});





/*****Satış takip js*****/

$( document ).ready(function() {
   kat1();
	sessionStorage.setItem('status', "old");
	
	
	
	
			setTimeout(() => { 		
		
var cid = $("input[name*='ccid']").val();
sessionStorage.setItem('kat1', "");  
sessionStorage.setItem('kat2', "");  
sessionStorage.setItem('ur1', "");  
sessionStorage.setItem('ur2', "");  
sessionStorage.setItem('cari_urun', "");

kat1();
sessionStorage.setItem('status', "old");
		
		$('#tb2').html("").hide();
		cari_urun_getir(cid);
		cari_bilgi_getir(cid);
		
	

		}, 1000);
	
	
	
});


function temizle(){
	

	
	var n = $('.item').length;
	if(n!=1){
	for(var i=n; i>1; i--){
	$('.item:last').remove();	
	}				
	}
	
	$(".indirim").text("0.00");
	$(".vergi").text("0.00");
	$(".toplam").text("0.00");
	$(".ara_toplam").text("0.00");
    $("input[name*='des_1']").val("");	
    $("input[name*='prc_1']").val("");
    $("input[name*='qty_1']").val("");
    $("input[name*='tax_1']").val("");
    $("input[name*='discount_1']").val("");	
	$(".total_1").text("0.00");
	$('select[name="item_1"]').val("");
	$('select[name="item_1"]').filter(function() { 
    return ($(this).text() == 'Ürün/Hizmet Seçiniz'); //To select Blue
	}).prop('selected', true);
	
}

function temizle2(){
	

	
	var n = $('.item').length;
	if(n!=1){
	for(var i=n; i>1; i--){
	$('.item:last').remove();	
	}				
	}
	
	$(".indirim").text("0.00");
	$(".vergi").text("0.00");
	$(".toplam").text("0.00");
	$(".ara_toplam").text("0.00");
    $("input[name*='des_1']").val("");	
    $("input[name*='prc_1']").val("");
    $("input[name*='qty_1']").val("");
    $("input[name*='tax_1']").val("");
    $("input[name*='discount_1']").val("");	
	$(".total_1").text("0.00");

	
}


function cari_temizle(){
	
			$("#ad").val("");
		$("#yet").val("");
		$("#vd").val("");
		$("#vn").val("");
		$("#tc").val("");
		$("#ep").val("");
		$("#cp").val("");
		$("#tl").val("");
		$("#fx").val("");
		$("#il").val("");
		$("#ilc").val("");
		$("#adr").val("");		
		$("#fkd").val("");
		$("#fad").val("");
	
	
}

				 
$('#new').click(function () {

	temizle();
    kat1();


if ($('#new').is(":checked"))
{
        $('#mus').hide();
		$("#mus").prop('required',false);	
    	sessionStorage.setItem('status', "new"); 
		$("#new_status").val("new");		
}
else{
	        $('#mus').show();
			$("#mus").prop('required',true);
	        sessionStorage.setItem('status', "old");
		    $("#new_status").val("old");	
}
     // $('#newform').toggle("slide");




});


function kat1(){

	
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/ajax",
        type:"POST",
        cache:false,
        data:"",
        success:function(data){
         $("#caty").html(data);
        }
      });
	
}


function urun1(){
	
     var data = "id="+sessionStorage.getItem('kat1');
	 
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/ur_get",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){
		//	alert(data);
         $('select[name="item_'+$('.item').length+'"]').html(data);
        }
      });
	
}

function kat2(){

   //  var data = "id="+sessionStorage.getItem('ur1');
	     var data ={ id: sessionStorage.getItem('ur1'), status : sessionStorage.getItem('status')}  
		 
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/ajax2",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){
		setTimeout(() => { $("#caty").html(data); }, 500);		
        }
      });
	  
	  if(sessionStorage.getItem('ur1')!=""){
	//$('select[name="item_'+$('.item').length+'"]').html("");	  
		  
	  }
	
}



function urun2(){

     var data ={ ur1: sessionStorage.getItem('ur1'), kat2 : sessionStorage.getItem('kat2')}  
	 //"?ur1="+sessionStorage.getItem('ur1')+"&kat2"+sessionStorage.getItem('kat2');

	 
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/ur_get2",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){
		
         $('select[name="item_'+$('.item').length+'"]').html(data);
        }
      });
	
}





 function fiyat(x,s) {
ode = $('select[name="odeme"]').val();

var data ={ fy: x, od:ode}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/fyt",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
	
	data = Number(data);
    $("input[name*='prc_"+s+"']").val(data.toFixed(2));
    $("input[name*='prch_"+s+"']").val(data);	
    $("input[name*='discount_"+s+"']").val("0");
	
        }
      });



}


 function fiyattum(x,i) {
ode = $('select[name="odeme"]').val();

var data ={ fy: x, od:ode}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/fyt",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
	
	data = Number(data);
    $("input[name*='prc_"+i+"']").val(data.toFixed(2));		
    $("input[name*='prch_"+i+"']").val(data);			
        }
      });



}


/*
$('#pr').on('keydown', function() {
	    $("input[name*='prc_"+s+"']").val();
alert(111);	
});
*/

function changeprc(x) {
	
	    var val = $("input[name*='prc_"+x+"']").val();	
	
		$("input[name*='prch_"+x+"']").val(val);	
}


function vergi(x,s) {

var data ={ fy: x}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/vrg",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){			
    $("input[name*='tax_"+s+"']").val(data);			
        }
      });



}




$('#caty').on('change', function() {
	
 if(sessionStorage.getItem('status')=="old")	
 {
		if($('#mus').val()==""){
			alert("Lütfen Cari seçiniz");	
exit;			
		}
 }
	
	 var value = $(this).val();
     var n		= $('.item').length;
	 if(n==1){ 
	 //session ata, urun1 getir ,
	 
	if(sessionStorage.getItem('status')=="old"){
	if(sessionStorage.getItem('cari_urun')==""){ 
	//alert("Lütfen Ürünü olan bir cari seçin veya yeni bir müşteri kaydederek ilerleyin."); 
			 sessionStorage.setItem('kat1', value);
         urun1();
	}	
		
	 	 sessionStorage.setItem('kat2', value);		
		urun2(); 		
	} 
	 else{
	 
		 sessionStorage.setItem('kat1', value);
         urun1();
	 }
		 
	 }
	 else{  
	 //session ata urun2 getir
	 	 sessionStorage.setItem('kat2', value);		
		urun2(); 
	 }

});


$('.ss').on('change', function() {

 
	 var value = $(this).val();
     var n		= $('.item').length;

	 if(n==1){ 
	 //session ata, urun1 getir ,

	 //session ata, urun1 getir ,
		 if(sessionStorage.getItem('ur1')==""){
			 
		 sessionStorage.setItem('ur1', value);	
			 
		 } 


		 var s = 1;		 
         fiyat(value,s);
         vergi(value,s);		 
		 
	 }
	 else{  
	 //session ata urun2 getir
     var item1 = $('select[name="item_1"]').val();
	 if(item1!=sessionStorage.getItem('ur1')){
		temizle2(); 
    sessionStorage.setItem('ur1', item1);	
	kat1();
	 } 
	 	 sessionStorage.setItem('ur2', value);
		 var s = 1;				
         fiyat(value,s);		
         vergi(value,s);			 
	 }

});




  function changeFunc(n) {
	  

	 
	 item = $('select[name="item_'+n+'"]').val();
	 	 
		  fiyat(item,n);
          vergi(item,n);	
		 is_vkn(item,n);
		 
	    $("input[name*='qty_"+n+"']").val("");	 
	 
   }


function is_vkn(item,n)
{
	
	var data ={ ur: item}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/is_vkn",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		


       if(data!=0){ 	
     // $('.ek_'+n).html('ss'+n);
    $('.ek_'+n).html('<input id="ekvkn" type="number" name="ekvkn_'+n+'" min="1111111111" max="9999999999" required  placeholder="Vergi Kimlik no" class="material-container__input urunInput" />');	  			
	
	$("input[name*='qty_"+n+"']").val('1');	
	$("input[name*='qty_"+n+"']").attr('readonly', true);
	}
       if(data==0){ 	
     // $('.ek_'+n).html('ss'+n);
    $('.ek_'+n).html('');	
	$("input[name*='qty_"+n+"']").attr('readonly', false);			
		}

		
        }
      });

	
}



$('#mus').on('change', function() {
	
sessionStorage.setItem('kat1', "");  
sessionStorage.setItem('kat2', "");  
sessionStorage.setItem('ur1', "");  
sessionStorage.setItem('ur2', "");  
sessionStorage.setItem('cari_urun', "");
temizle(); 
kat1();
sessionStorage.setItem('status', "old");




item = $('select[name="mus"]').val();
$('#tb2').html("").hide();

cari_urun_getir(item);
cari_bilgi_getir(item);

return false;
     var data = "id="+sessionStorage.getItem('ur1');


});


function cari_urun_getir(x) {

        if(x==""){
				 sessionStorage.setItem('cari_urun', "");			
			 $('#top_box').html("Yeni Müşteri");
			 $('#tb2').html("").hide();				 
		     $('#new').css("visibility","visible");	
		}
var data ={ ca: x}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/cari_urun_getir",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
	
       if(data!=""){ 	

         var res = data.split("-"); 
         var dt = res[0]+" "+ res[1]+" "+ res[3]+" "+ res[4]+" "+ res[5];  
		 sessionStorage.setItem('cari_urun', data);	
		 sessionStorage.setItem('ur1', res[2]);			 
         $('#top_box').html("<b>Ana Ürün: </b>"+dt+"<br>");		
		 $('#new').css("visibility","hidden");	
		 kat2();
		// cari_tum_urun_getir(x);
		}	
        if(data==""){
		 sessionStorage.setItem('cari_urun', "");
		 sessionStorage.setItem('ur1', "");					 
			 $('#top_box').html("Yeni Müşteri");
		     $('#new').css("visibility","visible");		
			
		}


		
        }
      });






}


function cari_bilgi_getir(x) {

        if(x==""){
	cari_temizle();
	
		}
var data ={ ca: x}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/cari_bilgi_getir",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
	
       if(data!=""){ 	
//	alert(data);	

         var res = data.split("-"); 
		$("#ad").val(res[0]);
		$("#yet").val(res[1]);
		$("#vd").val(res[2]);
		$("#vn").val(res[3]);
		$("#tc").val(res[4]);
		$("#ep").val(res[5]);
		$("#cp").val(res[6]);
		$("#tl").val(res[7]);
		$("#fx").val(res[8]);
		$("#il").val(res[9]);
		$("#ilc").val(res[10]);
		$("#adr").val(res[11]);		
		$("#fkd").val(res[12]);
		$("#fad").val(res[13]);
		$("#mn").val(res[14]);		

		
    
		}	
        if(data==""){
			cari_temizle();
		}


		
        }
      });






}


function cari_tum_urun_getir(x) {

var data ={ ca: x}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/cari_tum_urun_getir",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
		$('#tb2').show().html(data);				
        }
      });


}




$('#odeme').on('change', function() {
	
var ode = $('select[name="odeme"]').val();

	var n = $('.item').length;
	if(n==1){
	var item1_prc = $("input[name*='prc_1']").val();	
	if(item1_prc==""){}
	else{
		// ürün id al , db git ödeme şekline göre fiyat getir
         var item1 = $('select[name="item_1"]').val();	
		 var s = 1;		 
		 fiyat(item1,s);
		 hesap();
	}
	}
    else{
		// ürünleri döngüde  , db git ödeme şekline göre fiyat getir	
		for (var i = 1; i<=n; i++){
         var item_i = $('select[name="item_'+i+'"]').val();	
		  fiyattum(item_i,i);	
		 
		}
		
		
	}

setTimeout(() => { hesap(); }, 1000);




});







</script>
