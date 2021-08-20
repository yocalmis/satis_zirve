<?php $this->load->view('header_ozel.php');?>

<h2>Hata Bildir</h2>


  <form action="<?php echo base_url(); ?>yonetim/hataal" method="Post">
  <input type="text" required="required" name="hd" value="Başlık" size="30"><br><br>
   <textarea rows="10" required="required" cols="33" name="ac" >Açıklama</textarea><br><br>
   <input type="submit" value="Gönder">
  </form>





<?php $this->load->view('footer_ozel.php');?>