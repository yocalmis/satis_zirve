
<?php error_reporting(0);if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<?php $this->load->view('header_ozel.php');?>
<link rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple') ?>/jquery-ui-1.10.1.custom.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/themes/default.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>edit.css">
<div class="material-container">
	<div class="chats">




<div class="tartismadtykonubslt">
	<div class="trtbaslik"><p class="z-depth-5"><?php echo $konu; ?></p></div>
	<div class="myButton">
	<b>Tarih: </b><?php echo $tarih; ?>
	<b>Başlatan:</b><?php echo $kim; ?>
</div>
</div>

		<div class="chatsTopBar">
			<button class="chats-send-new waves-effect waves-ripple">
				<span class="icon" data-svg="add_circle_outline-24px"></span>
				Yeni Mesaj

	<?php  $n    = 0;
$sohbetler[] = "";if ($tartisma_msj_getir): foreach ($tartisma_msj_getir as $dizi): ?>
		<?php

    $sohbetler[$n]["name"]      = $gonderici[$n];
    $sohbetler[$n]["tarih"]     = $dizi['tarih'];
    $sohbetler[$n]["okunmamis"] = 0;
    $sohbetler[$n]["url"]       = "#";
    $sohbetler[$n]["message"]   = $dizi['mesaj'];
    $sohbetler[$n]["id"]        = $dizi['id'];

    ?>

	<?php $n = $n + 1;endforeach;endif;   ?>

			</button>

		</div>
		<form class="sendMessageForm hide" id="myform" action="<?php echo base_url(); ?>yonetim/tartisma_gonder" method="POST">
			<div class="form-title-left">
				<a><?php echo $konu; ?>
			<?php if($sohbetler[0]["name"]==""){
echo'<input type="hidden" name="ilk" value="1">';

			} else{

echo'<input type="hidden" name="ilk" value="0">';

			} ?>		


				</a>
			</div>
			<div class="sendMessageForm__inner">
				<textarea minlength="5" id="ice" name="ice" class="texteditor" data-placeholder="Bir şeyler yazın"></textarea>
			</div>

			<button type="submit" name="action" class="chats-send waves-effect waves-ripple waves-light">Gönder <span class="icon" data-svg="send-24px"></span></button>
			<div class="sendMessageForm__statuss">
				<span class="chat-send--sending hide">Gönderiliyor..</span>
				<span class="chat-send--success hide">Başarılı</span>
				<span class="chat-send--error hide">Bir şeyler yanlış gitti</span>
			</div>
			<input type="hidden" name="tartisma" value="<?php echo $tartisma; ?>">
		</form>

	</div>

<!--
<div class="material-container mt1 dFlex fdc chat-rows">

	<script>
		self.chats = <?php if($sohbetler[0]["name"]==""){echo 0;} else{echo json_encode($sohbetler);} ?>;
		self.IsChatsMessage = true;
	</script>
</div>
-->




	</div>
<br><br>
<?php $n = 0;if ($tartisma_msj_getir): foreach ($tartisma_msj_getir as $dizi): ?>
<hr>


<span class="bbp-title-icon forum-icon color-primary h4"><i class="large material-icons">chat</i></span>
	<font class="mesaj">Mesaj:</font><br>
	<div class="mesajdevam"><font class="mesaj2"> <?php echo $dizi['mesaj']; ?></font><br></div>
	<font class="tarih"> Tarih:</font><font class="tarihyaz"><?php echo $dizi['tarih']; ?></font>
	<font class="gonderici">Gönderici:</font><font class="gonderici2"> <?php echo $gonderici[$n]; ?><br></font>
	

	<br>
	<?php $n = $n + 1;endforeach;endif;?>



<script src="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.js"></script>
<script>
	var elements = document.querySelectorAll('textarea.texteditor');
	if (typeof MediumEditor !== 'undefined') {
		var editor = new MediumEditor(elements, {
			toolbar: {
				buttons: ['bold', 'italic', 'underline'],
			},
		});
		elements.forEach(function(elem) {
			elem.style.display = 'none';
			elem.style.visibility = 'hidden';
			elem.setAttribute('tab-index', -1);

		});
	}

</script>
<?php $this->load->view('footer_ozel.php');?>
<script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/') ?>jquery.form.min.js"></script>
<center>