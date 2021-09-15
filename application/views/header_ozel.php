
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/edit.css">
</head>
<body>

<?php $this->load->view('body_inner');?>

<div class="header-edit anamenu">
<div class="anamenu"> <input type="button" value="Ana Menü" onclick="window.location.href = '<?php echo base_url(); ?>';" /> </div></div>