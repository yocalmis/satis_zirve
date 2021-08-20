<?php error_reporting(0);if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>

<?php $this->load->view('header.php');?>
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.css">
<link rel="stylesheet" href="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/themes/default.css">

	<div class="heading">
		<h2 style="font-style: 'Hervetica';">Aktarımlar</h2>
	</div>
<div class="material-container">

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}

/* Style the close button */
.topright {
  float: right;
  cursor: pointer;
  font-size: 28px;
}

.topright:hover {color: red;}
</style>
</head>
<body>


<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Cari Aktar</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Ürün Aktar</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Kasa Aktar</button>
</div>

<div id="London" class="tabcontent">
<p>Lütfen excel dosyası yükleyiniz.Aşağıdaki alanların exceldeki sütun karşılıklarını giriniz.<br>
Örneğin "Ad" alanı excel dosyanızın ilk sütununda ise "1" veya "Vergi no" alanı excel dosyanızın <br>üçüncü sütununda ise "3" yazabilirsiniz.Excel içerisinde ilgili başlık yoksa boş bırakın.<br>
Örnek cari aktarım dosyasını <a href="<?php echo base_url(); ?>assets/excel/ticari_aktarim_ornek_cari.xlsx">indiriniz.</a></p>

<form action="<?php echo base_url(); ?>yonetim/excel_cari" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept=".xls.xlsx" required placeholder="Dosya Yükleyin excel" id="fileToUpload"><br><br>
    <input type="number" min="0" max="99" style="width: 24%;"  name="baslangic" placeholder="Başlangıç Satırı" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;" required  name="adi" placeholder="Cari Adı/Ünvanı" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"  name="vn" placeholder="Vergi No" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"  name="cep" placeholder="Cep Tel" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"   min="1" max="99"  name="adres" placeholder="Adres" id="fileToUpload"> <br> <br>
    <input type="number" min="1" max="99" style="width: 24%;"   name="il" placeholder="İl" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"    name="eposta" placeholder="E Posta Adresi" id="fileToUpload"> <br> <br>
    <input type="number" min="1" max="99" style="width: 24%;"   name="bak_durum" placeholder="Bakiye Borçlu/Alacaklı" id="fileToUpload">**Bakiye Borçlu/Alacaklı sütununun Excel'deki içeriği 1 ise cari borçlu , 0 ise cari alacaklı olarak kabul edilecektir.  <br> <br>
    <input type="number" min="1" max="99" style="width: 24%;"   name="bak_miktar" placeholder="Bakiye" id="fileToUpload"> <br> <br>
    <input type="submit" min="1" max="99" style="width: 24%;"   value="Excel Gönder" name="submit">
</form>
</div>

<div id="Paris" class="tabcontent">


<p>Lütfen excel dosyası yükleyiniz.Aşağıdaki alanların exceldeki sütun karşılıklarını giriniz.<br>
Örneğin "Ad" alanı excel dosyanızın ilk sütununda ise "1" veya "Vergi no" alanı excel dosyanızın <br>üçüncü sütununda ise "3" yazabilirsiniz.Excel içerisinde ilgili başlık yoksa boş bırakın.
<br>
Örnek stok aktarım dosyasını <a href="<?php echo base_url(); ?>assets/excel/ticari_aktarim_ornek_urun.xls">indiriniz.</a></p>

<form action="<?php echo base_url(); ?>yonetim/excel_urun" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept=".xls.xlsx" required placeholder="Dosya Yükleyin excel" id="fileToUpload"><br><br>
    <input type="number" min="0" max="99" style="width: 24%;"  name="baslangic" placeholder="Başlangıç Satırı" id="fileToUpload">  <br><br>

    <input type="number" min="1" max="99" style="width: 24%;" required name="adi" placeholder="Stok Adı" id="fileToUpload">  <br><br>
    <input type="number" min="0" max="99" style="width: 24%;"  name="kod" placeholder="Stok Kodu" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"  name="adt" placeholder="Adet" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"   min="1" max="99"  name="fiyat" placeholder="Fiyat" id="fileToUpload"> <br> <br>

    <input type="submit" min="1" max="99" style="width: 24%;"   value="Excel Gönder" name="submit">

</form>






</div>

<div id="Tokyo" class="tabcontent">


<p>Lütfen excel dosyası yükleyiniz.Aşağıdaki alanların exceldeki sütun karşılıklarını giriniz.<br>
Örneğin "Ad" alanı excel dosyanızın ilk sütununda ise "1" veya "Vergi no" alanı excel dosyanızın <br>üçüncü sütununda ise "3" yazabilirsiniz.Excel içerisinde ilgili başlık yoksa boş bırakın.
<br>
Örnek kasa aktarım dosyasını <a href="<?php echo base_url(); ?>assets/excel/ticari_aktarim_ornek_kasa.xlsx">indiriniz.</a></p>

<form action="<?php echo base_url(); ?>yonetim/excel_kasa" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept=".xls.xlsx" required placeholder="Dosya Yükleyin excel" id="fileToUpload"><br><br>
    <input type="number" min="0" max="99" style="width: 24%;"  name="baslangic" placeholder="Başlangıç Satırı" id="fileToUpload">  <br><br>

    <input type="number" min="1" max="99" style="width: 24%;" required name="adi" placeholder="Stok Adı" id="fileToUpload">  <br><br>
    <input type="number" min="0" max="99" style="width: 24%;"  name="kod" placeholder="Stok Kodu" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"  name="tur" placeholder="Tür" id="fileToUpload">  <br><br>
    <input type="number" min="1" max="99" style="width: 24%;"   min="1" max="99"  name="bky" placeholder="Bakiye" id="fileToUpload"> <br> <br>

    <input type="submit" min="1" max="99" style="width: 24%;"   value="Excel Gönder" name="submit">

</form>


</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
   
</body>
</html> 


</div>


<script src="<?php echo site_url('assets') ?>/grocery_crud/texteditor/medium-editor/medium-editor.min.js"></script>

<?php $this->load->view('footer_ozel.php');?>
<script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/') ?>jquery.form.min.js"></script>