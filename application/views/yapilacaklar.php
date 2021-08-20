<?php $this->load->view('header_ozel.php');?>


<!DOCTYPE html>
<html>
<head>
	<title>L</title>
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Yapılacaklar Listesi</h2>
	</div>
	<div class="heading">
	<form method="post" action="<?php echo base_url(); ?>yonetim/list_al" class="input_form">
		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Ekle</button>
	</form>

	</div>


<?php $n = 1;if ($data["list"]): foreach ($data["list"] as $dizi):

        echo "	<div class='heading'>".$n . " : " . $dizi["tarih"] . " - " . $dizi["task"] . " - <a href='" . base_url() . "yonetim/tasksil/" . $dizi["id"] . "/" . $this->session->userdata('id') . "'>Sil</a></div>";

        $n = $n + 1;endforeach;endif;?>
</body>
</html>

		

<?php $this->load->view('footer_ozel.php');?>