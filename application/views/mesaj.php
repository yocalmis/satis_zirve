<?php error_reporting(0);if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>

<?php $this->load->view('header.php');?>
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/themes/default.css">
<div class="material-container">
	<div class="chats">
		<div class="chatsTopBar">
			<h2 class="chatsTopBar__title">Mesajlar</h2>
			<button class="chats-send-new waves-effect waves-ripple">
				<span class="icon" data-svg="add_circle_outline-24px"></span>
				Yeni Mesaj
			</button>

		</div>
		<form class="sendMessageForm hide" id="myform" action="<?php echo base_url(); ?>yonetim/mesaj_gonder" method="POST">
			<div class="form-title-left">
				<a>Sohbetler</a>
			</div>
			<select class="m_s_msg" name="uyeler[]" multiple placeholder="Mesaj Gönderin">
				<?php if ($uye_getir): foreach ($uye_getir as $dizi): ?>
						<option value="<?php echo $dizi['id'] ?>" data-name="<?php echo $dizi['username'] ?>">
							<?php echo $dizi['username'] ?>
						</option>
					<?php endforeach;endif;?>
			</select>

			<div class="sendMessageForm__inner">
				<textarea id="ice" name="ice" class="texteditor waves-effect waves-light" data-placeholder="Bir şeyler yazın"></textarea>
			</div>
			<input type="hidden" name="ilk" value="1">

			<button type="submit" name="action" class="chats-send waves-effect waves-ripple waves-light">Gönder <span class="icon" data-svg="send-24px"></span></button>
			<div class="sendMessageForm__statuss">
				<span class="chat-send--sending hide">Gönderiliyor..</span>
				<span class="chat-send--success hide">Başarılı</span>
				<span class="chat-send--error hide">Bir şeyler yanlış gitti</span>
			</div>
			<input type="hidden" name="uyedurum" value="0">
		</form>

	</div>

</div>
<div class="material-container mt1 dFlex fdc chat-rows">
	<?php 

		$say = count($ar); $don = $say -1;
	for($i=0; $i<=$don; $i++)
	{ 
    echo "<a style='text-decoration: none;' href='".base_url()."yonetim/mesajdetay/".$ar[$i]."'>".$name[$i]." - ".$okunmamis[$i]." okunmamış mesaj</a><br><br>";

	}
	


	
	
	
	/*
	
	 $n    = 0;
$sohbetler[] = "";
$benzersiz[] = "";
$i           = 0;
if ($mesaj_getir): foreach ($mesaj_getir as $dizi): ?>
		<?php

    if ($dizi['gonderici'] == $uye) {
        if (in_array($dizi['alici'], $benzersiz)) {
            $i = $i + 1;
            continue;
        }
        $benzersiz[$i] = $dizi['alici'];

        $sohbetler[$n]["name"]      = $name[$i];
        $sohbetler[$n]["tarih"]     = $dizi['tarih'];
        $sohbetler[$n]["okunmamis"] = $okunmamis[$i];
        $sohbetler[$n]["url"]       = "yonetim/mesajdetay/" . $dizi['alici'];
        $n                          = $n + 1;

        $i = $i + 1;
        continue;
    }
    if ($dizi['alici'] == $uye) {
        if (in_array($dizi['gonderici'], $benzersiz)) {
            $i = $i + 1;
            continue;
        }
        $benzersiz[$i] = $dizi['gonderici'];

        $sohbetler[$n]["name"]      = $name[$i];
        $sohbetler[$n]["tarih"]     = $dizi['tarih'];
        $sohbetler[$n]["okunmamis"] = $okunmamis[$i];
        $sohbetler[$n]["url"]       = "yonetim/mesajdetay/" . $dizi['gonderici'];
        $n                          = $n + 1;
        $i                          = $i + 1;
        continue;
    }
    ?>

		<?php $i = $i + 1;endforeach;endif;
if (empty($mesaj_getir)) {
		$sohbetler = false;	
	}*/
		?>

	<script>
		self.chats = <?php echo json_encode($sohbetler); ?>;
	</script>
</div>

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