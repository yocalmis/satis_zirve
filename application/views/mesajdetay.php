<?php error_reporting(0);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/themes/default.css">
<?php $this->load->view('header.php');?>

<div class="material-container m-0 chat-inner">

	<form class="message__form"  id="myform" action="<?php echo base_url(); ?>yonetim/mesaj_gonder" method="POST" >
		<div class="form-title-left">
			<a><?php echo $uye_adi_getir; ?></a>
		</div>
		<select style="display:none;" class="m_s_msg" name="uyeler[]" multiple>
			<option selected value="<?php echo $uye; ?>">
				<?php echo $uye_adi_getir; ?>
			</option>
		</select>

		<div class="chat">
			<div class="chat-box"></div>
			<div class="chat-type">
				<textarea id="ice" name="ice" class="texteditor" data-placeholder="Bir şeyler yazın"></textarea>
				<button title="Gönder" type="submit" name="action" class="chat-type__send waves-effect waves-light"><span class="icon" data-svg="send-24px"></span></button>
			</div>
		</div>
		<input type="hidden" name="uyedurum" value="1">

	</form>
</div>




<script>
	let chat = self.chat = [];
	<?php $i = 0;if ($uye_mesaj_getir): foreach ($uye_mesaj_getir as $dizi): ?>
		chat[<?php echo $i; ?>] = {
			from: "<?php echo ($dizi['gonderici'] == $this->session->userdata('id')) ? 'me' : $uye_adi_getir ?>",
			message: '<?php echo $dizi['mesaj']; ?>',
			date: '<?php echo $dizi['tarih']; ?>'
		}
		<?php $i = $i + 1;endforeach;endif;?>
</script>
<script src="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.js"></script>
<script>
	var elements = document.querySelectorAll('textarea.texteditor');
	if (typeof MediumEditor !== 'undefined') {
		var editor = new MediumEditor(elements, {
			toolbar: {
				buttons: ['bold', 'italic', 'underline'],
			},
			placeholder: {
				hideOnClick: false
			}
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


