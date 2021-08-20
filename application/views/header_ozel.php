<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticari Muhasebe</title>
	<?php $this->load->view('fonts');?>
	<?php $this->load->view('favicon');?>
	<?php $this->load->view('css');?>
	<?php $this->load->view('preloader');?>

</head>
<body>

<?php $this->load->view('body_inner');?>

<div class="header-edit">

<input type="button" value="Ana Menü" onclick="window.location.href = '<?php echo base_url(); ?>';" />
</div>