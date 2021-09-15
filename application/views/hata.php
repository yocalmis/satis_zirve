<?php $this->load->view('header_ozel.php');?>


  <div class="container-contact100">
    <div class="wrap-contact100">
      <form class="contact100-form validate-form" name="form1" action="<?php echo base_url(); ?>yonetim/hataal" method="Post">
        <span class="contact100-form-title">
          Hata Bildir
        </span>

        <div class="wrap-input100 validate-input" data-validate="Lütfen Başlık Girin">
          <input required="required" class="input100" type="text" name="name" placeholder="Başlık">
          <span class="focus-input100"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate = "Lütfen Acıklama Girin">
          <textarea required="required" class="input100" name="message" placeholder="Acıklama"></textarea>
          <span class="focus-input100"></span>
        </div>

        <div class="container-contact100-form-btn">
          <button class="contact100-form-btn">
            Gönder
          </button>
        </div>
      </form>
    </div>
  </div>



<?php $this->load->view('footer_ozel.php');?>