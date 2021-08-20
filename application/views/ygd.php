<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">



<body>
	<div class="material-container__row">
				<input id="mus_getir" name="mus_getir" type="number" required placeholder="Müşteri No" style="width: 10%" class="material-container__input" />			
			<input type="submit" value="Müşteri Getir" id="getir" style="width: 10%" class="material-container__input"  onclick="mus_getir();">
		</div><br>Veya Müşteri Seç
	<select id="mus" name="mus" required="required" placeholder="Müşteri" class="material-container__input">
						<option value="">Cari Seçiniz</option>
			<?php if ($data["cari_getir"]): foreach ($data["cari_getir"] as $dizi): ?>
				<option value="<?php echo $dizi["id"]; ?>"><?php echo $dizi["adi_soyadi_unvan"]; ?></option>
				<?php endforeach;endif;?>
			</select>


		<div class="material-container" id="tb2" style="display: none;">
			<div id="top_box2" class="material-container__row">
<label id="top_box2" for="vehicle1">  </label><br>
		</div>	
		</div>



		
			
			
			
			


		<div class="material-container">


		

			<div class="material-container__row musteri_bilgi">





			</div>
	
				

			
			
			
		
			
			
	
			


	

		</div>




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
				
	
        if($("#vn").val() === "" || $("#tc").val() === "") {
			alert("Vergi No veya Tc no alanlarından en az birini doldurunuz"); return false;
		}	
        if(vn==""){}


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
					
					console.log(data)
				},
				error: function(data){
					$('#FormLoading').hide();
					console.log(data)
                      
					console.log('oops we have error')
				}
			});
			setTimeout(() => { 
			alert("Sipariş Başarıyla Kaydedildi");
			
			temizle();
			kat1();			
			}, 1000);
			
			return false;
		});


		$('.datepicker').datepicker();

			$('body').on('keyup change', '.urunInput', function() {
			

hesap();


		});

	});



 


/*****Satış takip js*****/

$( document ).ready(function() {
    kat1();
	sessionStorage.setItem('status', "old");
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
    $("input[name*='prch_1']").val("");		
    $("input[name*='qty_1']").val("");
    $("input[name*='tax_1']").val("");
    $("input[name*='discount_1']").val("");	
	$(".total_1").text("0.00");
	$('select[name="item_1"]').val("");
	$('select[name="item_1"]').filter(function() { 
    return ($(this).text() == 'Ürün/Hizmet Seçiniz'); //To select Blue
	}).prop('selected', true);
	sessionStorage.setItem('kampanya',"");
	$("#kam_ur").hide();
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
    $("input[name*='prch_1']").val("");	
    $("input[name*='qty_1']").val("");
    $("input[name*='tax_1']").val("");
    $("input[name*='discount_1']").val("");	
	$(".total_1").text("0.00");
	sessionStorage.setItem('kampanya',"");
	$("#kam_ur").hide();
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
	    sessionStorage.setItem('kampanya',"");		
	    $("#kam_ur").hide();
}

				 
$('#new').click(function () {

	temizle();
    kat1();
    cari_temizle();

if ($('#new').is(":checked"))
{
        $('#mus').hide();
        $('#mus_getir').hide();		
        $('#getir').hide();
		$("#mus").prop('required',false);	
    	sessionStorage.setItem('status', "new"); 
		$("#new_status").val("new");		
}
else{
	        $('#mus').show();
            $('#mus_getir').show();	
            $('#getir').show();				
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
	$('select[name="item_'+$('.item').length+'"]').html("");	  
		  
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
	
	var curun = sessionStorage.getItem('cari_urun');
	if(curun == ""){
		var ct = $('select[name="caty"]').val();
		
		
		var data ={ ct: ct}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/kampanyami",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
		

		sessionStorage.setItem('kampanya', data);

		
        }
      });
		
		
	}
	
	
	
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
			 setTimeout(() => { urun1(); }, 500);		
         
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
	

		  console.log(sessionStorage.getItem('ur1')); 
	 var value = $(this).val();
     var n		= $('.item').length;

	 if(n==1){ 
	  	 
	 //session ata, urun1 getir ,
		 if(sessionStorage.getItem('ur1')==""){
			 
		 sessionStorage.setItem('ur1', value);	
			 
		 } 
	 	 
	
		 var s = 1;
         fiyat(value,s);
        if(sessionStorage.getItem('kampanya')==1){
			//Kampanya ürün getir ürün fiyat vergi

		var kamp = '<input id="kamp" type="hidden" name="kamp_1" required  placeholder="kampanya" value=1 class="material-container__input urunInput" />';	
		$('#kam_ur_ic2').html(kamp);
		
		kampanya_urun(value);
		
		}
		
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
		
         
        if(sessionStorage.getItem('kampanya')==1){
		//Kampanya ürün getir ürün fiyat vergi
			//alert(value);
		 kampanya_urun(value);
			
			
		}
		 var s = 1;		
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
		 cari_tum_urun_getir(x);
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
	    $("#mus option[value="+x+"]").prop('selected', true);	
		
		


	
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
        url :"<?php echo base_url(); ?>yonetim/cari_tum_urun_getir2",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
		$('#tb2').show().html(data);				
        }
      });


}


function kampanya_urun(x) {
ode = $('select[name="odeme"]').val();
var adet = $('.item').length;

var icerik = "";

var data ={ urun: x, ode:ode}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/kampanya_urun_getir",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){		
         var ur = [];
         var res = data.split("*"); 
		 var don = res.length -1;

		 for(var m=0; m<=don; m++){
			 if(res[m]==""){continue;}
	     ur[m] = res[m].split("..");	

             var carpan = "1."+ur[m][3];
			var tot = ur[m][2] * carpan;	

          icerik +="Ürün: "+ur[m][1]+" Fiyat:"+ur[m][2]+" TL Vergi:"+ur[m][3]+" TL Toplam:"+tot.toFixed(2)+" TL <br><br>";
		  if(ur[m][4]==1){sessionStorage.setItem('ur1', ur[m][0]);}
		 }
		
		 $('#kam_ur').show();
		 $('#kam_ur_ic').html(icerik);
		 
	
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


function mus_getir (){
	var mn = $('#mus_getir').val();
	
var data ={ mn: mn}  
	    $.ajax({
        url :"<?php echo base_url(); ?>yonetim/cari_id_getir",
        type:"POST",
        cache:false,
        data:data,
        success:function(data){	

if(data==""){		alert("Bu müşteri bulunamadı");	return false;}	

cari_tum_urun_getir(data);

	
        }
      });	
	
	
	
	
	
}

function elsil(){
	
	
/*	
	var n = $('.item').length;

	for(var i=1; i<=n; i++){	

  if ($('input[name="sil_'+i+'"]').is(":checked")){
	  
		  $('div.item_'+i+'').remove();  
	  
	  
	  if(i==1){
		  
     if(sessionStorage.getItem('status')!="old"){
		 
		temizle(); 
	 }
		else{
	  $('div.item_'+i+'').remove();
		  	    
		}		  
	
	  $('div.item_'+i+'').remove();		  
	  }
	  else{	
	  $('div.item_'+i+'').remove();

	  }
	  
  }  
	


	
	}				

 */



	
}


</script>
