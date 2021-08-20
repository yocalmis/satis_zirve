<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Yonetim extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    private $nerede;
    private $tablo;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');

        if (!empty($this->session->userdata('odeme'))) {

            if ($this->session->userdata('odeme') == 1) {
                $this->load->library('messages');
                $this->messages->config2('Odeme/odeme');
                return false;
            }

        }

    }

    public function index()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_login');} else { $this->load->view('admin_register');}

        } else {

            $crud = new grocery_CRUD();
            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Yapılacaklar Listesi Ayarları";
            $data['kilavuz']   = "  <b>Yapılacaklar Listesi Ayarları</b>";
            $this->load->model('admin_model');
            $data["list"] = $this->admin_model->list_getir($this->session->userdata('id'));

            $this->load->model('admin_model');

            $bugun_bas = date("Y-m-d");
            $bugun_bit = date("Y-m-d");

            $data['bugun_tahsilat'] = $this->admin_model->toplam_tahsilat($bugun_bas, $bugun_bit);
            $data['bugun_odeme']    = $this->admin_model->toplam_odeme($bugun_bas, $bugun_bit);
            $data['bugun_gelir']    = $this->admin_model->toplam_gelir($bugun_bas, $bugun_bit);
            $data['bugun_gider']    = $this->admin_model->toplam_gider($bugun_bas, $bugun_bit);
            $data['bugun_alis']     = $this->admin_model->toplam_alis($bugun_bas, $bugun_bit);
            $data['bugun_satis']    = $this->admin_model->toplam_satis($bugun_bas, $bugun_bit);

            //Bu haftaayaraya
            $buhafta              = date("Y-m-d", strtotime('-7 days'));
            $data['buh_tahsilat'] = $this->admin_model->toplam_tahsilat($buhafta, $bugun_bit);
            $data['buh_odeme']    = $this->admin_model->toplam_odeme($buhafta, $bugun_bit);
            $data['buh_gelir']    = $this->admin_model->toplam_gelir($buhafta, $bugun_bit);
            $data['buh_gider']    = $this->admin_model->toplam_gider($buhafta, $bugun_bit);
            $data['buh_alis']     = $this->admin_model->toplam_alis($buhafta, $bugun_bit);
            $data['buh_satis']    = $this->admin_model->toplam_satis($buhafta, $bugun_bit);

            //Bu ay
            $buay                  = date("Y-m-d", strtotime('-30 days'));
            $data['buay_tahsilat'] = $this->admin_model->toplam_tahsilat($buay, $bugun_bit);
            $data['buay_odeme']    = $this->admin_model->toplam_odeme($buay, $bugun_bit);
            $data['buay_gelir']    = $this->admin_model->toplam_gelir($buay, $bugun_bit);
            $data['buay_gider']    = $this->admin_model->toplam_gider($buay, $bugun_bit);
            $data['buay_alis']     = $this->admin_model->toplam_alis($buay, $bugun_bit);
            $data['buay_satis']    = $this->admin_model->toplam_satis($buay, $bugun_bit);

            //Bu yil
            $buyil                  = date("Y-m-d", strtotime('-365 days'));
            $data['buyil_tahsilat'] = $this->admin_model->toplam_tahsilat($buyil, $bugun_bit);
            $data['buyil_odeme']    = $this->admin_model->toplam_odeme($buyil, $bugun_bit);
            $data['buyil_gelir']    = $this->admin_model->toplam_gelir($buyil, $bugun_bit);
            $data['buyil_gider']    = $this->admin_model->toplam_gider($buyil, $bugun_bit);
            $data['buyil_alis']     = $this->admin_model->toplam_alis($buyil, $bugun_bit);
            $data['buyil_satis']    = $this->admin_model->toplam_satis($buyil, $bugun_bit);

            //Bu yil
            $top                     = date("Y-m-d", strtotime('-365 days'));
            $data['toplam_tahsilat'] = $this->admin_model->toplam_tahsilat($buyil, $bugun_bit);
            $data['toplam_odeme']    = $this->admin_model->toplam_odeme($buyil, $bugun_bit);
            $data['toplam_gelir']    = $this->admin_model->toplam_gelir($buyil, $bugun_bit);
            $data['toplam_gider']    = $this->admin_model->toplam_gider($buyil, $bugun_bit);
            $data['toplam_alis']     = $this->admin_model->toplam_alis($buyil, $bugun_bit);
            $data['toplam_satis']    = $this->admin_model->toplam_satis($buyil, $bugun_bit);
            $data["currency"]        = $this->session->userdata('para_birim');

            $buyil                = "2000-01-01";
            $bugun_bit            = "2100-12-12";
            $data['toplam_durum'] = $this->admin_model->toplam_durum($buyil, $bugun_bit);

            $data['toplam_durum_kasa'] = $this->admin_model->toplam_durum_kasa($buyil, $bugun_bit);

            $tum_urunler                        = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data['toplam_stok_satis_degeri']   = 0.00;
            $n                                  = 0;if ($tum_urunler): foreach ($tum_urunler as $dizi):
                    $tum_urunler[$n]                  = json_decode(json_encode($tum_urunler[$n]), false);
                    $tum_urunler[$n]                  = $this->stok_satis_degeri_getir("", $tum_urunler[$n]);
                    $data['toplam_stok_satis_degeri'] = $data['toplam_stok_satis_degeri'] + $tum_urunler[$n];
                    $n                                = $n + 1;endforeach;endif;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('anasayfa', (array) $output);

        }

    }

    public function crud_status($crud, $add = 0, $edit = 0, $read = 0, $delete = 0)
    {

        $state      = $crud->getState();
        $state_info = $crud->getStateInfo();

        if ($add == 0) {
            if ($state == 'add') {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

        }
        if ($edit == 0) {
            if ($state == 'edit') {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

        }
        if ($read == 0) {

            if ($state == 'read') {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

                echo 1;
            }

        }
        if ($delete == 0) {
            if ($state == 'delete') {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

        }

    }

    public function adminkayit()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->library('messages');
            $this->messages->config('yonetim');

        }

    }

    //Admin Kaydet

    public function adminkaydet()
    {

        error_reporting(0);

        $name     = $this->input->post('adi', true);
        $name     = trim($name);
        $name     = strip_tags($name);
        $name     = htmlentities($name);
        $email    = $this->input->post('email', true);
        $email    = trim($email);
        $email    = strip_tags($email);
        $email    = htmlentities($email);
        $username = $this->input->post('kullanici', true);
        $username = trim($username);
        $username = strip_tags($username);
        $username = htmlentities($username);
        $pass1    = $this->input->post('sifre1', true);
        $pass1    = trim($pass1);
        $pass1    = strip_tags($pass1);
        $pass1    = htmlentities($pass1);
        $pass2    = $this->input->post('sifre2', true);
        $pass2    = trim($pass2);
        $pass2    = strip_tags($pass2);
        $pass2    = htmlentities($pass2);
        $bina_adi = $this->input->post('bina_adi', true);
        $bina_adi = trim($bina_adi);
        $bina_adi = strip_tags($bina_adi);
        $bina_adi = htmlentities($bina_adi);

        $this->load->library('messages');

        if ($pass1 != $pass2) {

            echo $this->messages->Pass_Error('yonetim');

        } else {

            $pass = md5($pass1);

            $data = array($name, $email, $username, $pass, $bina_adi);
            $this->load->model('admin_model');
            $admin_register_before = $this->admin_model->admin_register_before($username, $email);

            if ($admin_register_before) {

                echo $this->messages->False_Add('yonetim/adminkayit');

            } else {

                $return = $this->admin_model->admin_register($data);

                if ($return) {
                    $url = base_url();
                    $this->load->library('mail/eposta');
                //    $this->eposta->kayit($url, $name, $email, $return);

                    echo $this->messages->True_Add('yonetim');
                } else {

                    echo $this->messages->False_Add('yonetim');
                }

                return false;
            }

        }

        echo $this->messages->False_Add('yonetim');

    }

    public function success($pass)
    {
        error_reporting(0);
        $this->load->library('Messages');
        $this->load->model('admin_model');

        $uye_onay = $this->admin_model->uye_onay($pass);

        if ($uye_onay == 1) {

            $mails = $this->admin_model->mails($pass);

            $url = base_url();
            $this->load->library('mail/eposta');
            $this->eposta->kayit_onay_bilgi($url, $mails);

            echo $this->messages->True_Onay_Message('yonetim');
            return false;

        }

        echo $this->messages->False_Onay_Message('yonetim/adminkayit');
        return false;

    }

    public function kontrol()
    {

        $username = $this->input->post('kullanici', true);
        $pass     = $this->input->post('sifre', true);
        $pass     = md5($pass);
        $code     = $this->input->post('code', true);		


        $data = array($username, $pass, $code);
        $this->load->library('messages');
        $this->load->model('admin_model');
        $return = $this->admin_model->admin_return($data);
		

        if ($return != 0) {

            $this->session->unset_userdata($username . '_giris_adedi');
            $this->session->unset_userdata('baslangic');
            $this->session->unset_userdata('bitis');

            $bilgi = $this->admin_model->admin_bilgi($data);

            if ($bilgi): foreach ($bilgi as $dizi):

                    $id           = $dizi["id"];
                    $kullanici_id = $dizi["kullanici_id"];
                    $name         = $dizi["name"];
                    $email        = $dizi["email"];
                    $uye_turu     = $dizi["uye_turu"];
                    $yetki = $dizi["yetki"];
					
					
                    $firma           = $dizi["firma"];
                    $uyelik = $dizi["uyelik"];
                    $stok         = $dizi["stok"];
                    $cari        = $dizi["cari"];
                    $siparis     = $dizi["siparis"];					
					
				     

                endforeach;endif;
				
				
	           $cari_id = $this->admin_model->uye_carisi_getir($id,$kullanici_id);			

            $para_birimi = $this->admin_model->para_birimi($kullanici_id);

            if ($para_birimi): foreach ($para_birimi as $dizi):

                    $para_birim = $dizi["para_birim"];
                    $bina_adi   = $dizi["adi"];


                endforeach;endif;

            $this->session->set_userdata('adminonline', $username);
            $online = $this->session->userdata('adminonline');

            $this->session->set_userdata('id', $id);
            $id = $this->session->userdata('id');

            $this->session->set_userdata('name', $name);
            $name = $this->session->userdata('name');

            $this->session->set_userdata('email', $email);
            $email = $this->session->userdata('email');

            $this->session->set_userdata('uye_turu', $uye_turu);
            $uye_turu = $this->session->userdata('uye_turu');

            $this->session->set_userdata('kullanici_id', $kullanici_id);
            $kullanici_id = $this->session->userdata('kullanici_id');

            $this->session->set_userdata('para_birim', $para_birim);
            $para_birim = $this->session->userdata('para_birim');

            if ($return == 2) {$odeme = 1;} else { $odeme = 2;}

            $this->session->set_userdata('odeme', $odeme);
            $odeme = $this->session->userdata('odeme');

            $this->session->set_userdata('yetki', $yetki);
            $yetki = $this->session->userdata('yetki');

            $this->session->set_userdata('bina_adi', $bina_adi);
            $bina_adi = $this->session->userdata('bina_adi');

            $this->session->set_userdata('cari_id', $cari_id);
            $cari_id = $this->session->userdata('cari_id');
            
		


            $this->session->set_userdata('yetki_firma', $firma);
            $yetki_firma = $this->session->userdata('yetki_firma');

            $this->session->set_userdata('yetki_uyelik', $uyelik);
            $yetki_uyelik = $this->session->userdata('yetki_uyelik');

            $this->session->set_userdata('yetki_stok', $stok);
            $yetki_stok = $this->session->userdata('yetki_stok');


            $this->session->set_userdata('yetki_cari', $cari);
            $yetki_cari = $this->session->userdata('yetki_cari');


            $this->session->set_userdata('yetki_siparis', $siparis);
            $yetki_siparis = $this->session->userdata('yetki_siparis');
	
			$satis=$this->merkezsatis(1);
            $this->session->set_userdata('satis', $satis);
            $satis = $this->session->userdata('satis');	
			 
			
			

            $anahtar = md5($this->session->userdata('kullanici_id') . "_" . $this->session->userdata('id'));
            $this->session->set_userdata('anahtar', $anahtar);

            echo $this->messages->Welcome('yonetim', $online);

        } else {

    /*        $this->session->set_userdata("xxx", date('Y-m-d h:i:s'));
            $bitis = strtotime($this->session->userdata("xxx"));
            $bas   = strtotime($this->session->userdata("baslangic"));
            $dk    = round(abs($bitis - $bas) / 60, 0);

            if ($dk >= 15) {
                $this->session->set_userdata($username . "giris_deneme_hatasi", "");
                $this->session->unset_userdata($username . '_giris_adedi');
                $this->session->unset_userdata('baslangic');
                $this->session->unset_userdata('bitis');

            }

            $giris_adedi = $this->session->userdata($username . '_giris_adedi') + 1;

            $this->session->set_userdata($username . '_giris_adedi', $giris_adedi);
            $this->session->set_userdata("baslangic", date('Y-m-d h:i:s')); // expires in 4 hours
*/
            echo $this->messages->Welcome_False('yonetim');
        }

    }

    public function cikis()
    {
        $this->load->library('messages');
        $this->session->unset_userdata('adminonline');
        $this->session->unset_userdata('odeme');
        $this->session->sess_destroy();
        echo $this->messages->Logout('yonetim');

    }

    public function pass_remember()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->view('forgot-pass.php');
            return false;
        }

        $this->load->library('Messages');
        echo $this->messages->config('yonetim');
        return false;

    }

    public function new_pass()
    {

        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        }

        $this->load->library('Messages');
        $this->load->model('admin_model');
        $email = $this->input->post('my-mail', true);
        $email = trim($email);
        $email = htmlentities($email);
        $email = strip_tags($email);
        $email = strtolower($email);

        if ($email == "") {
            echo $this->messages->config('');
            return false;
        }

        $return = $this->admin_model->kontrol($email);

        if ($return != 1) {

            echo $this->messages->False_Bulunamadi('yonetim/pass_remember');

        }

        if ($return == 1) {

            $pass = $this->admin_model->pass_getir($email);

            $this->load->library('mail/eposta');
            $mail = $this->eposta->new_pass(base_url(), $pass, $email);

            if ($mail == true) {
                $this->load->library('Messages');
                echo $this->messages->New_Pass('');

            }

        }

    }

    public function new_pass_success($pass)
    {
        error_reporting(0);
        $useronline = $this->session->userdata('useronline');
        if ($useronline != "") {
            $this->load->library('Messages');
            echo $this->messages->config('');
            return false;

        }

        $data["pass"] = $pass;
        $this->load->view('new-pass.php', $data);

    }

    public function new_pass_success_ok()
    {
        error_reporting(0);
        $useronline = $this->session->userdata('useronline');
        if ($useronline != "") {
            $this->load->library('Messages');
            echo $this->messages->config('');
            return false;

        }
        $pass = $this->input->post('pass', true);
        $ps   = $this->input->post('ps', true);
        $ps2  = $this->input->post('ps2', true);

        $pass = trim($pass);
        $ps   = trim($ps);
        $ps2  = trim($ps2);

        $pass = trim($pass);
        $ps   = htmlentities($ps);
        $ps2  = htmlentities($ps2);

        $pass = trim($pass);
        $ps   = strip_tags($ps);
        $ps2  = strip_tags($ps2);

        if ($ps != $ps2) {

            $this->load->library('Messages');
            echo $this->messages->Pass_Error('yonetim');
            return false;
        }

        $sf = md5($ps);
        $this->load->model('admin_model');

        $sifre_guncelle = $this->admin_model->sifre_guncelle($sf, $pass);

        if ($sifre_guncelle != 1) {
            $this->load->library('Messages');
            echo $this->messages->New_Pass_False('yonetim');
            return false;

        }

        $this->load->library('Messages');
        echo $this->messages->New_Pass_True('yonetim');

        return false;

    }

    public function ayar()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $uye_turu = $this->admin_model->uye_turu_getir($online);

            if ($uye_turu != 0) {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('ayar');

            $crud->set_subject('Ayarlar');
            $crud->columns('facebook', 'twitter', 'instagram', 'email', 'tel_1');
            $crud->display_as('web_url', 'Site adresi');
            $crud->display_as('email', 'E-Mail');
            $crud->display_as('tel_1', 'Telefon');
            $crud->display_as('tel_2', 'Telefon 2');
            $crud->display_as('fax', 'Fax');
            $crud->display_as('company_name', 'Yetkili Kişi');
            $crud->display_as('adress', 'Adres');
            $crud->display_as('home_slogan', 'Anasayfa Üst Slogan');
            $crud->display_as('seo_keywords', 'Anahtar Kelimeler');
            $crud->display_as('maps', 'Google Harita Linki');
            $crud->display_as('home_photo', 'Anasayfa Üst Resim 1920*1080');

            $crud->display_as('otel_photo', 'Otel Üst Resim 1920*1080');
            $crud->display_as('otel_slogan', 'Otel Üst Slogan');

            $crud->required_fields('web_url', 'email', 'tel_1', 'company_name', 'home_photo', 'otel_photo');
            $crud->set_field_upload('home_photo', 'assets/resimler/home');
            $crud->set_field_upload('otel_photo', 'assets/resimler/home');
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $crud->unset_export();
            $crud->unset_print();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 1, 0, 0); // add edit read delete

            $crud->unset_fields("kisa_aciklama_tr", "uzun_aciklama_tr", "home_slogan_tr", "otel_slogan_tr", "site_slogan_tr"
                , "kisa_aciklama_ru", "uzun_aciklama_ru", "home_slogan_ru", "otel_slogan_ru", "site_slogan_ru");

            $this->log_grocery($crud, "Ayar", "ayar");

            $data['side_menu'] = "ayar";
            $data['kilavuz']   = "  <b>Sistem Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }}

    public function bilgi($edit = null, $id = null)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $uye_id = $this->admin_model->uye_id_getir($online);

            if ($id != $uye_id) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();
            $this->crud_status($crud, 0, 1, 0, 0); // add edit read delete

            $crud->set_theme('flexigrid');
            $crud->set_table('uyeler');
            $crud->where('username', $online);
            $crud->set_subject('bilgi');
            $crud->columns('name', 'username', 'pass', 'email');
            $crud->display_as('name', 'Adı Soyadı');
            $crud->display_as('username', 'Kullanıcı Adı');
            $crud->display_as('pass', 'Şifre (Eski veya yeni şifre)');
            $crud->display_as('email', 'E-Mail');
            $crud->display_as('status', 'Admin Türü');
            $crud->display_as('bas_tar', 'Üye Başlangıç Tarihi');
            $crud->display_as('bit_tar', 'Üye Bitiş Tarihi');

            $crud->required_fields('name', 'pass', 'email');
            $crud->unset_fields('status', "bas_tar", "bit_tar", "cari_id", "uye_turu", "kullanici_id", "yetki");
            $crud->unset_edit_fields('status', "cari_id", "uye_turu", "kullanici_id", "yetki");

            $crud->field_type('username', 'readonly');
            $crud->field_type('uye_sayisi', 'readonly');
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_list();
            $crud->unset_delete();
            $crud->unset_export();
            $crud->unset_print();
            $crud->unset_back_to_list();
            $crud->change_field_type('pass', 'password');
            $crud->callback_before_update(array($this, 'encrypt_password_callback'));
            $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
            $this->log_grocery($crud, "Bilgi", "uyeler");

            $crud->field_type('bas_tar', 'readonly');
            $crud->field_type('bit_tar', 'readonly');

            $data['side_menu'] = "ayar";
            $data['kilavuz']   = "  <b>Admin Bilgi Ayarları</b>";

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function encrypt_password_callback($post_array, $primary_key = null)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            if ($post_array['pass'] == '') {return false;} else {

                $post_array['pass'] = md5($post_array['pass']);
                return $post_array;

            }

        }

    }

    public function firma($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_bina = $this->admin_model->yetki_kontrol_bina($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_bina != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }
			
	if($this->session->userdata('yetki_firma')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
		
	}					
			

            $crud->set_theme('flexigrid');
            $crud->set_table('bina');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Firma Ayar');
            $crud->columns('adi', 'adres');
            $crud->required_fields('adi', 'adres');
            $crud->field_type('kullanici_id', 'hidden');

            $crud->unset_edit_fields('blok', 'orkestra_musteri_no', 'orkestra_kullanici', 'orkestra_sifre', 'orkestra_api');
            $crud->field_type('para_birim', 'dropdown',
                array('TL' => 'TL', 'Euro'     => 'Euro', 'Usd'           => 'Usd',
                    'Pound'    => 'Pound', 'Ruble' => 'Ruble', 'Kuveyt Dinar' => 'Kuveyt Dinar'));
            $crud->field_type('orkestra_aktif', 'dropdown',
                array('0' => 'Pasif', '1' => 'Aktif'));
				
            $crud->display_as('adi','Yetkili');				
            $crud->display_as('resmi_adi','Adı Soyadı/Ünvanı');					
            $crud->display_as('vergi_no','Vergi No/Tc No');		
            $crud->display_as('email','E-Posta');				
	        $crud->display_as('tel','Cep/Sabit Tel');				
            $crud->set_field_upload('logo_kase', 'assets/uploads/files');			
			
            $crud->unset_back_to_list();
            $crud->unset_add();
            $crud->unset_delete();
            $this->log_grocery($crud, "Firma", "bina");

            $this->crud_status($crud, 0, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Firma Ayarları";
            $data['kilavuz']   = "  <b>Firma Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function blok($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_blok = $this->admin_model->yetki_kontrol_blok($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_blok != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->callback_after_update(array($this, 'daire_kayit'));

            $crud->set_theme('flexigrid');
            $crud->set_table('blok');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Bina Ayar');
            $crud->columns('adi', 'daire_adet');
            $crud->required_fields('adi', 'adres');
            $crud->field_type('kullanici_id', 'hidden');
            $crud->display_as('daire_adet', 'Daire Adet (Güncellerseniz tüm daireler yeniden oluşturulacaktır.)');

            $crud->field_type('blok_id', 'hidden');
            $crud->field_type('kullanici_id', 'hidden');
            $crud->unset_back_to_list();
            $crud->unset_add();
            $crud->unset_delete();
            $this->log_grocery($crud, "Blok", "blok");

            $this->crud_status($crud, 0, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Bina Ayarları";
            $data['kilavuz']   = "  <b>Bina Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function daire_kayit($post_array, $primary_key)
    {

        $this->db->where('blok_id', $primary_key);
        $this->db->delete('daire');

        $this->load->model('admin_model');
        $blok_bilgi_getir = $this->admin_model->blok_bilgi_getir($this->session->userdata('kullanici_id'), $primary_key);
        $daire_say        = $this->admin_model->daire_say($this->session->userdata('kullanici_id'), $primary_key);

        if ($blok_bilgi_getir): foreach ($blok_bilgi_getir as $dizi):

                $daire_adet   = $dizi["daire_adet"];
                $bina_id      = $dizi["blok_id"];
                $kullanici_id = $dizi["kullanici_id"];
            endforeach;endif;

        $yeni_daire = $daire_adet - $daire_say;
        if ($yeni_daire <= 0) {} else {

            $d_no = $daire_say;

            $dongu = $yeni_daire - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $insert = array(
                    'bina_id'      => $bina_id,
                    'blok_id'      => $primary_key,
                    'kullanici_id' => $kullanici_id,
                    'daire_no'     => $d_no + $i + 1,
                );
/**/
                $this->db->insert('daire', $insert);

            }

        }

        return true;
    }

    public function daire($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_daire = $this->admin_model->yetki_kontrol_daire($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_daire != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kullanici_id', 'hidden');
                $crud->field_type('bina_id', 'hidden');
                $crud->field_type('blok_id', 'hidden');
                $crud->unset_edit_fields('daire_no');

                $crud->set_relation('sahip_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('kiraci_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_daire = $this->admin_model->yetki_kontrol_daire($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_daire != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kullanici_id', 'hidden');

                $crud->set_relation('bina_id', 'bina', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('blok_id', 'blok', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

                $crud->set_relation('sahip_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('kiraci_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('daire');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Daireler');
            $crud->columns('blok_id', 'daire_no', 'daire_sahibi', 'kiraci');
            $crud->required_fields('sahip_id');
            $crud->display_as('kiraci_id', 'Kiracı');
            $crud->display_as('sahip_id', 'Daire Sahibi');
            $crud->callback_column('daire_sahibi', array($this, 'callback_cari_getir2'));
            $crud->callback_column('kiraci', array($this, 'callback_cari_getir3'));
            $crud->callback_column('blok_id', array($this, 'blok_adi_getir'));
            $crud->unset_back_to_list();
            $crud->unset_add();
            $crud->unset_delete();
            $this->log_grocery($crud, "Daire", "daire");

            $this->crud_status($crud, 0, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Daire Ayarları";
            $data['kilavuz']   = "  <b>Daire Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function cari($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }
			
		if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}			
			
			
			

            $crud->set_theme('flexigrid');
            $crud->set_table('cari');

            $crud->set_subject('Cariler');
            $crud->columns('adi_soyadi_unvan', 'kisi_turu', 'Cari İşlemleri', 'Cari Kaldır');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));

			if($this->session->userdata('uye_turu')==2){
            $crud->where('personel', $this->session->userdata('cari_id'));				
				
			}
			
            //$crud->where('kisi_turu!=', 1);
            $crud->required_fields('adi_soyadi_unvan', 'tc', 'eposta', 'kisi_turu');

            $crud->field_type('personel', 'hidden', $this->session->userdata('cari_id'));
			
            $crud->field_type('kisi_turu', 'dropdown',
                array('0' => 'Gerçek Kisi','0' => 'Personel', '2' => 'Tüzel Kişi'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('bas_borc_alacak', 'Başlangıç borç alacak');
            $crud->display_as('bas_boal_durum', 'Başlangıç borç alacak durumu');
            $crud->display_as('vergi', 'Vergi No');
            $crud->display_as('tc', 'Tc & Vergi No');
            $crud->field_type('eposta_durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $crud->callback_column('Cari İşlemleri', array($this, 'islem_kaydi_getir'));

            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $crud->field_type('bas_boal_durum', 'dropdown',
                array('1' => 'Cari Borçlu', '0' => 'Cari Alacaklı'));

            $this->log_grocery($crud, "Cari", "cari");

         //    $crud->set_rules('tc', 'Department', 'callback_tc_kontrol');
        //    $crud->set_rules('eposta', 'Department', 'callback_eposta_kontrol');

            $crud->callback_column('Cari Kaldır', array($this, 'callback_cari_kaldir'));
            $crud->unset_back_to_list();
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_fields("maas", "gorev", "aciklama", "baslama_tarihi", "cikis_tarihi", "ozluk_dosyalari");
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Cari Ayarları";
            $data['kilavuz']   = "  <b>Cari Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //     echo json_encode((array)$output);
            // $this->load->view('index',(array)$output);

            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function tc_kontrol($val)
    {

        $tc = $val;

        if (strlen($tc) < 11) {
            $this->form_validation->set_message('tc_kontrol', 'Lütfen geçerli bir tc. kimlik no"su giriniz.');
            return false;

        }
        if ($tc[0] == '0') {
            $this->form_validation->set_message('tc_kontrol', 'Lütfen geçerli bir tc. kimlik no"su giriniz.');
            return false;

        }
        $plus  = ($tc[0] + $tc[2] + $tc[4] + $tc[6] + $tc[8]) * 7;
        $minus = $plus - ($tc[1] + $tc[3] + $tc[5] + $tc[7]);
        $mod   = $minus % 10;
        if ($mod != $tc[9]) {
            $this->form_validation->set_message('tc_kontrol', 'Lütfen geçerli bir tc. kimlik no"su giriniz.');
            return false;

        }
        $all = '';
        for ($i = 0; $i < 10; $i++) {$all += $tc[$i];}
        if ($all % 10 != $tc[10]) {
            $this->form_validation->set_message('tc_kontrol', 'Lütfen geçerli bir tc. kimlik no"su giriniz.');
            return false;

        }

        return true;

    }

    public function eposta_kontrol($eposta)
    {
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $eposta)) {
            list($username, $domain) = explode('@', $eposta);
            if (!checkdnsrr($domain, 'MX')) {

                $this->form_validation->set_message('eposta_kontrol', 'Lütfen geçerli bir eposta adresi.');
                return false;

            }

            return true;
        }
        $this->form_validation->set_message('epostaKontrol', 'Lütfen geçerli bir eposta adresi.');

        return false;
    }

    public function potansiyel($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('potansiyel');

            $crud->set_subject('Potansiyel Müşteriler');
            $crud->columns('adi_soyadi_unvan', 'kisi_turu', 'Potansiyel Taşı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kisi_turu!=', 1);
            $crud->required_fields('adi_soyadi_unvan',  'tc', 'eposta', 'kisi_turu');

            $crud->field_type('kisi_turu', 'dropdown',
                array('0' => 'Gerçek Kisi', '2' => 'Tüzel Kişi'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('bas_borc_alacak', 'Başlangıç borç alacak');
            $crud->display_as('bas_boal_durum', 'Başlangıç borç alacak durumu');
            $crud->display_as('vergi', 'Vergi No');
            $crud->display_as('tc', 'Tc & Vergi No');
            $crud->field_type('eposta_durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $crud->field_type('bas_boal_durum', 'dropdown',
                array('1' => 'Cari Borçlu', '0' => 'Cari Alacaklı'));

            $this->log_grocery($crud, "Potansiyel", "potansiyel");

            $crud->callback_column('Potansiyel Taşı', array($this, 'callback_pot_tasi'));
            $crud->unset_back_to_list();
            $crud->unset_clone();
            $crud->unset_fields("maas", "gorev", "aciklama", "baslama_tarihi", "cikis_tarihi", "ozluk_dosyalari");
            $crud->unset_back_to_list();
            $data['side_menu'] = "Potansiyel Ayarları";
            $data['kilavuz']   = "  <b>Potansiyel Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //     echo json_encode((array)$output);
            // $this->load->view('index',(array)$output);

            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_cari_kaldir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari_sil_kontrol/' . $row->id) . "'>Cari Kaldır</a>";
        }

    }

    public function callback_pot_tasi($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari_pot_tasi/' . $row->id) . "'>Cariye Taşı</a>";
        }

    }

    public function cari_pot_tasi($primary_key)
    {

        $sql   = "SELECT * FROM potansiyel where id=" . $primary_key;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $arr = $query->result_array();
        } else {
            return false;
        }

        $insert = array(
            'name'     => 11,
            'username' => 22,
            'pass'     => 33,
            'email'    => 44,
            'status'   => 0,
            'bas_tar'  => 55,
            'bit_tar'  => 66,
            'uye_turu' => 1,

        );

        unset($arr[0]["id"]);
        $into = $this->db->insert('cari', $arr[0]);
        if ($into) {
            $this->db->where('id', $primary_key);
            $this->db->delete('potansiyel');
        }

        $this->load->library('Messages');
        echo $this->messages->True_Add('yonetim/cari');
        return false;

    }

    public function cari_sil_kontrol($primary_key)
    {

        $this->load->library('Messages');

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('teklif');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('siparis');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('irsaliye');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('fatura');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('borc_alacak');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('cek_senet');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('islem');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $isset = $this->db->get('komite');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('kim', $primary_key);
        $sil = $this->db->delete('etkinlik');
        if (!$sil) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $sil = $this->db->delete('izin');
        if (!$sil) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('kim', $primary_key);
        $sil = $this->db->delete('notlar');
        if (!$sil) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('kim', $primary_key);
        $sil = $this->db->delete('task');
        if (!$sil) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('cari_id', $primary_key);
        $sil = $this->db->delete('zimmet');
        if (!$sil) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/cari', "Cari");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('id', $primary_key);
        $sil = $this->db->delete('cari');
        echo $this->messages->True_Add('yonetim/cari');
        return false;

    }

    public function personel($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('cari');

            $crud->set_subject('Personeller');
            $crud->columns('adi_soyadi_unvan');
			if($this->session->userdata('uye_turu')==2){
            $crud->where('personel', $this->session->userdata('cari_id'));				
				
			}
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kisi_turu', 1);
            $crud->required_fields('adi_soyadi_unvan', 'tc', 'eposta', 'kisi_turu');

            $crud->field_type('kisi_turu', 'hidden', 1);
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('bas_borc_alacak', 'Başlangıç borç alacak');
            $crud->display_as('bas_boal_durum', 'Başlangıç borç alacak durumu');
            $crud->field_type('eposta_durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->callback_before_delete(array($this, 'cari_sil_kontrol'));
            $crud->unset_clone();
            $crud->set_field_upload('ozluk_dosyalari', 'assets/uploads/files');

            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->field_type('bas_boal_durum', 'dropdown',
                array('1' => 'Personel Borçlu', '0' => 'Personel Alacaklı'));

            $crud->unset_back_to_list();
            $this->log_grocery($crud, "Personel", "personel");

            $data['side_menu'] = "Personel Ayarları";
            $data['kilavuz']   = "  <b>Personel Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function aday($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->field_type('kisi_turu', 'hidden', 3);

            }
            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kisi_turu', 'dropdown',
                    array('1' => 'Personel', '3' => 'Aday'));

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kisi_turu', 'dropdown',
                    array('1' => 'Personel', '3' => 'Aday'));

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('cari');

            $crud->set_subject('Aday');
            $crud->columns('adi_soyadi_unvan');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kisi_turu', 3);
            $crud->required_fields('adi_soyadi_unvan', 'tc', 'eposta', 'kisi_turu');
			if($this->session->userdata('uye_turu')==2){
            $crud->where('personel', $this->session->userdata('cari_id'));				
				
			}
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('bas_borc_alacak', 'Başlangıç borç alacak');
            $crud->display_as('bas_boal_durum', 'Başlangıç borç alacak durumu');
            $crud->display_as('gorev', 'Pozisyon');
            $crud->display_as('maas', 'Maaş Beklentisi');
            $crud->display_as('baslama_tarihi', 'Görüşme Tarihi');
            $crud->display_as('ozluk_dosyalari', 'Cv');

            $crud->field_type('eposta_durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $this->log_grocery($crud, "Aday", "aday");
            $crud->unset_back_to_list();
            $crud->unset_fields("durum", "cikis_tarihi");
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->set_field_upload('ozluk_dosyalari', 'assets/uploads/files');

            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->field_type('bas_boal_durum', 'dropdown',
                array('1' => 'Aday Personel Borçlu', '0' => 'Aday Personel Alacaklı'));

            $data['side_menu'] = "Personel Ayarları";
            $data['kilavuz']   = "  <b>Personel Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function zimmet($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('demirbas', 'hizmet_urun', 'adi', ['demirbas = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_zimmet = $this->admin_model->yetki_kontrol_zimmet($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_zimmet != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('demirbas', 'hizmet_urun', 'adi', ['demirbas = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_zimmet = $this->admin_model->yetki_kontrol_zimmet($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_zimmet != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('demirbas', 'hizmet_urun', 'adi', ['demirbas = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            } else if ($state == 'delete') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_zimmet = $this->admin_model->yetki_kontrol_zimmet($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_zimmet != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('zimmet');

            $crud->set_subject('Zimmet');
            $crud->columns('cari_id', 'demirbas', 'adet', 'teslim_tarihi', 'iade_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('cari_id', 'demirbas', 'adet', 'teslim_tarihi', 'cari_id');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('cari_id', 'Personel');
            $crud->unset_clone();
            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));

            $crud->callback_column('demirbas', array($this, 'demirbas_getir'));
            $crud->unset_back_to_list();
            $this->log_grocery($crud, "Zimmet", "zimmet");

            $data['side_menu'] = "Zimmet Ayarları";
            $data['kilavuz']   = "  <b>Zimmet Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function izin($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_izin = $this->admin_model->yetki_kontrol_izin($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_izin != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_izin = $this->admin_model->yetki_kontrol_izin($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_izin != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kisi_turu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            } else if ($state == 'delete') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_izin = $this->admin_model->yetki_kontrol_izin($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_izin != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('izin');

            $crud->set_subject('İzinler');
            $crud->columns('cari_id', 'gun', 'baslangic_tarihi', 'bitis_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('cari_id', 'adet', 'teslim_tarihi', 'cari_id');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('cari_id', 'Personel');
            $crud->unset_clone();
            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->unset_back_to_list();
            $this->log_grocery($crud, "İzin", "izin");
            $data['side_menu'] = "İzin Ayarları";
            $data['kilavuz']   = "  <b>İzin Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function hizmet_urun( $id = null , $edit = null)
    {
		
			if(($id!=1)and($id!=2)){
		
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;		
		
	}

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
	if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}				
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);


            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('hizmet_urun');

            $crud->set_subject('Hizmet Ürünler');
            $crud->columns('adi',  'satis_fiyat', 'Ürün Kaldır');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
	        $crud->where('urun_grubu', $id);			
            $crud->required_fields('adi', 'birim', 'alis_fiyat', 'satis_fiyat');
            $crud->callback_column('Ürün Kaldır', array($this, 'callback_urun_kaldir'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('demirbas', 'dropdown',
                array('0' => 'Hayır', '1' => 'Evet'));
            $crud->field_type('urun_grubu', 'hidden', $id);
            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->field_type('urun_hedef_grubu', 'dropdown',
                array('0' => 'Hedef dışı', '1' => 'Masaüstü', '2' => 'Nova', '3' => 'E-Modül'));
            $crud->field_type('is_vkn_obligatory', 'dropdown',
                array('0' => 'Hayır Vkn Gerekmiyor', '1' => 'Evet Vkn Gerekiyor'));				
	
            $crud->field_type('is_transformation', 'dropdown',
                array('0' => 'Hiçbiri', '1' => 'Ana E-Dönüşüm Paketi', '2' => 'Yardımcı E-Dönüşüm Paketi'));
	

            $arr = $this->get_upgrade();		
				     $crud->field_type('is_upgrade', 'dropdown',
              $arr  );			

		
           $sql   = "SELECT id,adi FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id');
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ur = $query->result_array();
        } else {
       
        }	
		

		
			$i=0;   $n [] =""; $n [0] = "Hiçbiri";   if ($ur): foreach ($ur as $dizi):				
			 $n[$ur[$i]["id"]] = $ur[$i]["adi"];
			$i=$i+1; endforeach;endif; 

		
	            $crud->field_type('add_user_product', 'dropdown',
                $n);
	            $crud->field_type('is_transformation', 'dropdown',
                $n);

				
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->display_as("is_upgrade","Bu ürün bir paket yükseltme ürünü ise, hangi pakete yüseltme işlemi gerçekleşiyor ?");	
            $crud->display_as("alis_fiyat","Kdv'siz Peşin Satış Fiyat");	
            $crud->display_as("alis_fiyat_6_tk","Kdv'siz 6 Taksit Satış Fiyat");
            $crud->display_as("alis_fiyatt_9_tk","Kdv'siz 9 Taksit Peşin Satış Fiyat");	
            $crud->display_as("is_vkn_obligatory","Bu ürün seçildiğinde vergi kimlik numarası istensin mi ?");	
            $crud->display_as("is_transformation","Bu ürün E-Dönüşüm Paketi İse hangi ürünle ilişkili ?");	
            $crud->display_as("add_user_product" , "Bu ürün ilave kullanıcı ürünü ise hangi ürünle ilişkili ?");				
            $this->log_grocery($crud, "Hizmet Ürün", "hizmet_urun");
            $crud->unset_back_to_list();
            $crud->unset_fields("demirbas","demirbas_adet");			

            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Hizmet Ürün Ayarları";
            $data['kilavuz']   = "  <b>Hizmet Ürün Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
	function get_upgrade()
	{
		
		 $arr [] = "";
		$i = 0;
		$query = $this->db->query("select * from hizmet_urun where kullanici_id=" . $this->session->userdata('kullanici_id')." and kategori=4 and urun_grubu=1");
      foreach ($query->result_array() as $row) {
            $arr[$row['id']] = $row['adi'];
		
			$i++;
		}
     return $arr;
		
	}
	
	
	
	
	
	 public function kat( $id = null )
    {

if(($id!=1) and ($id!=2)){
	
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
	
	
}

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
			
				if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}	
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_kategori($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_kategori($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('urun_kategori');

            $crud->set_subject('Kategoriler');
            $crud->columns('adi','Kampanya Ürünleri');
            $crud->where('kullanici', $this->session->userdata('kullanici_id'));
            $crud->where('urun_grubu_kategori', $id);			
            $crud->required_fields('adi');
            $crud->callback_column('Kampanya Ürünleri', array($this, 'callback_kampanya_urun'));
           $crud->field_type('kullanici', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->field_type('urun_grubu_kategori', 'hidden', $id);
            $crud->field_type('is_old', 'dropdown',
                array('1' => 'Evet Eski Müşterilere Özel Kategori', '0' => 'Hayır Herkese Açık Kategori'));			
	       $crud->display_as('is_old',"Eski Müşterilere Özel Kategori mi?");
            $crud->field_type('takip_turu', 'dropdown',
                array('0' => 'Takipsiz', '1' => 'Adet İle Takip' , '2' => 'Tarih İle Takip'));			
	   
			
			if($id==1){
		           $crud->field_type('kampanya', 'dropdown',
                array('1' => 'Evet', '0' => 'Hayır'));		
				
			}
			else{
				
            $crud->field_type('kampanya', 'hidden', 0);				
			}
 			

			
		
				
				
				
   
            $crud->unset_clone();
            $this->log_grocery($crud, "Ürün Kategori", "urun_kategori");
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Ürün Kategori Ayarları";
            $data['kilavuz']   = "  <b>Ürün Kategori Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
	



	 public function uruneslestir( )
    {



        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
			
	if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}				
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_eslestir($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_eslestir($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('uruneslestir');
            $crud->set_subject('Ürün Eşleştirme');
            $crud->columns('urun_1','kategori_2','Ürünler');
            $crud->where('uruneslestir_kullanici_id', $this->session->userdata('kullanici_id'));		
            $crud->required_fields('urun_1');

            $crud->field_type('uruneslestir_kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
         
        $crud->set_relation('urun_1', 'hizmet_urun', 'adi', [
                    'urun_grubu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);				
		  	
 
          $crud->set_relation('kategori_2', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => 2, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);		

             $crud->callback_column('Ürünler', array($this, 'callback_urunler'));
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $data['side_menu'] = "Ürün Eşleştirme Ayarları";
            $data['kilavuz']   = "  <b>Ürün Eşleştirme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
	
	
	 public function uruneslestir_ekle( $uruneslestir_id = null , $urun_1=null , $kat_2= null)
    {



        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
			
				if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}	

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_eslestir($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_urun_eslestir($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('uruneslestir_iliski');
            $crud->set_subject('Ürün Eşleştirme Ürün Ekleme');
            $crud->columns('urun_2');
            $crud->where('uruneslestir_kullanici_id', $this->session->userdata('kullanici_id'));	
            $crud->where('urun_1', $urun_1);	
            $crud->where('kategori_2', $kat_2);	
			
            $crud->required_fields('urun_2');

            $crud->field_type('uruneslestir_kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('uruneslestir_id', 'hidden', $uruneslestir_id);
            $crud->field_type('urun_1', 'hidden', $urun_1);
            $crud->field_type('kategori_2', 'hidden', $kat_2);

/*
        $crud->set_relation('urun_1', 'hizmet_urun', 'adi', [
                    'urun_grubu = ' => 1, 'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);				
		  	
 
          $crud->set_relation('kategori_2', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => 2, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);		
 */

          $crud->set_relation('urun_2', 'hizmet_urun', 'adi', [
                    'urun_grubu = ' => 2, 'kullanici_id = ' => $this->session->userdata('kullanici_id'), 'kategori = ' => $kat_2
                ]);	

            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $data['side_menu'] = "Ürün Eşleştirme Ayarları";
            $data['kilavuz']   = "  <b>Ürün Eşleştirme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
    public function kampanya_urunleri( $id = null , $edit = null)
    {


        $sql   = "SELECT * FROM urun_kategori Where id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
        if ($query->result_array()): foreach ($query->result_array() as $dizi):
            if($dizi["kampanya"]!=1){
		            $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;		
				
			}
            endforeach;endif;
        } else {
            return false;
        }





        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}		
			
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);


            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

          $crud->set_relation('kategori', 'urun_kategori', 'adi', [
                    'urun_grubu_kategori = ' => $id, 'kullanici = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('hizmet_urun');

            $crud->set_subject('Hizmet Ürünler');
            $crud->columns('adi', 'alis_fiyat', 'satis_fiyat', 'Ürün Kaldır', 'Bu Kampanyaya Ürün Ekle');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
	        $crud->where('urun_grubu', 1);	
	        $crud->where('kategori', $id);
			
            $crud->required_fields('adi', 'birim', 'alis_fiyat', 'satis_fiyat');
            $crud->callback_column('Ürün Kaldır', array($this, 'callback_urun_kaldir'));
            $crud->callback_column('Bu Kampanyaya Ürün Ekle', array($this, 'callback_kam_urun_ekle'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('demirbas', 'dropdown',
                array('0' => 'Hayır', '1' => 'Evet'));
            $crud->field_type('urun_grubu', 'hidden', $id);
            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
				
            $crud->field_type('is_vkn_obligatory', 'dropdown',
                array('1' => 'Zorunlu', '0' => 'Değil'));
            $crud->field_type('urun_hedef_grubu', 'hidden');
            $crud->field_type('is_upgrade', 'hidden');			
            $crud->display_as('is_vkn_obligatory', 'Vkn Zorunlu mu?');				
				
            $crud->unset_delete();
            $crud->unset_clone();
            $this->log_grocery($crud, "Hizmet Ürün", "hizmet_urun");
            $crud->unset_back_to_list();
            $crud->unset_fields("demirbas","demirbas_adet");			

            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Hizmet Ürün Ayarları";
            $data['kilavuz']   = "  <b>Hizmet Ürün Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }






    public function kam_urun_ekle( $id = null , $edit = null)
    {
		


        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {



            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

  

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }



            }

            $crud->set_theme('flexigrid');
            $crud->set_table('kampanya_urunleri');

            $crud->set_subject('Kampanya Ürünleri');
            $crud->columns( 'urun_id','ana_urun');
            $crud->where('kullanici', $this->session->userdata('kullanici_id'));
	        $crud->where('kampanya_id', $id);			
            $crud->required_fields('kampanya_id', 'urun_id');
            $crud->field_type('kullanici', 'hidden', $this->session->userdata('kullanici_id'));
	        $crud->field_type('kampanya_id', 'hidden', $id);		
            $crud->set_relation('urun_id', 'hizmet_urun', 'adi', [
                     'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
			
            $crud->field_type('ana_urun', 'dropdown',
                array('1' => 'Evet', '0' => 'Hayır'));



            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
		

            $data['side_menu'] = "Hizmet Ürün Ayarları";
            $data['kilavuz']   = "  <b>Hizmet Ürün Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }



    public function hedefler( )
    {
		


        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
		if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}			
			
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {



            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hedef($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

  

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hedef($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }



            }

            $crud->set_theme('flexigrid');
            $crud->set_table('hedefler');

            $crud->set_subject('Hedefler');
            $crud->columns( 'yil','tarih','bayi_id','masaustu_yeni_satis','e_modul_yeni_satis','nova','ygd_satis','e_modul_abonelik_yenileme');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
			$crud->required_fields( 'yil','tarih');
			$crud->display_as("tarih","Ay");
			$crud->display_as("bayi_id","İlgili Bayi");

			
            $crud->field_type('tarih', 'dropdown',
                array('1' => 'Ocak', '2' => 'Şubat', '3' => 'Mart', '4' => 'Nisan', '5' => 'Mayıs', '6' => 'Haziran', '7' => 'Temmuz', '8' => 'Ağustos'
				, '9' => 'Eylül', '10' => 'Ekim', '11' => 'Kasım', '12' => 'Aralık'));

            $crud->field_type('yil', 'dropdown',
                array('2021' => '2021', '2022' => '2022', '2023' => '2023', '2024' => '2024', '2025' => '2025'));
				
            $crud->field_type('bayi_id', 'dropdown',
                array('0' => 'Kayseri Merkez', '1' => 'Nevşehir', '2' => 'Kırşehir', '3' => 'Yozgat', '4' => 'Aksaray', '5' => 'Kayseri Bölge'));				
				

            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
			

            $data['side_menu'] = "Hizmet Ürün Ayarları";
            $data['kilavuz']   = "  <b>Hizmet Ürün Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }



    public function hedef_goruntule( )
    {
		


        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
		if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}			
			
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {



            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hedef($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

  

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hedef($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }



            }

$satis="";
 $satis.=$this->merkezsatis();
 
 for($i=0; $i<=4; $i++){
 $satis.=$this->bayisatis($i); 	 
 }
			$data["satis"]=$satis;
            $data['side_menu'] = "Hizmet Ürün Ayarları";
            $data['kilavuz']   = "  <b>Hizmet Ürün Ayarları</b>";		
			$this->load->view('kota', $data);
		   

        }
    }

function merkezsatis ($n=null){
  $buyil = date("Y");
  $buay = date("m");
  $hedefdisi = 0;
  $masaustu = 0;
  $nova = 0;
  $edonusum = 0;
  
  

  

        $query = $this->db->query("select * from fatura_item where kullanici_id=" . $this->session->userdata('kullanici_id'));
        foreach ($query->result_array() as $row) {
            $tr = $row['baslangic'];
			$tr = explode("-",$tr);
			
			if(($tr[0]==$buyil)and($tr[1]==$buay))
			{

			    $query2 = $this->db->query("select * from hizmet_urun where kullanici_id=" . $this->session->userdata('kullanici_id')." and id =".$row['hizmet_urun_id']);				
	        foreach ($query2->result_array() as $row2) {
      		
			}
				if($row2['urun_hedef_grubu']==0){$hedefdisi++;}
				if($row2['urun_hedef_grubu']==1){$masaustu++;}
				if($row2['urun_hedef_grubu']==2){$nova++;}
				if($row2['urun_hedef_grubu']==3){$edonusum++;}				
			}
			
			
        }
   


$masaustu_yeni_satis=0;
$novahdf=0;
$e_modul_yeni_satis=0;

         $query = $this->db->query("select * from hedefler where kullanici_id=" . $this->session->userdata('kullanici_id')." and yil=".$buyil." and tarih=".$buay." ");
        foreach ($query->result_array() as $row) {
            $masaustu_yeni_satis = $row['masaustu_yeni_satis'];
            $novahdf = $row['nova'];			
            $e_modul_yeni_satis = $row['e_modul_yeni_satis'];			
			
		}
   
   
   
   if($n==null){
	   
  $satis="";  
  if($buay<10){$buayk=substr($buay,1,1);}	
  $satis.="<b>Kayseri Bölge toplam satış rakamları</b>";   
  $satis.="<br>".$buyil." yılı ".$buayk.". ay";
  $satis.="<br>Masaüstü Satış: Toplam Hedef:".$masaustu_yeni_satis." adet, satılan ".$masaustu." Adet satılmıştır <progress value='".$masaustu."' max='".$masaustu_yeni_satis."' style='width:50%; height:20px;'></progress>";
  $satis.="<br>Nova Satış: Toplam Hedef: ".$novahdf." adet, satılan ".$nova ." Adet satılmıştır <progress value='".$nova ."' max='".$novahdf."' style='width:50%; height:20px;'></progress>";
  $satis.="<br>E-Dönüşüm Satış: Toplam Hedef: ".$e_modul_yeni_satis." adet, satılan ".$edonusum ." Adet satılmıştır <progress value='".$edonusum ."' max='".$e_modul_yeni_satis."' style='width:50%; height:20px;'></progress>";
  return $satis;   
	   
   }
   
 else{
	 
	  $satis="";  
  if($buay<10){$buayk=substr($buay,1,1);}	
  $satis.=$buayk."/".$buyil;
  $satis.=" Masaüstü: ".$masaustu."/".$masaustu_yeni_satis;
  $satis.=" Nova:".$nova ."/".$novahdf;
  $satis.=" E-Dönüşüm: ".$edonusum ."/".$e_modul_yeni_satis;
  return $satis;  
	 
 }  
   
   
   

		}
		
		
		


	

function bayisatis ($bayi_id){
	
		   if(($bayi_id<0) and($bayi_id>4)){echo "Hata"; return FALSE;}
   
    $by [0] = "Kayseri"; 
    $by [1] = "Nevşehir";
    $by [2] ="Kırşehir"; 	
    $by [3] = "Yozgat";
    $by [4] = "Aksaray"; 
	
  $buyil = date("Y");
  $buay = date("m");
  $hedefdisi = 0;
  $masaustu = 0;
  $nova = 0;
  $edonusum = 0;
  
  $masaustu_yeni_satis = 0;
  $nova = 0;			
  $e_modul_yeni_satis = 0;	


			
          $query1 = $this->db->query("select * from uyeler where kullanici_id=" . $this->session->userdata('kullanici_id')." and bayi_id =".$bayi_id);
        foreach ($query1->result_array() as $row1) {
 
 
           $query2 = $this->db->query("select * from fatura where kullanici_id=" . $this->session->userdata('kullanici_id')." and personel=".$row1['cari_id']);
        foreach ($query2->result_array() as $row2) {
			
			
 

        $query = $this->db->query("select * from fatura_item where kullanici_id=" . $this->session->userdata('kullanici_id')." and fatura_id=".$row2['id']);
        foreach ($query->result_array() as $row) {
            $tr = $row['baslangic'];
			$tr = explode("-",$tr);
			
			if(($tr[0]==$buyil)and($tr[1]==$buay))
			{

			    $query3 = $this->db->query("select * from hizmet_urun where kullanici_id=" . $this->session->userdata('kullanici_id')." and id =".$row['hizmet_urun_id']);				
	       

      
		   foreach ($query3->result_array() as $row3) {
      		
			
				if($row3['urun_hedef_grubu']==0){$hedefdisi++;}
				if($row3['urun_hedef_grubu']==1){$masaustu++;}
				if($row3['urun_hedef_grubu']==2){$nova++;}
				if($row3['urun_hedef_grubu']==3){$edonusum++;}		
				
			}
		
			
        }
   


		}

		}
		
		}
		
$masaustu_yeni_satis=0;
$novahdf=0;
$e_modul_yeni_satis=0;
         $query = $this->db->query("select * from hedefler where kullanici_id=" . $this->session->userdata('kullanici_id')." and yil=".$buyil." and tarih=".$buay." and bayi_id=".$bayi_id);
       
  if ($query->num_rows() > 0) {	
	   foreach ($query->result_array() as $row) {
            $masaustu_yeni_satis = $row['masaustu_yeni_satis'];
            $novahdf = $row['nova'];			
            $e_modul_yeni_satis = $row['e_modul_yeni_satis'];			
			
		}
   
}

 $satis="";  
   if($buay<10){$buayk=substr($buay,1,1);}	
  $satis.="<br><br><b>".$by[$bayi_id]." Merkez toplam satış rakamları</b>";   
  $satis.="<br>".$buyil." yılı ".$buayk.". ay";
  $satis.="<br>Masaüstü Satış: Toplam Hedef:".$masaustu_yeni_satis." adet, satılan ".$masaustu." Adet satılmıştır <progress value='".$masaustu."' max='".$masaustu_yeni_satis."' style='width:50%; height:20px;'></progress>";
  $satis.="<br>Nova Satış: Toplam Hedef: ".$novahdf." adet, satılan ".$nova ." Adet satılmıştır <progress value='".$nova ."' max='".$novahdf."' style='width:50%; height:20px;'></progress>";
  $satis.="<br>E-Dönüşüm Satış: Toplam Hedef: ".$e_modul_yeni_satis." adet, satılan ".$edonusum ." Adet satılmıştır <progress value='".$edonusum ."' max='".$e_modul_yeni_satis."' style='width:50%; height:20px;'></progress>";
	return $satis;
}


    public function ajax()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM urun_kategori Where kullanici=" . $this->session->userdata('kullanici_id') . " and urun_grubu_kategori=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $kat = $query->result_array();
        } else {
            return false;
        }

        echo '<option value="">KATEGORİ SEÇİNİZ</option>';
        if ($kat): foreach ($kat as $dizi):
        echo '<option value="'.$dizi["id"].'">'.$dizi["adi"].'</option>';


            endforeach;endif;         


                

        }

    }




   public function ur_get()
    {
		

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and kategori=".$_POST["id"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ur = $query->result_array();
        } else {
            return false;
        }
        echo '<option value="">ÜRÜN SEÇİNİZ</option>';
        if ($ur): foreach ($ur as $dizi):
        echo '<option value="'.$dizi["id"].'">'.$dizi["adi"].'</option>';


            endforeach;endif;         


                

        }

    }


 



    public function ajax2()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM uruneslestir Where uruneslestir_kullanici_id=" . $this->session->userdata('kullanici_id') . " and urun_1=".$_POST["id"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $kat = $query->result_array();
        } else {
            return false;
        }

        echo '<option value="">ÜRÜN SEÇİNİZ</option>';
        if ($kat): foreach ($kat as $dizi):

           $sql2   = "SELECT * FROM urun_kategori Where id=" . $dizi["kategori_2"]." and is_old = 0";			
		if($_POST["status"]=="old"){
           $sql2   = "SELECT * FROM urun_kategori Where id=" . $dizi["kategori_2"];			
		}

		

           $query2 = $this->db->query($sql2);
        if ($query2->num_rows() > 0) {
            $kat2 = $query2->result_array();
        } else {
            return false;
        }
        if ($kat2): foreach ($kat2 as $dizi2):
	    $ad=$dizi2["adi"];
		$id=$dizi2["id"];
		
		endforeach;endif; 
		
        echo '<option value="'.$id.'">'.$ad.'</option>';


            endforeach;endif;         


                

        }



    }

    public function ur_get2()
    {
	
		
   $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM uruneslestir_iliski Where uruneslestir_kullanici_id=" . $this->session->userdata('kullanici_id') ." and urun_1=".$_POST["ur1"]." and kategori_2=".$_POST["kat2"]."";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $kat = $query->result_array();
        } else {
            return false;
        }
		
		
	        if ($kat): foreach ($kat as $dizi):
			
			
	 $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi["urun_2"];
           $query2 = $this->db->query($sql2);
        if ($query2->num_rows() > 0) {
            $ur2 = $query2->result_array();
        } else {
            return false;
        }		
        if ($ur2): foreach ($ur2 as $dizi2):
	    $ad=$dizi2["adi"];		
		endforeach;endif; 			
			
			
        echo '<option value="'.$dizi["urun_2"].'">'.$ad.'</option>';
		
		endforeach;endif; 	
		
		
		
	 }	
		
	 

    }



   public function fyt()
    {


        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$_POST["fy"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ur = $query->result_array();
        } else {
            return false;
        }
      
        if ($ur): foreach ($ur as $dizi):
		/*
		if($_POST["od"]==1){echo $dizi["alis_fiyat"];}
		if($_POST["od"]==6){echo $dizi["alis_fiyat_6_tk"];}		
		if($_POST["od"]==9){echo $dizi["alis_fiyat_9_tk"];}		
        */
		
		if($_POST["od"]==1){$tut=$dizi["satis_fiyat"];}
		if($_POST["od"]==6){$tut=$dizi["satis_fiyat_6_tk"];}		
		if($_POST["od"]==9){$tut=$dizi["satis_fiyat_9_tk"];}			
        $oran = $dizi["vergi"];
        echo $prc = $tut / (1 + ($oran/100));  





            endforeach;endif;         


                

        }

    }

  public function vrg()
    {
		

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$_POST["fy"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ur = $query->result_array();
        } else {
            return false;
        }
      
        if ($ur): foreach ($ur as $dizi):
        echo $dizi["vergi"];


            endforeach;endif;         


                

        }

    }
	
	
	
	 public function is_vkn()
    {
		

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$_POST["ur"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ur = $query->result_array();
        } else {
            return false;
        }
      
        if ($ur): foreach ($ur as $dizi):
        echo $dizi["is_vkn_obligatory"];


            endforeach;endif;         


                

        }

    }
	
	
	
	
	
	
   public function cari_urun_getir()
    {
		
		$cari = $_POST["ca"];
		
	          $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 $adi_soyadi_unvan = $dizi3["adi_soyadi_unvan"];
			 endforeach;endif; 

			 

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM fatura Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and cari_id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ft = $query->result_array();
        } else {
            return false;
        }
		
		$bugun = date("Y-m-d");
      
        if ($ft): foreach ($ft as $dizi):

         $sql   = "SELECT * FROM fatura_item Where fatura_id=" . $dizi["id"]." and gecerlilik >=".$bugun." order by id desc";
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
	
		
	        if ($item): foreach ($item as $dizi2):	
			
	         $sqls   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]." and is_upgrade != 0";		
			$querys = $this->db->query($sqls);	
	        if ($querys->num_rows() > 0) {
			$urs = $querys->result_array();	

	        if ($urs): foreach ($urs as $dizi5):				
			 $up_id = $dizi5["is_upgrade"]; 
			 endforeach;endif;  
			 
	         $sqlup   = "SELECT * FROM hizmet_urun Where id=" . $up_id;				 
			 $queryup = $this->db->query($sqlup);
			 if ($queryup->num_rows() > 0) { 
			 $urup = $queryup->result_array();
			 }
	       if ($urup): foreach ($urup as $dizi6):				
			 $up_adi = $dizi6["adi"];
			 endforeach;endif; 			 
	
	
			 
			 
				
          echo $adi_soyadi_unvan."-".$up_adi."-".$up_id."-".$dizi2["gecerlilik"];
		  return FALSE;
        }
		     endforeach;endif;  
			 
			             endforeach;endif;   
						 
					 
			
			

	        if ($ft): foreach ($ft as $dizi):

         $sql   = "SELECT * FROM fatura_item Where fatura_id=" . $dizi["id"]." and gecerlilik >=".$bugun." order by id desc";
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
		
	        if ($item): foreach ($item as $dizi2):
			
	         $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]." and urun_grubu = 1";		
	$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			$ur = $query2->result_array();	

	        if ($ur): foreach ($ur as $dizi3):				
			 $ad = $dizi3["adi"];
			 endforeach;endif;  
				
          echo $adi_soyadi_unvan."-".$ad."-".$dizi2["hizmet_urun_id"]."-".$dizi2["gecerlilik"];
		  return FALSE;
        }
	            endforeach;endif;      	

            endforeach;endif;         


                

        }

    }

   public function cari_bilgi_getir()
    {
		
		$cari = $_POST["ca"];
		
	          $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	

		
	        if ($cr): foreach ($cr as $dizi3):				
			 echo $dizi3["adi_soyadi_unvan"]."-".$dizi3["yetkili_kullanici"]."-".$dizi3["vergi_dairesi"]."-".$dizi3["vergi"]
			 ."-".$dizi3["tc"]."-".$dizi3["eposta"]."-".$dizi3["cep_tel"]."-".$dizi3["tel"]."-".$dizi3["fax"]
			 ."-".$dizi3["il"]."-".$dizi3["ilce"]."-".$dizi3["adres"]."-".$dizi3["faaliyet_kodu"]."-".$dizi3["faaliyet_adi"]."-".$dizi3["musteri_no"];
			 endforeach;endif; 
			 


    }

   public function cari_tum_urun_getir()
    {
		
		
		$cari = $_POST["ca"];

		echo "<b>Tüm Ürünler: </b><br><br>";		
	    $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 $adi_soyadi_unvan = $dizi3["adi_soyadi_unvan"];
			 endforeach;endif; 

			 

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM fatura Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and cari_id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ft = $query->result_array();
        } else {
            return false;
        }
		
		$bugun = date("Y-m-d");
		
		$n = 0;
		$items [] = "";
		$arr [] = "";
		$arr2 [] = "";
		$ed [] = "";
	    $s = 0;    if ($ft): foreach ($ft as $dizi):	
         $sql   = "SELECT id,fatura_id,hizmet_urun_id,adet,baslangic,gecerlilik FROM fatura_item Where fatura_id=" . $dizi["id"];
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
	  
		

	        if ($item): foreach ($item as $dizi2):	
			
	         $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]."";		
			$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			$ur = $query2->result_array();	
		  }
			 
			 
			 
			 
			 
	        if ($ur): foreach ($ur as $dizi3):				
			 $ad = $dizi3["adi"];
			 $id = $dizi3["id"];
			 $kategori = $dizi3["kategori"];			 
			 endforeach;endif; 
			 $sira = $n + 1;
			 
			   if(!in_array($ad, $arr)){
				  //ürün yoksa ekle say
				  array_push($arr,$ad);
         	     
			   } else{ 

			   }
			   
			   
		   if(!in_array($id, $arr2)){
				  //ürün yoksa ekle say
				  array_push($arr2,$id);
         	     
			   } else{ 

			   }			   
				  
			$tot = $this->session->userdata($ad."total") + $dizi2["adet"];
            $this->session->set_userdata($ad."total", $tot);
            $this->session->userdata($ad."total");
			
			// echo $sira."<b>-</b> ".$items [$n] = $ad.": ".$dizi2["gecerlilik"]." - ".$dizi2["adet"]." adet <br>";
			 
		     $n=$n+1;      


			if($kategori==10){
		
			$ed[$s] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";	
			$s = $s+1;	
			}

			 endforeach;endif; 
			
		
		
		            endforeach;endif; 
                    
                    $ilave = 0;
					$say=count($arr);
					$don=$say-1;
					for($i=1;$i<=$don;$i++){
					$yy=1;	
	        $sql3   = "SELECT * FROM hizmet_urun Where id=" . $arr2[$i];		
			$query3 = $this->db->query($sql3);	
	        if ($query3->num_rows() > 0) {
			
			foreach ($query3->result_array() as $row) {			
                $kt=$row['kategori'];	
                $is_tr=$row['is_transformation'];				
			}		


	        $sql4   = "SELECT * FROM urun_kategori Where id=" . $kt;		
			$query4 = $this->db->query($sql4);	
	        if ($query4->num_rows() > 0) {
			
			foreach ($query4->result_array() as $row) {			
                $takip_turu=$row['takip_turu'];				
			}

}

			
			}	


			 if($takip_turu==2){
				 
				 
		        $sql5   = "SELECT id,hizmet_urun_id,gecerlilik FROM fatura_item Where hizmet_urun_id=".$arr2[$i];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $gec=$row['gecerlilik'];				
			}

}					

				if($kt==10) {}	else{

						echo $arr[$i]." ".$gec." tarihine kadar geçerli<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);				
				}
	

			
			}			 
				 
				else{
					
							if($kt==10) {}	else{
				
					if($kt==9){$ilave = $ilave + $this->session->userdata($arr[$i]."total"); }
					echo $arr[$i]." ".$this->session->userdata($arr[$i]."total")." adet<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);	
				}	
				} 
			
						
						

						
					}
      
      

        $say = count($ed);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $ed[$n];
		}
                

        }
   

		echo "<br><b>Ana Ürün: </b><br><br>";
		$ana = $this->cari_urun_getir2();
		$parc = explode("-",$ana);
		echo "Adı : ".$parc[0]."<br>";
		echo "Ürün : ".$parc[1]."<br>";	
		echo "Tarih : ".$parc[3]."-".$parc[4]."-".$parc[5]."<br>";	
		

		
		    $sql5   = "SELECT * FROM hizmet_urun Where add_user_product=".$parc[2];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $adi=$row['adi'];
                $id=$row['id'];				
			}

}		
		if($ilave!=0){
		echo "İlave Kullanıcı :".$adi." ".$ilave." adet";
}		
		echo "</b><br><br>";		
        

		echo "<br><b>E-Dönüşüm: </b><br><br>";

        $say = count($ed);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $ed[$n];
		}

 
   	   
		
		

    }
	
	
	
	

   public function cari_urun_getir2()
    {
		
		$cari = $_POST["ca"];
		
	          $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 $adi_soyadi_unvan = $dizi3["adi_soyadi_unvan"];
			 endforeach;endif; 

			 

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM fatura Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and cari_id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ft = $query->result_array();
        } else {
            return false;
        }
		
		$bugun = date("Y-m-d");
      
        if ($ft): foreach ($ft as $dizi):

         $sql   = "SELECT * FROM fatura_item Where fatura_id=" . $dizi["id"]." and gecerlilik >=".$bugun." order by id desc";
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
	
		
	        if ($item): foreach ($item as $dizi2):	
			
	         $sqls   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]." and is_upgrade != 0";		
			$querys = $this->db->query($sqls);	
	        if ($querys->num_rows() > 0) {
			$urs = $querys->result_array();	

	        if ($urs): foreach ($urs as $dizi5):				
			 $up_id = $dizi5["is_upgrade"]; 
			 endforeach;endif;  
			 
	         $sqlup   = "SELECT * FROM hizmet_urun Where id=" . $up_id;				 
			 $queryup = $this->db->query($sqlup);
			 if ($queryup->num_rows() > 0) { 
			 $urup = $queryup->result_array();
			 }
	       if ($urup): foreach ($urup as $dizi6):				
			 $up_adi = $dizi6["adi"];
			 endforeach;endif; 			 
	
	
			 
	          return $adi_soyadi_unvan."-".$up_adi."-".$up_id."-".$dizi2["gecerlilik"]."-".$dizi2["id"];				
	 
				
          //return $adi_soyadi_unvan."-".$up_adi."-".$dizi2["gecerlilik"];
		  return FALSE;
        }
		     endforeach;endif;  
			 
			             endforeach;endif;   
						 
					 
			
			

	        if ($ft): foreach ($ft as $dizi):

         $sql   = "SELECT * FROM fatura_item Where fatura_id=" . $dizi["id"]." and gecerlilik >=".$bugun." order by id desc";
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
		
	        if ($item): foreach ($item as $dizi2):
			
	         $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]." and urun_grubu = 1";		
	$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			$ur = $query2->result_array();	

	        if ($ur): foreach ($ur as $dizi3):				
			 $ad = $dizi3["adi"];
			 endforeach;endif;  
				
        //  return $adi_soyadi_unvan."-".$ad."-".$dizi2["gecerlilik"];
		  return $adi_soyadi_unvan."-".$ad."-".$dizi2["hizmet_urun_id"]."-".$dizi2["gecerlilik"];	
		  return FALSE;
        }
	            endforeach;endif;      	

            endforeach;endif;         

              

        }

    }	
	
	
   public function cari_tum_urun_getir2()
    {
		$cari = $_POST["ca"];

		echo "<b>Tüm Ürünler: </b><br><br>";		
	    $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 $adi_soyadi_unvan = $dizi3["adi_soyadi_unvan"];
			 endforeach;endif; 

			 

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM fatura Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and cari_id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ft = $query->result_array();
        } else {
            return false;
        }
		
		$bugun = date("Y-m-d");
		
		$n = 0;
		$items [] = "";
		$arr [] = "";
		$arr2 [] = "";
		$ed = array();
		$edid = array();	

		$dri = array(); $dr=0;
		$ekon = array(); $rk=0;
		$ygd = array(); $yg=0;		
		
		$items_id = array(); 	
		$uruns_id = array(); 
		
	    $s = 0;    if ($ft): foreach ($ft as $dizi):	
         $sql   = "SELECT id,fatura_id,hizmet_urun_id,adet,baslangic,gecerlilik FROM fatura_item Where fatura_id=" . $dizi["id"];
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
	  
		

	        if ($item): foreach ($item as $dizi2):	
			
	         $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]."";		
			$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			$ur = $query2->result_array();	
		  }
			 
			 
			 
			 
			 
	        if ($ur): foreach ($ur as $dizi3):				
			 $ad = $dizi3["adi"];
			 $id = $dizi3["id"];
			 $kategori = $dizi3["kategori"];	
			 $is_upgrade = $dizi3["is_upgrade"];			 
			 endforeach;endif; 
			 $sira = $n + 1;
			 
			   if(!in_array($ad, $arr)){
				  //ürün yoksa ekle say
				  array_push($arr,$ad);
         	     
			   } else{ 

			   }
			   
			   
		   if(!in_array($id, $arr2)){
				  //ürün yoksa ekle say
				  array_push($arr2,$id);
         	     
			   } else{ 

			   }			   
				  
			$tot = $this->session->userdata($ad."total") + $dizi2["adet"];
            $this->session->set_userdata($ad."total", $tot);
            $this->session->userdata($ad."total");
			
			// echo $sira."<b>-</b> ".$items [$n] = $ad.": ".$dizi2["gecerlilik"]." - ".$dizi2["adet"]." adet <br>";
			 
		     $n=$n+1;      


			if($kategori==10){
		
			$ed[$s] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";	
			$edid[$s] = $dizi2["id"];				
			$s = $s+1;	
			}
					
			if($kategori==8){
		
			$dri[$dr] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";				
			$dr = $dr+1;	
			}			
			if($kategori==15){
		
			$ekon[$rk] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";				
			$rk = $rk+1;	
			}	

			if(($kategori==4)or($kategori==14)){
		
			if($is_upgrade!=0){
				
		         $sqlurun   = "SELECT * FROM hizmet_urun Where id=" . $is_upgrade ."";					
			$queryurun = $this->db->query($sqlurun);	
	        if ($queryurun->num_rows() > 0) {
			$urunadi = $queryurun->result_array();	
		  }					
				
	        if ($urunadi): foreach ($urunadi as $dizi7):				
			 $ad = $dizi7["adi"];	
			 $id = $dizi7["id"];			 
			 endforeach;endif;				
				
			}		
		
			$ygd[$yg] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";	
			$items_id[$yg] = $dizi2["id"];	
			$uruns_id[$yg] = $dizi2["hizmet_urun_id"];				
			$yg = $yg+1;	
			}	

			 endforeach;endif; 
			
		
		
		            endforeach;endif; 
                    
                    $ilave = 0;
					$say=count($arr);
					$don=$say-1;
					for($i=1;$i<=$don;$i++){
					$yy=1;	
	        $sql3   = "SELECT * FROM hizmet_urun Where id=" . $arr2[$i];		
			$query3 = $this->db->query($sql3);	
	        if ($query3->num_rows() > 0) {
			
			foreach ($query3->result_array() as $row) {			
                $kt=$row['kategori'];	
                $is_tr=$row['is_transformation'];				
			}		


	        $sql4   = "SELECT * FROM urun_kategori Where id=" . $kt;		
			$query4 = $this->db->query($sql4);	
	        if ($query4->num_rows() > 0) {
			
			foreach ($query4->result_array() as $row) {			
                $takip_turu=$row['takip_turu'];				
			}

}

			
			}	


			 if($takip_turu==2){
				 
				 
		        $sql5   = "SELECT id,hizmet_urun_id,gecerlilik FROM fatura_item Where hizmet_urun_id=".$arr2[$i];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $gec=$row['gecerlilik'];				
			}

}					

				if(($kt==8)or($kt==10)or($kt==15)or($kt==4)or($kt==14)) {}	else{

						echo $arr[$i]." ".$gec." tarihine kadar geçerli<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);				
				}
	

			
			}			 
				 
				else{
					
				if(($kt==8)or($kt==10)or($kt==15)or($kt==4)or($kt==14)) {}	else{
				
					if($kt==9){$ilave = $ilave + $this->session->userdata($arr[$i]."total"); }
					echo $arr[$i]." ".$this->session->userdata($arr[$i]."total")." adet<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);	
				}	
				} 
			
						
						

						
					}
      
      

        $say = count($ed);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $ed[$n];
		}
            $say = count($dri);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $dri[$n];			
		}
        $say = count($ekon);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $ekon[$n];			
		}
		

		
	        $say = count($ygd);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			echo $ygd[$n];			
		}             

        }
   

		echo "<br><b>Ana Ürün: </b><br><br>";
		$ana = $this->cari_urun_getir2();
		 $parc = explode("-",$ana);

if($say>0){

		echo "Adı : ".$adi_soyadi_unvan."<br>";
		echo "Ürün : ".$ygd[$don];	


		
		    $sql5   = "SELECT * FROM hizmet_urun Where add_user_product=".$parc[2];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $adi=$row['adi'];
            //    $id=$row['id'];				
			}

}		
		if($ilave!=0){
		echo "İlave Kullanıcı :".$ilave." adet";
}	

		echo '<br><div id="gunc">
		<form action="'.base_url().'yonetim/ygdfatura" method="POST">
			<input type="hidden" value="ygd" name="tur" id="tur" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$cari.'" name="cariid" id="cariid" style="width: 10%" class="material-container__input" >
		<input type="hidden" value="'.$items_id[$don].'" name="ygditemid" id="ygditemid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$id.'" name="ygdstokid" id="ygdstokid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$ad.'" name="ygdadi" id="ygdadi" style="width: 10%" class="material-container__input" >			
		<input type="submit" value="Güncelle" id="guncelle" style="width: 10%" class="material-container__input"  onclick=""></form></div></b><br><br>';		
        
}

		echo "<br><b>E-Dönüşüm: </b><br><br>";

        $this->edonusum_getir($cari);


   
    }
	
	
		  public function edonusum_getir($cari)
    {
		
		
	        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {	
		
		
		
				$edo = array();
	
			    $sql   = "SELECT * FROM ek_kullanici_takip Where cari_id=".$cari;		
			$query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
			
			$n=0;

			foreach ($query->result_array() as $row) {	
                $edo[$n]["edon_id"] =$row['ek_kullanici_id'];			
                $edo[$n]["item_id"] =$row['item_id'];
                $edo[$n]["urun_id"]=$row['urun_id'];
                $edo[$n]["ek_vkn"]=$row['ek_vkn'];	


		    $sql2   = "SELECT * FROM hizmet_urun Where id=".$row['urun_id'];		
			$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			
			foreach ($query2->result_array() as $row2) {			
                $edo[$n]["urun_adi"]=$row2['adi'];	
                $edo[$n]["is_transformation"]=$row2['is_transformation'];					
			}

}

		    $sql3   = "SELECT * FROM fatura_item Where id=".$row['item_id'];		
			$query3 = $this->db->query($sql3);	
	        if ($query3->num_rows() > 0) {
			
			foreach ($query3->result_array() as $row3) {			
                $edo[$n]["gecerlilik"]=$row3['gecerlilik'];		
			}

}
				
			   
			 $n++;  
			}

}


	echo '<br><div id="gunc2">
		<form action="'.base_url().'yonetim/edonusumfatura" method="POST">
			<input type="hidden" value="edo" name="tur" id="tur" style="width: 10%" class="material-container__input" >	
					<input type="hidden" value="'.$cari.'" name="cariid" id="cariid" style="width: 10%" class="material-container__input" >';
	
	$say = count($edo);
	$don = $say -1;
	$ana = array();
	if($say>0){
	for($i=0; $i<=$don; $i++){
		
		if($edo[$i]["is_transformation"]==0){
		//echo '<input  type="checkbox" checked onclick="return false;" id="ed" name="ed" value="'.$i.'">';		
		//$ana [$i] = $i;		
			echo '<input type="hidden" value="'.$edo[$i]["urun_id"].'" name="ana[]" id="ana" style="width: 10%" class="material-container__input" >';	
		}
		else{
		echo '<input  type="checkbox" id="ed" name="ed" value="'.$i.'">';
		}
		
		echo "Ürün : ".$edo[$i]["urun_adi"]." Vkn: ".$edo[$i]["ek_vkn"]." Geçerlilik: ".$edo[$i]["gecerlilik"]."<br>";	
		
		echo '

		<input type="hidden" value="'.$edo[$i]["edon_id"].'" name="edon_id[]" id="edon_id" style="width: 10%" class="material-container__input" >
		<input type="hidden" value="'.$edo[$i]["item_id"].'" name="ygditemid[]" id="ygditemid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$edo[$i]["urun_id"].'" name="ygdstokid[]" id="ygdstokid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$edo[$i]["urun_adi"].'" name="ygdadi[]" id="ygdadi" style="width: 10%" class="material-container__input" >		
		<input type="hidden" value="'.$edo[$i]["ek_vkn"].'" name="ygvkn[]" id="ygvkn" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$edo[$i]["is_transformation"].'" name="is_transformation[]" id="is_transformation" style="width: 10%" class="material-container__input" >			
		
		';			
		

	}
		
			
	echo '<input type="submit" value="Güncelle" id="guncelle" style="width: 10%" class="material-container__input"  onclick=""></form></div><br>';
		}
	
	}
	
		}
	
	  public function ana_urun()
    {
		$cari = $_POST["ca"];

		 "<b>Tüm Ürünler: </b><br><br>";		
	    $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 $adi_soyadi_unvan = $dizi3["adi_soyadi_unvan"];
			 endforeach;endif; 

			 

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

           $sql   = "SELECT * FROM fatura Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and cari_id=".$cari;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ft = $query->result_array();
        } else {
            return false;
        }
		
		$bugun = date("Y-m-d");
		
		$n = 0;
		$items [] = "";
		$arr [] = "";
		$arr2 [] = "";
		$ed = array();
		$edid = array();	

		$dri = array(); $dr=0;
		$ekon = array(); $rk=0;
		$ygd = array(); $yg=0;		
		$nova = array(); $nv=0;		
		$items_id = array(); 	
		$uruns_id = array(); 
		$trh = array(); 		
		$ads = array(); 		
	    $s = 0;    if ($ft): foreach ($ft as $dizi):	
         $sql   = "SELECT id,fatura_id,hizmet_urun_id,adet,baslangic,gecerlilik FROM fatura_item Where fatura_id=" . $dizi["id"];
         $query = $this->db->query($sql);	
	        if ($query->num_rows() > 0) {
            $item = $query->result_array();
        } else {
            return false;
        }
		
	  
		

	        if ($item): foreach ($item as $dizi2):	
			
	         $sql2   = "SELECT * FROM hizmet_urun Where id=" . $dizi2["hizmet_urun_id"]."";		
			$query2 = $this->db->query($sql2);	
	        if ($query2->num_rows() > 0) {
			$ur = $query2->result_array();	
		  }
			 

			 
			 
			 
	        if ($ur): foreach ($ur as $dizi3):				
			  $ad = $dizi3["adi"];
			  $id = $dizi3["id"];
			 $kategori = $dizi3["kategori"];	
			 $is_upgrade = $dizi3["is_upgrade"];			 
			 endforeach;endif; 
			 $sira = $n + 1;
			
			   if(!in_array($ad, $arr)){
				  //ürün yoksa ekle say
				  array_push($arr,$ad);
         	     
			   } else{ 

			   }
			   
			   
		   if(!in_array($id, $arr2)){
				  //ürün yoksa ekle say
				  array_push($arr2,$id);
         	     
			   } else{ 

			   }			   
				  
			$tot = $this->session->userdata($ad."total") + $dizi2["adet"];
            $this->session->set_userdata($ad."total", $tot);
            $this->session->userdata($ad."total");
			
			// echo $sira."<b>-</b> ".$items [$n] = $ad.": ".$dizi2["gecerlilik"]." - ".$dizi2["adet"]." adet <br>";
			 
		     $n=$n+1;      


			if($kategori==10){
		
			$ed[$s] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";	
			$edid[$s] = $dizi2["id"];				
			$s = $s+1;	
			}
					
			if($kategori==8){
		
			$dri[$dr] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";				
			$dr = $dr+1;	
			}			
			if($kategori==15){
		
			$ekon[$rk] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";				
			$rk = $rk+1;	
			}	
			
				

			if(($kategori==4)or($kategori==14)or($kategori==3)){
		
			if($is_upgrade!=0){
				
		         $sqlurun   = "SELECT * FROM hizmet_urun Where id=" . $is_upgrade ."";					
			$queryurun = $this->db->query($sqlurun);	
	        if ($queryurun->num_rows() > 0) {
			$urunadi = $queryurun->result_array();	
		  }					
				
	        if ($urunadi): foreach ($urunadi as $dizi7):				
			 $ad = $dizi7["adi"];	
			 $id = $dizi7["id"];			 
			 endforeach;endif;				
				
			}		
			
			
			if($kategori==3){
				
		         $sqlurun   = "SELECT * FROM hizmet_urun Where kategori=" . $kategori ."";					
			$queryurun = $this->db->query($sqlurun);	
	        if ($queryurun->num_rows() > 0) {
			$urunadi = $queryurun->result_array();	
		  }					
				
	        if ($urunadi): foreach ($urunadi as $dizi7):				
			 $ad = $dizi7["adi"];	
			 $id = $dizi7["id"];			 
			 endforeach;endif;				
				
			}			
			
			
		
			$ygd[$yg] = $ad." ".$dizi2["gecerlilik"]." tarihine kadar geçerli<br>";	
			$items_id[$yg] = $dizi2["id"];	
			$uruns_id[$yg] = $dizi2["hizmet_urun_id"];	
            $ads[$yg] = $ad;			
            $trh[$yg] = $dizi2["gecerlilik"];			
			$yg = $yg+1;	
			}	

			 endforeach;endif; 

		
		            endforeach;endif; 
                  
                    $ilave = 0;
					$say=count($arr);
					$don=$say-1;
					for($i=1;$i<=$don;$i++){
					$yy=1;	
	        $sql3   = "SELECT * FROM hizmet_urun Where id=" . $arr2[$i];		
			$query3 = $this->db->query($sql3);	
	        if ($query3->num_rows() > 0) {
			
			foreach ($query3->result_array() as $row) {			
                $kt=$row['kategori'];	
                $is_tr=$row['is_transformation'];				
			}		


	        $sql4   = "SELECT * FROM urun_kategori Where id=" . $kt;		
			$query4 = $this->db->query($sql4);	
	        if ($query4->num_rows() > 0) {
			
			foreach ($query4->result_array() as $row) {			
                $takip_turu=$row['takip_turu'];				
			}

}

			
			}	


			 if($takip_turu==2){
				 
				 
		        $sql5   = "SELECT id,hizmet_urun_id,gecerlilik FROM fatura_item Where hizmet_urun_id=".$arr2[$i];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $gec=$row['gecerlilik'];				
			}

}					

				if(($kt==8)or($kt==10)or($kt==15)or($kt==4)or($kt==14)or($kategori==3)) {}	else{

						 $arr[$i]." ".$gec." tarihine kadar geçerli<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);				
				}
	

			
			}			 
				 
				else{
					
				if(($kt==8)or($kt==10)or($kt==15)or($kt==4)or($kt==14)or($kategori==3)) {}	else{
				
					if($kt==9){$ilave = $ilave + $this->session->userdata($arr[$i]."total"); }
					 $arr[$i]." ".$this->session->userdata($arr[$i]."total")." adet<br>";	
					$this->session->set_userdata($arr[$i]."total", 0);	
				}	
				} 
			
						
						

						
					}
      
      

        $say = count($ed);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			 $ed[$n];
		}
            $say = count($dri);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			 $dri[$n];			
		}
        $say = count($ekon);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			 $ekon[$n];			
		}
		

		
	        $say = count($ygd);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
			 $ygd[$n];			
		}             

        }
   

		 "<br><b>Ana Ürün: </b><br><br>";
		$ana = $this->cari_urun_getir2();
		 $parc = explode("-",$ana);

if($say>0){

		 "Adı : ".$adi_soyadi_unvan."<br>";
		 "Ürün : ".$ygd[$don];	

          //echo $adi_soyadi_unvan."-".$ads[$don]."-".$id."-".$trh[$don];
		  echo $adi_soyadi_unvan."-".$ads[$don]."-".$uruns_id[$don]."-".$trh[$don];
		
		    $sql5   = "SELECT * FROM hizmet_urun Where add_user_product=".$parc[2];		
			$query5 = $this->db->query($sql5);	
	        if ($query5->num_rows() > 0) {
			
			foreach ($query5->result_array() as $row) {			
                $adi=$row['adi'];
            //    $id=$row['id'];				
			}

}		
		if($ilave!=0){
		 "İlave Kullanıcı :".$ilave." adet";
}	

		 '<br><div id="gunc">
		<form action="'.base_url().'yonetim/ygdfatura" method="POST">
			<input type="hidden" value="ygd" name="tur" id="tur" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$cari.'" name="cariid" id="cariid" style="width: 10%" class="material-container__input" >
		<input type="hidden" value="'.$items_id[$don].'" name="ygditemid" id="ygditemid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$id.'" name="ygdstokid" id="ygdstokid" style="width: 10%" class="material-container__input" >	
		<input type="hidden" value="'.$ad.'" name="ygdadi" id="ygdadi" style="width: 10%" class="material-container__input" >			
		<input type="submit" value="Güncelle" id="guncelle" style="width: 10%" class="material-container__input"  onclick=""></form></div></b><br><br>';		
        
}

		 "<br><b>E-Dönüşüm: </b><br><br>";

        $say = count($ed);
		$don=$say-1;
		for($n=0; $n<=$don; $n++){
	         $edid[$n];		
			 $ed[$n];

		}
		
		if($say>0){
		 '<br><div id="gunc2"><input type="submit" value="Güncelle" id="guncelle" style="width: 10%" class="material-container__input"  ></div></b><br><br>';				
		}


   
    }
	
	
	
	
	
	
	
	public function ygdfatura()
    {
			      $this->load->model('admin_model');
		
			

			

		    $data["cari_ad"]  = $this->admin_model->cari_ad($_POST["cariid"]);
			$data["cari_id"]  = $_POST["cariid"];			
			$data["ygditemid"]  = $_POST["ygditemid"];	
			$data["ygdstokid"]  = $_POST["ygdstokid"];	
			$data["ygdadi"]  = $_POST["ygdadi"];			
			$data["fat_turu"] = "Satış";
		
			

            if ($data["fat_turu"] == "Satış") {
                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["fat_turu"] == "Alış") {
                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }
			
		 
		

		
	  $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenleygd($_POST["ygditemid"], $this->session->userdata('kullanici_id'));		

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $data["ek_vkn"][$n] = $this->admin_model->ekvkn_getir($dizi["id"]);					
					
                    $n                   = $n + 1;
					
					
					
                endforeach;endif;	
			

			

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));


            $data["uye_turu"] = $this->session->userdata('uye_turu');

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('ygdfatura', (array) $output);
	
}





 public function fatura_alygd()
    {
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
			
			
	    // kişi bilgileri	

	   		
			
	        $ad = htmlentities(strip_tags(trim($this->input->post('ad', true))));
	        $yet = htmlentities(strip_tags(trim($this->input->post('yet', true))));
	        $vd = htmlentities(strip_tags(trim($this->input->post('vd', true))));			
	        $vn = htmlentities(strip_tags(trim($this->input->post('vn', true))));
	        $tc = htmlentities(strip_tags(trim($this->input->post('tc', true))));
	        $ep = htmlentities(strip_tags(trim($this->input->post('ep', true))));
	        $cp = htmlentities(strip_tags(trim($this->input->post('cp', true))));			
	        $tl = htmlentities(strip_tags(trim($this->input->post('tl', true))));
	        $fx = htmlentities(strip_tags(trim($this->input->post('fx', true))));
	        $ilc = htmlentities(strip_tags(trim($this->input->post('ilc', true))));
	        $il = htmlentities(strip_tags(trim($this->input->post('il', true))));			
	        $adr = htmlentities(strip_tags(trim($this->input->post('adr', true))));
	        $fkd = htmlentities(strip_tags(trim($this->input->post('fkd', true))));			
	        $fad = htmlentities(strip_tags(trim($this->input->post('fad', true))));
	        $mn = htmlentities(strip_tags(trim($this->input->post('mn', true))));			

			if($this->input->post('mus', true)==""){
            $mus_kayit = $this->admin_model->mus_kayit($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad, $mn);
            $mus_kayit_id    = $mus_kayit;
			
			}
            else{
            $mus_guncelle = $this->admin_model->mus_guncelle($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad ,$mn, $this->input->post('mus', true));			
			}


			
		// kişi bilgileri			
			
			
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);
			
			if($mus==""){$mus=$mus_kayit_id;}

          /*  $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);
			*/
			$per = $this->session->userdata('cari_id');

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

     

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];
			
	
			$va_ta = $this->input->post('duz_ta', true);
            //$va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];



            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);
			
			
            $ygditemid = $this->input->post('ygditemid', true);
            $ygditemid = trim($ygditemid);
            $ygditemid = strip_tags($ygditemid);
            $ygditemid = htmlentities($ygditemid);			

            $fat_kayit = $this->admin_model->fat_kayitygd($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $this->session->userdata('cari_id'));
            $fat_id    = $fat_kayit;


            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "1";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

                $islem_kayit = $this->admin_model->islem_kayit_tahsilat_odeme("3", "Tahsilat-Ödeme", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $this->session->userdata('kullanici_id'));

            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);
				


                 $fat_item_kayit = $this->admin_model->fat_item_kayit_tarihliygd($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu,$duz_ta,$ygditemid, $this->session->userdata('kullanici_id'));


                $ekvkn[$i] = $this->input->post('ekvkn_' . $i, true);
                $ekvkn[$i] = trim($ekvkn[$i]);
                $ekvkn[$i] = strip_tags($ekvkn[$i]);
                $ekvkn[$i] = htmlentities($ekvkn[$i]);
				
				if($ekvkn[$i]!=""){
				$ekvkn_kayit = $this->admin_model->ekvkn_kayit($fat_id,$mus,$fat_item_kayit,$item[$i], $ekvkn[$i]);					
				}
				




            }

            /*       $this->load->library('messages');
            $this->messages->config2('Yonetim/fatura');
            return FALSE;
             */

            echo '{"success":true}';

        }

    }










 public function fatura_aledonusum()
    {
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
			
			
	    // kişi bilgileri	

	   		
			
	        $ad = htmlentities(strip_tags(trim($this->input->post('ad', true))));
	        $yet = htmlentities(strip_tags(trim($this->input->post('yet', true))));
	        $vd = htmlentities(strip_tags(trim($this->input->post('vd', true))));			
	        $vn = htmlentities(strip_tags(trim($this->input->post('vn', true))));
	        $tc = htmlentities(strip_tags(trim($this->input->post('tc', true))));
	        $ep = htmlentities(strip_tags(trim($this->input->post('ep', true))));
	        $cp = htmlentities(strip_tags(trim($this->input->post('cp', true))));			
	        $tl = htmlentities(strip_tags(trim($this->input->post('tl', true))));
	        $fx = htmlentities(strip_tags(trim($this->input->post('fx', true))));
	        $ilc = htmlentities(strip_tags(trim($this->input->post('ilc', true))));
	        $il = htmlentities(strip_tags(trim($this->input->post('il', true))));			
	        $adr = htmlentities(strip_tags(trim($this->input->post('adr', true))));
	        $fkd = htmlentities(strip_tags(trim($this->input->post('fkd', true))));			
	        $fad = htmlentities(strip_tags(trim($this->input->post('fad', true))));
	        $mn = htmlentities(strip_tags(trim($this->input->post('mn', true))));			

			if($this->input->post('mus', true)==""){
            $mus_kayit = $this->admin_model->mus_kayit($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad, $mn);
            $mus_kayit_id    = $mus_kayit;
			
			}
            else{
            $mus_guncelle = $this->admin_model->mus_guncelle($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad ,$mn, $this->input->post('mus', true));			
			}


			
		// kişi bilgileri			
			
			
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);
			
			if($mus==""){$mus=$mus_kayit_id;}

          /*  $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);
			*/
			$per = $this->session->userdata('cari_id');

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

     

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];
			
	
			$va_ta = $this->input->post('duz_ta', true);
            //$va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];



            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);
			
			
		

            $fat_kayit = $this->admin_model->fat_kayitygd($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $this->session->userdata('cari_id'));
            $fat_id    = $fat_kayit;


            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "1";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

                $islem_kayit = $this->admin_model->islem_kayit_tahsilat_odeme("3", "Tahsilat-Ödeme", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $this->session->userdata('kullanici_id'));

            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);


                $edon_id_[$i] = $this->input->post('edon_id_' . $i, true);				
                $edon_id_[$i] = trim($edon_id_[$i]);
                $edon_id_[$i] = strip_tags($edon_id_[$i]);
                $edon_id_[$i] = htmlentities($edon_id_[$i]);


                $ygditemid[$i] = $this->input->post('ygditemid_' . $i, true);				
                $ygditemid[$i] = trim($ygditemid[$i]);
                $ygditemid[$i] = strip_tags($ygditemid[$i]);
                $ygditemid[$i] = htmlentities($ygditemid[$i]);	

                 $fat_item_kayit = $this->admin_model->fat_item_kayit_tarihliygd($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu,$duz_ta,$ygditemid[$i], $this->session->userdata('kullanici_id'));


                $ekvkn[$i] = $this->input->post('ekvkn_' . $i, true);
                $ekvkn[$i] = trim($ekvkn[$i]);
                $ekvkn[$i] = strip_tags($ekvkn[$i]);
                $ekvkn[$i] = htmlentities($ekvkn[$i]);
				
			/*	if($ekvkn[$i]!=""){
				$ekvkn_kayit = $this->admin_model->ekvkn_kayit($fat_id,$mus,$fat_item_kayit,$item[$i], $ekvkn[$i]);					
				}*/
				
				
	



            }

            /*       $this->load->library('messages');
            $this->messages->config2('Yonetim/fatura');
            return FALSE;
             */

            echo '{"success":true}';

        }

    }



















	public function edonusumfatura()
    {
		
	        $online = $this->session->userdata('adminonline');
        if (!empty($online)) {	
		
		
		
			$this->load->model('admin_model');
				
			$data["edon_id"]  = $_POST["edon_id"];	
			$data["cari_id"]  = $_POST["cariid"];			
			$data["ygditemid"]  = $_POST["ygditemid"];	
			$data["ygdstokid"]  = $_POST["ygdstokid"];	
			$data["ygdadi"]  = $_POST["ygdadi"];	
			$data["ygvkn"]  = $_POST["ygvkn"];
			$data["is_transformation"]  = $_POST["is_transformation"];
			$data["ana"]  = $_POST["ana"];
			$data["fat_turu"]  = $_POST["tur"];

		    $data["cari_ad"]  = $this->admin_model->cari_ad($data["cari_id"]);		

            if ($data["fat_turu"] == "Satış") {
                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["fat_turu"] == "Alış") {
                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }
			
		 
	$say = count($data["ygditemid"]);
	$don = $say -1;
	$ana = array();
	if($say>0){
	for($i=0; $i<=$don; $i++){
		
		
$data["fatura_item_getir_duzenle"][$i] = $this->admin_model->fatura_item_getir_duzenleygd($_POST["ygditemid"][$i], $this->session->userdata('kullanici_id'));	


	}

		 /*	print_r($data["fatura_item_getir_duzenle"]);
			return FALSE;

           $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $data["ek_vkn"][$n] = $this->admin_model->ekvkn_getir($dizi["id"]);					
					
                    $n                   = $n + 1;
					
					
					
                endforeach;endif;	
			

			$n = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
			
			print_r($dizi[0]["fatura_id"]);
		
			
			
			$n++;  endforeach;endif;	
			
	return FALSE;*/
	
	
	
            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));


            $data["uye_turu"] = $this->session->userdata('uye_turu');

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('edonusumfatura', (array) $output);
	
}


}

}



	
	public function ygdfatura2()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

        $this->load->model('admin_model');

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
			
          //  $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
          //  $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));			
			
			
			//cari id ve adı çek +  $data["fatura_item_getir_duzenle"]
			$data["cari_ad"]  = $this->admin_model->cari_ad($_POST["cariid"]);
			$data["cari_id"]  = $_POST["cariid"];			 
			$data["fat_turu"] = "Satış";
		
			

            if ($data["fat_turu"] == "Satış") {
                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["fat_turu"] == "Alış") {
                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }
 $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenleygd($_POST["ygditemid"], $this->session->userdata('kullanici_id'));

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

      
     

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('ygdfatura', (array) $output);

        }

    }
	
	
	
	
	
   public function cari_id_getir()
    {
	
		
    		if(($this->session->userdata('uye_turu')==0)or($this->session->userdata('uye_turu')==1)){
	          $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and  musteri_no=".$_POST["mn"];
   		
	}
	else{
	          $sql   = "SELECT * FROM cari Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and  musteri_no=".$_POST["mn"]." and personel=".$this->session->userdata('cari_id');	
	}	
	

       

	   $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi3):				
			 echo $dizi3["id"];
			 endforeach;endif; 
			 
		


    }
	
		
   public function kampanya_urun_getir()
    {

	$data = "";
	          $sql   = "SELECT * FROM kampanya_urunleri Where kullanici=" . $this->session->userdata('kullanici_id') . " and  kampanya_id=".$_POST["urun"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cr = $query->result_array();
        } else {
            return false;
        }	
	        if ($cr): foreach ($cr as $dizi):				

	          $sql2   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and  id=".$dizi["urun_id"];
        $query2 = $this->db->query($sql2);			 
		        if ($query2->num_rows() > 0) {
            $cr2 = $query2->result_array();
        } else {
            return false;
        }	 
		
				
		        if ($cr2): foreach ($cr2 as $dizi2):	
		    if($_POST["ode"]==1){$fy = $dizi2["alis_fiyat"];}
		    if($_POST["ode"]==6){$fy = $dizi2["alis_fiyat_6_tk"];}			
		    if($_POST["ode"]==9){$fy = $dizi2["alis_fiyat_9_tk"];}
			
			$data.=$dizi["urun_id"]."..".$dizi2["adi"]."..".$fy."..".$dizi2["vergi"]."..".$dizi["ana_urun"]."*";
			
			
					 endforeach;endif; 	 
			 
			 endforeach;endif; 
			
		echo $data;


    }
	
	
   public function kampanyami()
    {

		
	          $sql   = "SELECT * FROM urun_kategori Where kullanici=" . $this->session->userdata('kullanici_id') . " and  id=".$_POST["ct"];
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $ct = $query->result_array();
        } else {
            return false;
        }	
	        if ($ct): foreach ($ct as $dizi3):				
			 echo $dizi3["kampanya"];
			 endforeach;endif; 
			 
		


    }

    public function callback_urunler($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/uruneslestir_ekle/' . $row->uruneslestir_id.'/'.$row->urun_1.'/'.$row->kategori_2) . "'>Ürün Ekle</a>";
        }

    }

    public function callback_kampanya_urun($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {


        if($row->kampanya==1){
	          return "<a class='btn btn-default' href='" . site_url('yonetim/kampanya_urunleri/' . $row->id) . "'>Kampanya Ürünleri</a>";
  		
		}
		else{
			return "Bu Kategori bir kampanya değildir.";
		}


        }

    }



  public function callback_kam_urun_ekle($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {


	          return "<a class='btn btn-default' href='" . site_url('yonetim/kam_urun_ekle/' . $row->id) . "'>Kampanya Ürün Ekle</a>";


        }

    }







    public function callback_urun_kaldir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/urun_delete/' . $row->id) . "'>Ürün Kaldır</a>";
        }

    }

    public function urun_delete($primary_key)
    {

        $k_id = $this->session->userdata('kullanici_id');

        $this->load->model('admin_model');

        $fat_silme_kontrol = $this->admin_model->urun_silme_kontrol($primary_key, $k_id);

        if ($fat_silme_kontrol == 0) {

            $this->load->library('Messages');
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/hizmet_urun', "Hizmet Ürün");
            return false;

        }
		
		
	if($this->session->userdata('yetki_stok')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}			
		
		
		

        $this->db->query('delete from hizmet_urun where kullanici_id=' . $k_id . ' and id=' . $primary_key);

        $this->log("Hizmet Ürün Silme", "hizmet_urun", "Silme", 0);

        $this->load->library('Messages');
        echo $this->messages->True_Add('yonetim/hizmet_urun');
        return false;

    }

    public function gider_kategori($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('gider_kategori');

            $crud->set_subject('Gider Kategori');
            $crud->columns('adi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('adi', 'durum');

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->field_type('tur', 'dropdown',
                array('1' => 'Gelir', '0' => 'Gider'));

            $crud->field_type('durum', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));

            $crud->unset_delete();
            $crud->unset_clone();
            $this->log_grocery($crud, "Gider Kategori", "gider_kategori");
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Gelir Gider Kategori Ayarları";
            $data['kilavuz']   = "  <b>Gelir Gider Kategori Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function demirbas($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('kategori', 'kategori', 'kategori_adi', [
                    'kategori_turu = ' => 'urun', 'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('kategori', 'kategori', 'kategori_adi', [
                    'kategori_turu = ' => 'urun', 'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_hiz = $this->admin_model->yetki_kontrol_hiz($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_hiz != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('kategori', 'kategori', 'kategori_adi', [
                    'kategori_turu = ' => 'urun', 'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('hizmet_urun');

            $crud->set_subject('Demirbaşlar');
            $crud->columns('adi', 'demirbas_adet');
            $crud->where('demirbas', "1");
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));

            $crud->required_fields('adi', 'birim', 'alis_fiyat', 'satis_fiyat');

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('demirbas', 'hidden', 1);

            $this->log_grocery($crud, "Demirbaş", "demirbas");

            $crud->unset_fields("bas_stok");
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Demirbaşlar Ayarları";
            $data['kilavuz']   = "  <b>Demirbaşlar Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function kasa($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kasa = $this->admin_model->yetki_kontrol_kasa($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kasa != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kasa = $this->admin_model->yetki_kontrol_kasa($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kasa != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('kasa');

            $crud->set_subject('Kasalar');
            $crud->columns('adi', 'Kasa Kaldır');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('adi');
            $crud->callback_before_delete(array($this, 'kasa_sil_kontrol'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->unset_fields();
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $crud->display_as("bas_kasa", "Başlangıç Bakiyesi");
            $crud->field_type('turu', 'dropdown',
                array('1' => 'Kasa', '0' => 'Banka'));
            $this->log_grocery($crud, "Kasa", "kasa");
            $crud->callback_column('Kasa Kaldır', array($this, 'callback_kasa_kaldir'));
            $data['side_menu'] = "Kasa Ayarları";
            $data['kilavuz']   = "  <b>Kasa Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}

            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_kasa_kaldir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/kasa_sil_kontrol/' . $row->id) . "'>Kasa Kaldır</a>";
        }

    }

    public function kasa_sil_kontrol($primary_key)
    {

        $this->load->library('Messages');

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('kasa_banka', $primary_key);
        $isset = $this->db->get('cek_senet');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/kasa', "Kasa");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('gonderici', $primary_key);
        $this->db->or_where('alici', $primary_key);
        $isset = $this->db->get('virman');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/kasa', "Kasa");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('kasa_id', $primary_key);
        $isset = $this->db->get('islem');
        if ($isset->num_rows() > 0) {
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/kasa', "Kasa");
            return false;
        }

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('id', $primary_key);
        $sil = $this->db->delete('kasa');
        echo $this->messages->True_Add('yonetim/kasa');
        return false;

    }

    public function komite($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_komite = $this->admin_model->yetki_kontrol_komite($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_komite != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_komite = $this->admin_model->yetki_kontrol_komite($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_komite != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('komite');

            $crud->set_subject('Kasalar');
            $crud->columns('unvan', 'Cari');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('adi', 'unvan');

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('Cari', array($this, 'callback_cari_getir'));

            $this->log_grocery($crud, "Komite", "komite");
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Komite Ayarları";
            $data['kilavuz']   = "  <b>Komite Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function demirbas_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $demirbas_ad = $this->admin_model->demirbas_ad($row->demirbas);

            return "<a class='btn btn-default' href='" . site_url('yonetim/demirbas/read/' . $row->demirbas) . "'>" . $demirbas_ad . "</a>";
        }

    }

    public function callback_cari_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $this->load->model('admin_model');
            $cari_ad = $this->admin_model->cari_ad($row->cari_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari/read/' . $row->cari_id) . "'>" . $cari_ad . "</a>";
        }

    }
	

	
	

    public function callback_personel_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $this->load->model('admin_model');
			
		if($row->personel==0){  return "Admin Siparişi";}	
			
            $cari_ad = $this->admin_model->cari_ad($row->personel);

            return "<a class='btn btn-default' href='" . site_url('yonetim/personel/read/' . $row->personel) . "'>" . $cari_ad . "</a>";
        }

    }

    public function callback_cari_getir3($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $cari_ad = $this->admin_model->cari_ad($row->kiraci_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari/read/' . $row->kiraci_id) . "'>" . $cari_ad . "</a>";

        }

    }

    public function callback_cari_getir2($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $cari_ad = $this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari/read/' . $row->sahip_id) . "'>" . $cari_ad . "</a>";

        }

    }

    public function callback_cari_getir4($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $u_ad = $this->admin_model->cari_ad($row->kim);

            return "<a class='btn btn-default' href='" . site_url('yonetim/uyeler/read/' . $row->kim) . "'>" . $u_ad . "</a>";

        }

    }

    public function blok_adi_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $this->load->model('admin_model');
            return $blok_ad = $this->admin_model->blok_ad($row->blok_id);

        }

    }

    public function uyeler($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $uye_turu = $this->session->userdata('uye_turu');
            if (($uye_turu != 0) and ($uye_turu != 1)) {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }
			

		if($this->session->userdata('yetki_uyelik')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}		
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'delete') {

                $primary_key = $state_info->primary_key;
                if ($primary_key == $this->session->userdata('kullanici_id')) {
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                if ($primary_key == $this->session->userdata('id')) {
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;
                }

            }

            if ($state == 'add') {

            
            } else if ($state == 'edit') {

                $primary_key = $state_info->primary_key;
                if ($primary_key == $this->session->userdata('kullanici_id')) {
                    $crud->unset_edit_fields("status", "bas_tar", "bit_tar");

                }

                if ($primary_key == $this->session->userdata('id')) {
                    $crud->unset_edit_fields("status", "bas_tar", "bit_tar");

                }

                $this->load->model('admin_model');
                $yetki_kontrol_uye = $this->admin_model->yetki_kontrol_uye($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_uye != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

           
            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_uye = $this->admin_model->yetki_kontrol_uye($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_uye != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->unset_read_fields("pass");
          
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('uyeler');

            $crud->set_subject('Üyeler');
            $crud->columns('name', 'email', 'bas_tar', 'bit_tar');
           // $crud->display_as('cari_id', 'İlişkili Personel');
            $crud->display_as('name', 'Adı');
            $crud->display_as('bas_tar', 'Başlangıç Tarihi');
            $crud->display_as('bit_tar', 'Bitiş Tarihi');
            $crud->display_as('status', 'Durum');
            $crud->display_as('surname', 'Soyadı');	
            $crud->display_as('username', 'Kullanıcı Adı');				
            $crud->field_type('uye_turu', 'hidden', 2);
            $crud->display_as('bayi_id', 'Üyenin bağlı olduğu bayi');
			
			
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('uye_turu!=', 1);
            $crud->required_fields('name', 'email', 'username', 'pass');
			
     // $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id'), "kisi_turu" => 1]);
			
            $crud->field_type('cari_id', 'hidden');
            $crud->field_type('status', 'dropdown',
                array('1' => 'Aktif', '0' => 'Pasif'));
            $crud->field_type('bayi_id', 'dropdown',
                array('0' => 'Kayseri Merkez', '1' => 'Nevşehir', '2' => 'Kırşehir', '3' => 'Yozgat', '4' => 'Aksaray'));				
				
            $crud->field_type('firma', 'dropdown',
                array('1' => 'Yetkili', '0' => 'Yetkisiz'));				
            $crud->field_type('uyelik', 'dropdown',
                array('1' => 'Yetkili', '0' => 'Yetkisiz'));			
            $crud->field_type('stok', 'dropdown',
                array('1' => 'Yetkili', '0' => 'Yetkisiz'));			
            $crud->field_type('cari', 'dropdown',
                array('1' => 'Yetkili', '0' => 'Yetkisiz'));		
            $crud->field_type('siparis', 'dropdown',
                array('1' => 'Yetkili', '0' => 'Yetkisiz'));	


            $crud->field_type('cari_id', 'hidden');				
            $crud->field_type('yetki', 'hidden');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('Cari', array($this, 'callback_cari_getir'));

            $crud->change_field_type('pass', 'password');
            $crud->callback_before_update(array($this, 'encrypt_password_callback'));
            $crud->callback_before_insert(array($this, 'encrypt_password_callback'));


            $this->log_grocery($crud, "Uyeler", "uyeler");
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $crud->unset_fields("uye_sayisi");

            $uye_turu = $this->session->userdata('uye_turu');
            if (($uye_turu != 0) and ($uye_turu != 1)) {
                $crud->unset_add();
                $crud->unset_edit();
                $this->crud_status($crud, 0, 0, 1, 1); // add edit read delete

            }
            $this->load->model('admin_model');
            $uye_sayisi_kontrol = $this->admin_model->uye_sayisi_kontrol($this->session->userdata('kullanici_id'), $this->session->userdata('id'));

            if ($uye_sayisi_kontrol == 0) {
                $crud->unset_add();
                $this->crud_status($crud, 0, 1, 1, 1); // add edit read delete
            }

            $data['side_menu'] = "Üye Ayarları";
            $data['kilavuz']   = "  <b>Üye Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
	
	
	
	
	  public function uye_cari($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $uye_turu = $this->session->userdata('uye_turu');
            if (($uye_turu != 0) and ($uye_turu != 1)) {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'delete') {

                $primary_key = $state_info->primary_key;
                if ($primary_key == $this->session->userdata('kullanici_id')) {
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                if ($primary_key == $this->session->userdata('id')) {
                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;
                }

            }

            if ($state == 'add') {

            
            } else if ($state == 'edit') {

                $primary_key = $state_info->primary_key;
                if ($primary_key == $this->session->userdata('kullanici_id')) {
                    $crud->unset_edit_fields("status", "bas_tar", "bit_tar");

                }

                if ($primary_key == $this->session->userdata('id')) {
                    $crud->unset_edit_fields("status", "bas_tar", "bit_tar");

                }

                $this->load->model('admin_model');
                $yetki_kontrol_uye = $this->admin_model->yetki_kontrol_uye($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_uye != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                
            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_uye = $this->admin_model->yetki_kontrol_uye($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_uye != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->unset_read_fields("pass");
              
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('uye_cari');

            $crud->set_subject('Üyeler');
            $crud->columns('uye', 'cari');
            $crud->where('kullanici', $this->session->userdata('kullanici_id'));
             $crud->field_type('kullanici', 'hidden', $this->session->userdata('kullanici_id'));          
            $crud->required_fields('uye', 'cari');
			
      $crud->set_relation('uye', 'uyeler', 'username', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
      $crud->set_relation('cari', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id'), 'kisi_turu = '=> 1]);
					
$crud->unique_fields(array('uye','cari'));

            $this->log_grocery($crud, "Uyeler", "uyeler");
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $uye_turu = $this->session->userdata('uye_turu');
            if (($uye_turu != 0) and ($uye_turu != 1)) {
                $crud->unset_add();
                $crud->unset_edit();
                $this->crud_status($crud, 0, 0, 1, 1); // add edit read delete

            }
            $this->load->model('admin_model');
            $uye_sayisi_kontrol = $this->admin_model->uye_sayisi_kontrol($this->session->userdata('kullanici_id'), $this->session->userdata('id'));

            if ($uye_sayisi_kontrol == 0) {
                $crud->unset_add();
                $this->crud_status($crud, 0, 1, 1, 1); // add edit read delete
            }

            $data['side_menu'] = "Üye Ayarları";
            $data['kilavuz']   = "  <b>Üye Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    public function mail()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->library('messages');
            echo $this->messages->config('Yonetim');
            return false;

            /*
        $this->load->Model('admin_model', 'Model');
        $data['mail'] = $this->Model->mail_getir($this->session->userdata('kullanici_id'));

        $data['sayfa'] = 'E-Posta Gönder';

        $this->load->view('eposta.php',$data);
         */

        }

    }

    public function etkinlik()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->Model('admin_model', 'Model');
            $data['sayfa']    = 'Etkinlik Takvimi';
            $data['et_getir'] = $this->Model->et_getir($this->session->userdata('id'), $this->session->userdata('kullanici_id'));
            $data['json']     = json_encode($data['et_getir']);
            $this->load->view('etkinlik.php', $data);

        }

    }

    public function etkinlikal()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $aylar["Jan"] = "01";
            $aylar["Feb"] = "02";
            $aylar["Mar"] = "03";
            $aylar["Apr"] = "04";
            $aylar["May"] = "05";
            $aylar["Jun"] = "06";
            $aylar["Jul"] = "07";
            $aylar["Aug"] = "08";
            $aylar["Sep"] = "09";
            $aylar["Oct"] = "10";
            $aylar["Nov"] = "11";
            $aylar["Dec"] = "12";

            $title  = $this->input->post('title', true);
            $start  = $this->input->post('start', true);
            $end    = $this->input->post('end', true);
            $allDay = $this->input->post('allDay', true);

            if ($allDay == "true") {

//echo $start." - ".$end." ".$allDay;
                $p     = explode("GMT", $start);
                $p2    = explode(" ", $p[0]);
                $start = $p2[3] . "-" . $aylar[$p2[1]] . "-" . $p2[2] . " " . $p2[4];

                $p   = explode("GMT", $end);
                $p2  = explode(" ", $p[0]);
                $end = $p2[3] . "-" . $aylar[$p2[1]] . "-" . $p2[2] . " " . $p2[4];

            }
            if ($allDay == "false") {
//echo $start." - ".$end." ".$allDay;

                $p     = explode("GMT", $start);
                $p2    = explode(" ", $p[0]);
                $start = $p2[3] . "-" . $aylar[$p2[1]] . "-" . $p2[2] . " " . $p2[4];

                $p   = explode("GMT", $end);
                $p2  = explode(" ", $p[0]);
                $end = $p2[3] . "-" . $aylar[$p2[1]] . "-" . $p2[2] . " " . $p2[4];

            }

            $this->load->model('admin_model');
            $etkinlik_kayit = $this->admin_model->etkinlik_kayit($title, $start, $end, $allDay, $this->session->userdata('kullanici_id'), $this->session->userdata('id'));

            if ($etkinlik_kayit != 1) {echo "Kayit İşlemi Başarısız";} else {

                $this->log("Etkinlik", "etkinlik", "Ekleme", $this->db->insert_id());
                echo "Kayit İşlemi Başarılı";}

        }

    }

    public function etkinliksil()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $id = $this->input->post('id', true);

            $this->load->model('admin_model');
            $etkinlik_kayit = $this->admin_model->etkinlik_sil($id, $this->session->userdata('kullanici_id'), $this->session->userdata('id'));

            $this->log("Etkinlik", "etkinlik", "Silme", 0);

            if ($etkinlik_kayit != 1) {echo "Silme İşlemi Başarısız";} else {echo "Silme İşlemi Başarılı";}

        }

    }

    public function mail_gonder()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $epostalar = $this->input->post('epostalar', true);
            $say       = count($epostalar);
            $bas       = $this->input->post('bas', true);
            $ice       = $this->input->post('ice', true);

            $this->load->library('mail/reklam_mail');
            $mail_sinifi = new reklam_mail();

            if ($say == 0) {

                echo "<br><br><center><b>Lütfen en az 1 adet e-posta adresi seçiniz.</b></center>";
                echo '<meta http-equiv="refresh" content="2;URL=mail">';
                return false;
            }

            $mail_adresleri = $epostalar;
            $ice .= " <br><br>Mail Listesinden ayrılmak için <a href='" . base_url() . "yonetim/mail_cikis/";
            $gonder = $mail_sinifi->gonder_icerik($mail_adresleri, $bas, $ice);

            if ($gonder != true) {
                $this->log("Mail Gönderim", "uyeler", "Gönderilemedi", 0);
                echo "<br><br><center><b>Gönderim başarısız</b></center>";
                echo '<meta http-equiv="refresh" content="2;URL=mail">';
                return false;
            }

            $this->log("Mail Gönderim", "uyeler", "Gönderildi", 0);
            echo "<br><br><center><b>Gönderim başarılı</b></center>";
            echo '<meta http-equiv="refresh" content="2;URL=mail">';
            return false;

        }

    }

    public function mail_cikis($ep1, $ep2)
    {
        if (($ep1 == "") or ($ep2 == "")) {

            $this->load->library('messages');
            $this->messages->config('');

        }

        $ep1 = trim($ep1);
        $ep1 = strip_tags($ep1);
        $ep1 = htmlentities($ep1);
        $ep2 = trim($ep2);
        $ep2 = strip_tags($ep2);
        $ep2 = htmlentities($ep2);

        $this->load->model('admin_model');
        $mail_cikis = $this->admin_model->mail_cikis($ep1, $ep2);
        if ($mail_cikis != 1) {

            echo "<br><br><center><b>Mail Listesinden çıkış işleminiz başarısız başarısız , Lütfen iletişime geçiniz.</b></center>";
            echo '<meta http-equiv="refresh" content="2;URL=' . base_url() . '/yonetim/mail">';
            return false;
        }

        echo "<br><br><center><b>Mail Listesinden çıkış işleminiz başarılı</b></center>";
        echo '<meta http-equiv="refresh" content="2;URL=' . base_url() . '/yonetim/mail">';
        return false;

    }

    public function ornek_dosyalar($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_dosya = $this->admin_model->yetki_kontrol_dosya($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_dosya != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_dosya = $this->admin_model->yetki_kontrol_dosya($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_dosya != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('ornek_dosyalar');

            $crud->set_subject('Örnek Dosyalar');
            $crud->columns('dosya_adi', 'aciklama');
            $crud->required_fields('dosya_adi', 'aciklama');
            $crud->set_field_upload('dosya_adi', 'assets/uploads/files');

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->unset_back_to_list();
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_read();
            $this->log_grocery($crud, "Örnek Dosyalar", "ornek_dosyalar");

            $this->crud_status($crud, 1, 1, 0, 0); // add edit read delete

            $data['side_menu'] = "Örnek Dosya Ayarları";
            $data['kilavuz']   = "  <b>Örnek Dosya Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function dosyalar($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_dosya = $this->admin_model->yetki_kontrol_dosya($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_dosya != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_dosya = $this->admin_model->yetki_kontrol_dosya($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_dosya != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('dosyalar');

            $crud->set_subject('Dosyalar');
            $crud->columns('dosya_adi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('dosya_adi', 'aciklama');
            $crud->set_field_upload('dosya_adi', 'assets/uploads/files');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            $crud->unset_delete();
            $crud->unset_clone();
            $this->log_grocery($crud, "Dosyalar", "dosyalar");
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Dosya Ayarları";
            $data['kilavuz']   = "  <b>Dosya Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            $this->load->view('index', (array) $output);

        }
    }

    public function kategori($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_kategori($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_kategori = $this->admin_model->yetki_kontrol_kategori($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_kategori != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('kategori');

            $crud->set_subject('Kategoriler');
            $crud->columns('kategori_adi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('kategori_adi', 'kategori_turu');

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('kategori_turu', 'dropdown',
                array('urun' => 'Ürün'));

            $crud->unset_delete();
            $crud->unset_clone();
            $this->log_grocery($crud, "Kategori", "kategori");
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            $data['side_menu'] = "Kategori Ayarları";
            $data['kilavuz']   = "  <b>Kategori Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function gelir_gider($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('kategori', 'gider_kategori', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->unset_fields("gelir_gider_fat");
            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gelir_gider = $this->admin_model->yetki_kontrol_gelir_gider($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gelir_gider != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('kategori', 'gider_kategori', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->unset_fields("gelir_gider_fat");

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gelir_gider = $this->admin_model->yetki_kontrol_gelir_gider($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gelir_gider != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->set_relation('kategori', 'gider_kategori', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

                $crud->unset_fields("gelir_gider_fat");
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Gelir - Gider');
            $crud->columns('giris_cikis', 'tutar', 'tarih');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            //   $crud->where('gelir_gider_fat',1);
            //     $crud->where('islem_turu',3);
            //  $crud->or_where('islem_turu',0);

            $crud->where('islem_turu', 0);

            $crud->required_fields('giris_cikis', 'tutar', 'tarih', 'kasa_id');
            $crud->display_as('kasa_id', 'Kasa Banka');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('giris_cikis', 'Gelir - Gider');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('islem_turu', 'hidden', 0);
            $crud->field_type('relation_type', 'hidden');
            $crud->field_type('relation_id', 'hidden');
            $crud->field_type('cari_id', 'hidden');
            $crud->field_type('giris_cikis', 'dropdown',
                array('1' => 'Gelir', '0' => 'Gider'));

            $this->log_grocery($crud, "Gelir-Gider", "islem");
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Gelir - Gider Ayarları";
            $data['kilavuz']   = "  <b>Gelir - Gider Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function fatura2($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            $crud->set_theme('flexigrid');
            $crud->set_table('virman');

            $data['side_menu'] = "Virman Ayarları";
            $data['kilavuz']   = "  <b>Virman Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function virman($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('gonderici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('alici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_virman = $this->admin_model->yetki_kontrol_virman($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_virman != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('gonderici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('alici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_virman = $this->admin_model->yetki_kontrol_virman($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_virman != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('gonderici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->set_relation('alici', 'kasa', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('virman');

            $crud->set_subject('Virman');
            $crud->columns('gonderici', 'alici', 'tarih', 'tutar');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));

            $crud->required_fields('gonderici', 'alici', 'tarih', 'tutar');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('gonderici', array($this, 'callback_kasa_gonderici'));
            $crud->callback_column('alici', array($this, 'callback_kasa_alici'));

            $crud->callback_after_delete(array($this, 'islem_sil'));
            $crud->callback_after_insert(array($this, 'islem_kayit'));

            $crud->unset_clone();
            $crud->unset_edit();
            $this->log_grocery($crud, "Virman", "virman");
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 0, 1, 1); // add edit read delete

            $data['side_menu'] = "Virman Ayarları";
            $data['kilavuz']   = "  <b>Gelir - Gider Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_kasa_gonderici($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $gonderici = $this->admin_model->kasa_ad($row->gonderici);

            return "<a class='btn btn-default' href='" . site_url('yonetim/kasa/read/' . $row->gonderici) . "'>" . $gonderici . "</a>";

        }

    }

    public function callback_kasa_alici($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $gonderici = $this->admin_model->kasa_ad($row->alici);

            return "<a class='btn btn-default' href='" . site_url('yonetim/kasa/read/' . $row->alici) . "'>" . $gonderici . "</a>";

        }

    }

    public function islem_kayit($post_array, $primary_key)
    {
//    $post_array['pass'] $primary_key

        $this->load->model('admin_model');

        $id = $this->db->insert_id();

        $virman_getir = $this->admin_model->virman_getir($this->session->userdata('kullanici_id'), $id);

        if ($virman_getir): foreach ($virman_getir as $dizi):

                $data[0] = $dizi["id"];
                $data[1] = $dizi["gonderici"];
                $data[2] = $dizi["alici"];
                $data[3] = $dizi["tutar"];
                $data[4] = $dizi["tarih"];
                $data[5] = $dizi["aciklama"];
                $data[6] = $dizi["kullanici_id"];

            endforeach;endif;

        $islem_kayit = $this->admin_model->islem_kayit($data);

        return true;
    }

    public function islem_sil($primary_key)
    {
//    $post_array['pass'] $primary_key

//    $this->load->model('admin_model');

        $this->db->where('islem_turu', 1);
        $this->db->where('relation_id', $primary_key);
        return $this->db->delete('islem');

    }

    public function borc_alacak($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {

                $crud->display_as('fatura_turu', 'Borç Alacak');
                $crud->display_as('cari_id', 'Cari');
                $crud->field_type('fatura_turu', 'dropdown',
                    array('1' => 'Cari Borçlandır', '0' => 'Cari Alacaklandır'));
            }

            if ($state == 'add') {

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->display_as('fatura_turu', 'Borç Alacak');
                $crud->display_as('cari_id', 'Cari');
                $crud->field_type('fatura_turu', 'dropdown',
                    array('1' => 'Cari Borçlandır', '0' => 'Cari Alacaklandır'));
            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_borc = $this->admin_model->yetki_kontrol_borc($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_borc != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->display_as('fatura_turu', 'Borç Alacak');
                $crud->display_as('cari_id', 'Cari');
                $crud->field_type('fatura_turu', 'dropdown',
                    array('1' => 'Cari Borçlandır', '0' => 'Cari Alacaklandır'));
            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_borc = $this->admin_model->yetki_kontrol_borc($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_borc != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->display_as('fatura_turu', 'Borç Alacak');
                $crud->display_as('cari_id', 'Cari');
                $crud->field_type('fatura_turu', 'dropdown',
                    array('1' => 'Cari Borçlandır', '0' => 'Cari Alacaklandır'));
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('borc_alacak');

            $crud->set_subject('Borç Alacak');
            $crud->columns('fatura_turu', 'cari', 'toplam', 'vade_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('fatura_turu', 'cari_id', 'toplam', 'vade_tarihi');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('tarih', 'hidden', date("Y-m-d"));

            $crud->callback_column('cari', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'islem_sil_boal'));
            $crud->callback_after_insert(array($this, 'islem_kayit_boal'));

            $crud->unset_fields("paylasim_turu", "ortak_alan_paylasim_turu", "ortak_alan_yuzdesi");

            $crud->unset_back_to_list();
            $crud->unset_edit();
            $crud->unset_clone();
            $this->log_grocery($crud, "Borç-Alacak", "borc_alacak");

            $this->crud_status($crud, 1, 0, 1, 1); // add edit read delete

            $data['side_menu'] = "Borç Alacak Ayarları";
            $data['kilavuz']   = "  <b>Borç Alacak Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function islem_kayit_boal($post_array, $primary_key)
    {
//    $post_array['pass'] $primary_key

        $this->load->model('admin_model');

        $id = $this->db->insert_id();

        $boal_getir = $this->admin_model->boal_getir($this->session->userdata('kullanici_id'), $id);

        if ($boal_getir): foreach ($boal_getir as $dizi):

                $data[0] = $dizi["id"];
                $data[1] = $dizi["fatura_turu"];
                $data[2] = $dizi["toplam"];
                $data[3] = $dizi["cari_id"];
                $data[4] = $dizi["kullanici_id"];
                $data[5] = $dizi["tarih"];
                $data[6] = $dizi["vade_tarihi"];
                $data[7] = $dizi["aciklama"];

            endforeach;endif;

        $islem_kayit_boal = $this->admin_model->islem_kayit_boal($data);

        return true;
    }

    public function islem_sil_boal($primary_key)
    {
//    $post_array['pass'] $primary_key

//    $this->load->model('admin_model');

        $this->db->where('islem_turu', 2);
        $this->db->where('relation_id', $primary_key);
        return $this->db->delete('islem');

    }

    public function toplu_borc($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {

                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            if ($state == 'add') {

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('borc_alacak');

            $crud->set_subject('Toplu Borçlandır');
            $crud->columns('fatura_turu', 'cari', 'toplam', 'vade_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('fatura_turu', 'cari_id', 'toplam', 'vade_tarihi', 'aciklama');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('tarih', 'hidden', date("Y-m-d"));

            $bos_varmi = $this->admin_model->sahip_bos_varmi($this->session->userdata('kullanici_id'));

            if ($bos_varmi > 0) {

                $crud->display_as('fatura_turu', 'Blok Seç (Lütfen dairelerinizin en azından sahip bilgilerini ilişkilendirin)');
                $crud->field_type('fatura_turu', 'readonly');
            } else {

                $crud->display_as('fatura_turu', 'Blok Seç ');
            }

            $crud->display_as('cari_id', 'Borçlandırılacak kişi');
            $crud->display_as('toplam', 'Bölünecek toplam tutar');
            $crud->set_relation('fatura_turu', 'blok', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            $crud->field_type('cari_id', 'dropdown',
                array('1' => 'Ev sahibi', '0' => 'Varsa Kiracı yoksa ev sahibi'));

            $crud->field_type('paylasim_turu', 'dropdown',
                array('0' => 'Eşit Paylaşım', '1' => 'm2 ye Göre Paylaşım', '2' => 'Elektrik Sayacına Göre Paylaşım'
                    , '3' => 'Su Sayacına Göre Paylaşım', '4' => 'Gaz Sayacına Göre Paylaşım'));

            $crud->field_type('ortak_alan_paylasim_turu', 'dropdown',
                array('0' => 'Eşit Paylaşım', '1' => 'm2 ye Göre Paylaşım'));

            $crud->callback_after_insert(array($this, 'islem_kayit_toplu_bo'));

            $this->log_grocery($crud, "Toplu Borç", "borc_alacak");

            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Borç Alacak Ayarları";
            $data['kilavuz']   = "  <b>Borç Alacak Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function islem_kayit_toplu_bo($post_array, $primary_key)
    {
//    $post_array['pass'] $primary_key

//    $this->load->model('admin_model');

        $id = $this->db->insert_id();

        $sql   = "SELECT * FROM borc_alacak Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $boal_getir = $query->result_array();
        } else {
            return false;
        }

        if ($boal_getir): foreach ($boal_getir as $dizi):

                $blok                     = $dizi["fatura_turu"];
                $toplam                   = $dizi["toplam"];
                $evs_kir                  = $dizi["cari_id"];
                $vade_tarihi              = $dizi["vade_tarihi"];
                $aciklama                 = $dizi["aciklama"];
                $kullanici_id             = $dizi["kullanici_id"];
                $tarih                    = $dizi["tarih"];
                $paylasim_turu            = $dizi["paylasim_turu"];
                $ortak_alan_paylasim_turu = $dizi["ortak_alan_paylasim_turu"];
                $ortak_alan_yuzdesi       = $dizi["ortak_alan_yuzdesi"];
            endforeach;endif;

        $this->db->where('id', $id);
        $this->db->delete('borc_alacak');

        $sql   = "SELECT * FROM daire Where blok_id=" . $blok . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $daireler = $query->result_array();
        } else {
            return false;
        }

        if (($toplam == "") or (!is_numeric($toplam))) {

            return false;

        }

        if (($ortak_alan_yuzdesi == "") or (!is_numeric($ortak_alan_yuzdesi))) {

            $ortak_alan_yuzdesi == 0;

        }

        $adet                 = count($daireler);
        $ortak_alan_tutar     = $toplam / 100;
        $ortak_alan_tutar     = $ortak_alan_tutar * $ortak_alan_yuzdesi;
        $daireler_ozel_toplam = $toplam - $ortak_alan_tutar;

        $m2_toplam = 0;
        $elk_top   = 0;
        $su_top    = 0;
        $gaz_top   = 0;
        if ($daireler): foreach ($daireler as $dizi):

                $m2_toplam = $m2_toplam + $dizi["m2"];

                $elk_fark = $dizi["elektrik_son_okuma"] - $dizi["elektrik_ilk_okuma"];
                $elk_top  = $elk_top + $elk_fark;

                $su_fark = $dizi["su_son_okuma"] - $dizi["su_ilk_okuma"];
                $su_top  = $su_top + $su_fark;

                $gaz_fark = $dizi["gaz_son_okuma"] - $dizi["gaz_ilk_okuma"];
                $gaz_top  = $gaz_top + $gaz_fark;

            endforeach;endif;

        // $toplam=round($toplam/$adet,2);
        if ($daireler): foreach ($daireler as $dizi):

                if ($paylasim_turu == 0) {
                    $daire_toplam = $daireler_ozel_toplam / $adet;

                }
                if ($paylasim_turu == 1) {

                    $m2oran       = $dizi["m2"] / $m2_toplam;
                    $m2oran       = $m2oran * 100;
                    $daire_toplam = $daireler_ozel_toplam / 100;
                    $daire_toplam = $daire_toplam * $m2oran;
                }

                if ($paylasim_turu == 2) {

                    $elk_fark     = $dizi["elektrik_son_okuma"] - $dizi["elektrik_ilk_okuma"];
                    $elkoran      = $elk_fark / $elk_top;
                    $elkoran      = $elkoran * 100;
                    $daire_toplam = $daireler_ozel_toplam / 100;
                    $daire_toplam = $daire_toplam * $elkoran;
                }

                if ($paylasim_turu == 3) {

                    $su_fark      = $dizi["su_son_okuma"] - $dizi["su_ilk_okuma"];
                    $suoran       = $su_fark / $su_top;
                    $suoran       = $suoran * 100;
                    $daire_toplam = $daireler_ozel_toplam / 100;
                    $daire_toplam = $daire_toplam * $suoran;
                }

                if ($paylasim_turu == 4) {

                    $gaz_fark     = $dizi["gaz_son_okuma"] - $dizi["gaz_ilk_okuma"];
                    $gazoran      = $gaz_fark / $gaz_top;
                    $gazoran      = $gazoran * 100;
                    $daire_toplam = $daireler_ozel_toplam / 100;
                    $daire_toplam = $daire_toplam * $gazoran;
                }

                if ($ortak_alan_paylasim_turu == 0) {
                    $ortak_alan_daire_toplam = $ortak_alan_tutar / $adet;

                }

                if ($ortak_alan_paylasim_turu == 1) {

                    $m2oran                  = $dizi["m2"] / $m2_toplam;
                    $m2oran                  = $m2oran * 100;
                    $ortak_alan_daire_toplam = $ortak_alan_tutar / 100;
                    $ortak_alan_daire_toplam = $ortak_alan_daire_toplam * $m2oran;

                }

                $genel_toplam = round($daire_toplam + $ortak_alan_daire_toplam, 2);

                if ($evs_kir == 1) {
                    $cari         = $dizi["sahip_id"];
                    $daire_durumu = "Malik";}
                if ($evs_kir == 0) {
                    if (($dizi["kiraci_id"] == 0) or ($dizi["kiraci_id"] == "")) {
                        $cari         = $dizi["sahip_id"];
                        $daire_durumu = "Malik";} else {
                        $cari         = $dizi["kiraci_id"];
                        $daire_durumu = "Kiracı";}}

                $data[0] = $fat_turu = 1;
                $data[1] = $genel_toplam;
                $data[2] = $cari_id = $cari;
                $data[3] = $kullanici_id = $this->session->userdata('kullanici_id');
                $data[4] = $tarih = date("Y-m-d");
                $data[5] = $vade_tarihi = $vade_tarihi;
                $data[6] = $aciklama;
                $data[6] .= " (Daire No: " . $dizi["daire_no"] . " Durum: " . $daire_durumu . ")";
                $ack = $data[6];

                $toplu_boalkayit = $this->admin_model->toplu_boalkayit($data);
                $id              = $this->db->insert_id();

                $data[0] = $id;
                $data[1] = $fat_turu;
                $data[2] = $genel_toplam;
                $data[3] = $cari_id;
                $data[4] = $kullanici_id;
                $data[5] = $tarih;
                $data[6] = $vade_tarihi;
                $data[7] = $ack;

                $islem_kayit_boal = $this->admin_model->islem_kayit_boal($data);

            endforeach;endif;

        return true;

    }

    public function toplu_alacak($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {

                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            if ($state == 'add') {

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('');
                return false;

            }

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('borc_alacak');

            $crud->set_subject('Toplu Alacaklandır');
            $crud->columns('fatura_turu', 'cari', 'toplam', 'vade_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('fatura_turu', 'cari_id', 'toplam', 'vade_tarihi', 'aciklama');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('tarih', 'hidden', date("Y-m-d"));

            $bos_varmi = $this->admin_model->sahip_bos_varmi($this->session->userdata('kullanici_id'));

            if ($bos_varmi > 0) {

                $crud->display_as('fatura_turu', 'Blok Seç (Lütfen dairelerinizin en azından sahip bilgilerini ilişkilendirin)');
                $crud->field_type('fatura_turu', 'readonly');
            } else {

                $crud->display_as('fatura_turu', 'Blok Seç ');
            }

            $crud->display_as('cari_id', 'Alacaklandırılacak kişi');
            $crud->display_as('toplam', 'Bölünecek toplam tutar');
            $crud->set_relation('fatura_turu', 'blok', 'adi', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

            $crud->field_type('cari_id', 'dropdown',
                array('1' => 'Ev sahibi', '0' => 'Varsa Kiracı yoksa ev sahibi'));
            $crud->callback_after_insert(array($this, 'islem_kayit_toplu_al'));

            $this->log_grocery($crud, "Toplu Alacak", "borc_alacak");

            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Borç Alacak Ayarları";
            $data['kilavuz']   = "  <b>Borç Alacak Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function islem_kayit_toplu_al($post_array, $primary_key)
    {
//    $post_array['pass'] $primary_key

//    $this->load->model('admin_model');

        $id = $this->db->insert_id();

        $sql   = "SELECT * FROM borc_alacak Where kullanici_id=" . $this->session->userdata('kullanici_id') . " and id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $boal_getir = $query->result_array();
        } else {
            return false;
        }

        if ($boal_getir): foreach ($boal_getir as $dizi):

                $blok         = $dizi["fatura_turu"];
                $toplam       = $dizi["toplam"];
                $evs_kir      = $dizi["cari_id"];
                $vade_tarihi  = $dizi["vade_tarihi"];
                $aciklama     = $dizi["aciklama"];
                $kullanici_id = $dizi["kullanici_id"];
                $tarih        = $dizi["tarih"];

            endforeach;endif;

        $this->db->where('id', $id);
        $this->db->delete('borc_alacak');

        $sql   = "SELECT id,daire_no,sahip_id,kiraci_id FROM daire Where blok_id=" . $blok . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $daireler = $query->result_array();
        } else {
            return false;
        }

        $adet   = count($daireler);
        $toplam = round($toplam / $adet, 2);
        if ($daireler): foreach ($daireler as $dizi):

                if ($evs_kir == 1) {
                    $cari         = $dizi["sahip_id"];
                    $daire_durumu = "Malik";}
                if ($evs_kir == 0) {
                    if (($dizi["kiraci_id"] == 0) or ($dizi["kiraci_id"] == "")) {
                        $cari         = $dizi["sahip_id"];
                        $daire_durumu = "Malik";} else {
                        $cari         = $dizi["kiraci_id"];
                        $daire_durumu = "Kiracı";}}

                $data[0] = $fat_turu = 0;
                $data[1] = $toplam;
                $data[2] = $cari_id = $cari;
                $data[3] = $kullanici_id = $this->session->userdata('kullanici_id');
                $data[4] = $tarih = date("Y-m-d");
                $data[5] = $vade_tarihi = $vade_tarihi;
                $data[6] = $aciklama;
                $data[6] .= " (Daire No: " . $dizi["daire_no"] . " Durum: " . $daire_durumu . ")";
                $ack = $data[6];

                $toplu_boalkayit = $this->admin_model->toplu_boalkayit($data);
                $id              = $this->db->insert_id();

                $data[0] = $id;
                $data[1] = $fat_turu;
                $data[2] = $toplam;
                $data[3] = $cari_id;
                $data[4] = $kullanici_id;
                $data[5] = $tarih;
                $data[6] = $vade_tarihi;
                $data[7] = $ack;

                $islem_kayit_boal = $this->admin_model->islem_kayit_boal($data);

            endforeach;endif;

        return true;

    }

    public function cari_detay()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('cari');

            $crud->set_subject('Cari Durum');
            $crud->columns('adi_soyadi_unvan', 'durum', 'detay');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
				if($this->session->userdata('uye_turu')==2){
            $crud->where('personel', $this->session->userdata('cari_id'));				
				
			}
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('durum', array($this, 'durum_getir'));
            $crud->callback_column('detay', array($this, 'detay_getir'));

            $crud->unset_add();
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Cari Borç Alacak Görünüm Ayarları";
            $data['kilavuz']   = "  <b>Cari Borç Alacak Görünüm  Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function durum_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $this->load->model('admin_model');
            $cari_baslangic       = $this->admin_model->cari_baslangic($row->id, $this->session->userdata('kullanici_id'));
            $cari_baslangic_durum = $this->admin_model->cari_baslangic_durum($row->id, $this->session->userdata('kullanici_id'));

            if ($cari_baslangic_durum == 0) {} else { $cari_baslangic = 0 - $cari_baslangic;}

            $cari_toplam_getir = $this->admin_model->cari_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            //    $cari_baslangic=0;
            if ($cari_toplam_getir): foreach ($cari_toplam_getir as $dizi):

                    if ($dizi["islem_turu"] == 0) {continue;}
                    if ($dizi["islem_turu"] == 1) {continue;}
                    if ($dizi["islem_turu"] == 2) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                    }

                    if ($dizi["islem_turu"] == 3) {

                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}

                    }
                    if ($dizi["islem_turu"] == 4) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                    }

                endforeach;endif;

            if ($cari_baslangic < 0) {
                $cari_baslangic = $cari_baslangic + $cari_baslangic * -2;
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Alacaklısınız";
            }
            if ($cari_baslangic == 0) {
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borç ve Alacak yok";
            }
            if ($cari_baslangic > 0) {
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borçlusunuz";
            }

        }

    }

    public function detay_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari_detay_git/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function islem_kaydi_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/cari_islem_git/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function cari_detay_git($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_islem = $this->admin_model->yetki_kontrol_islem($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_islem != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            if ($state == 'list') {

                $this->load->model('admin_model');
                $yetki_kontrol_cari_detay = $this->admin_model->yetki_kontrol_cari_detay($this->session->userdata('kullanici_id'), $id);

                if ($yetki_kontrol_cari_detay != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $this->load->model('admin_model');
            $cari_baslangic = $this->admin_model->cari_baslangic($id, $this->session->userdata('kullanici_id'));

            $cari_baslangic_durum = $this->admin_model->cari_baslangic_durum($id, $this->session->userdata('kullanici_id'));

            if ($cari_baslangic_durum == 0) {} else { $cari_baslangic = 0 - $cari_baslangic;}

            $data["cari_baslangic"] = $cari_baslangic;
            $data["cari_id"]        = $id;
            $data["cari_adi"]       = $this->admin_model->cari_adi($id, $this->session->userdata('kullanici_id'));
            $cari_toplam_getir      = $this->admin_model->cari_toplam_getir($id, $this->session->userdata('kullanici_id'));

            //    $cari_baslangic=0;
            if ($cari_toplam_getir): foreach ($cari_toplam_getir as $dizi):

                    if ($dizi["islem_turu"] == 0) {continue;}
                    if ($dizi["islem_turu"] == 1) {continue;}
                    if ($dizi["islem_turu"] == 2) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                    }

                    if ($dizi["islem_turu"] == 3) {

                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}

                    }

                    if ($dizi["islem_turu"] == 4) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                    }

                endforeach;endif;

            if ($cari_baslangic < 0) {
                $cari_baslangic     = $cari_baslangic + $cari_baslangic * -2;
                $data["cari_total"] = "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Alacaklısınız";

            } else if ($cari_baslangic == 0) {
                $data["cari_total"] = "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borç ve Alacak yok";
            } else if ($cari_baslangic > 0) {
                $data["cari_total"] = "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borçlusunuz";
            } else {}

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Cari İşlemleri');
            $crud->columns('tarih', 'vade_tarihi', 'tutar', 'islem_turu', 'son_durum');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('cari_id', $id);
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('islem_turu', 'dropdown',
                array('2' => 'Borç Alacak', '3' => 'Tahsilat Ödeme', '4' => 'Fatura'));

            $crud->field_type('giris_cikis', 'dropdown',
                array('0' => 'Cari Alacaklı', '1' => 'Cari Borçlu'));
            $crud->callback_column('vade_tarihi', array($this, 'vade_tarihi_getir'));
            $crud->callback_column('tutar', array($this, 'tutar_getir'));
            $crud->callback_column('islem_turu', array($this, 'islem_turu_getir'));
            $crud->callback_column('son_durum', array($this, 'son_durum_getir'));

            $crud->unset_clone();
            $crud->unset_edit();
              $crud->unset_read();          
            $crud->unset_add();
            $crud->unset_back_to_list();
            $crud->unset_delete();

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $crud->unset_read_fields("islem_turu", "relation_type", "relation_id", "giris_cikis", "tutar", "tarih", "kategori", "cari_id"
                , "kasa_id", "kullanici_id");

            $data['side_menu'] = "Cari İşlemleri Ayarları";
            $data['kilavuz']   = "  <b>Cari İşlemleri Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function son_durum_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            $this->load->model('admin_model');
            $cari_baslangic       = $this->admin_model->cari_baslangic($row->cari_id, $this->session->userdata('kullanici_id'));
            $cari_baslangic_durum = $this->admin_model->cari_baslangic_durum($row->cari_id, $this->session->userdata('kullanici_id'));

            if ($cari_baslangic_durum == 0) {} else { $cari_baslangic = 0 - $cari_baslangic;}

            $cari_toplam_getir = $this->admin_model->cari_toplam_getir_sondurum($row->cari_id, $this->session->userdata('kullanici_id'), $row->id);

            //    $cari_baslangic=0;
            if ($cari_toplam_getir): foreach ($cari_toplam_getir as $dizi):

                    if ($dizi["islem_turu"] == 0) {continue;}
                    if ($dizi["islem_turu"] == 1) {continue;}
                    if ($dizi["islem_turu"] == 2) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                    }

                    if ($dizi["islem_turu"] == 3) {

                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}

                    }
                    if ($dizi["islem_turu"] == 4) {
                        if ($dizi["giris_cikis"] == 0) {
                            $cari_baslangic = $cari_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $cari_baslangic = $cari_baslangic + $dizi["tutar"];
                            continue;}
                    }

                endforeach;endif;

            if ($cari_baslangic < 0) {
                $cari_baslangic = $cari_baslangic + $cari_baslangic * -2;
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Alacaklısınız";
            }
            if ($cari_baslangic == 0) {
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borç ve Alacak yok";
            }
            if ($cari_baslangic > 0) {
                return "" . round($cari_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Borçlusunuz";
            }

        }

    }

    public function cari_islem_git($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud = new grocery_CRUD();
            $this->load->model('admin_model');
            $yetki_kontrol_cari_detay = $this->admin_model->yetki_kontrol_cari_detay($this->session->userdata('kullanici_id'), $id);

            if ($yetki_kontrol_cari_detay != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('cari_gecmis');

            $crud->set_subject('Cari Geçmiş İşlem');
            $crud->columns('cari_id', 'islem_tarihi', 'baslik');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('cari_id', $id);
            $crud->display_as('cari_id', "Cari Adı");
            $crud->display_as('islem_tarihi', "İşlem Tarihi");
            $crud->display_as('baslik', "İşlem");
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('cari_id', 'hidden', $id);
            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->unset_back_to_list();
            $crud->unset_clone();

            $data['side_menu'] = "Cari Geçmiş İşlem Görünüm Ayarları";
            $data['kilavuz']   = "  <b>Cari Geçmiş İşlem Görünüm  Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            $this->load->view('index', (array) $output);

        }

    }

    public function stok_detay()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('hizmet_urun');

            $crud->set_subject('Cari Durum');
            $crud->columns('adi', 'durum', 'potansiyel_satis_degeri', 'potansiyel_kar', 'detay');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('durum', array($this, 'stok_durum_getir'));
            $crud->callback_column('potansiyel_satis_degeri', array($this, 'stok_satis_degeri_getir'));
            $crud->callback_column('potansiyel_kar', array($this, 'stok_kar_getir'));
            $crud->callback_column('detay', array($this, 'stok_detay_getir'));

            $crud->unset_add();
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Stok Görünüm Ayarları";
            $data['kilavuz']   = "  <b>Stok Görünüm  Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function stok_durum_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $stok_baslangic = $this->admin_model->stok_baslangic($row->id, $this->session->userdata('kullanici_id'));

            $stok_toplam_getir = $this->admin_model->stok_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            $irs_toplam_getir = $this->admin_model->irs_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            if (($irs_toplam_getir == "") and ($stok_toplam_getir == "")) {

                return $stok_baslangic;
            }

            if ($irs_toplam_getir != "") {

                $say   = count($irs_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $irs_toplam_getir[$i]["islem_turu"] = "irsaliye";

                    $irs_toplam_getir[$i]["fatura_turu"] = $this->admin_model->fatura_turu_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $irs_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {
                $irs_toplam_getir[] = "";

            }

            if ($stok_toplam_getir != "") {

                $say   = count($stok_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $stok_toplam_getir[$i]["islem_turu"] = "fatura";

                    $stok_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $stok_toplam_getir[$i]["irsaliye_durum"] = $this->admin_model->fatura_irs_durum_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {

                $stok_toplam_getir[] = "";
            }

            $stokhareket = array_merge($stok_toplam_getir, $irs_toplam_getir);

            $say   = count($stokhareket);
            $donus = $say - 1;

            for ($i = 0; $i <= $donus; $i++) {

                if ($stokhareket[$i] == "") {unset($stokhareket[$i]);}

            }

            $fatura_tarihi = array_column($stokhareket, 'fatura_tarihi');
            array_multisort($fatura_tarihi, SORT_ASC, $stokhareket);

            $n = 0;if ($stokhareket): foreach ($stokhareket as $dizi):

                    if ($dizi["fatura_turu"] == "Gider") {continue;}

                    if ($dizi["islem_turu"] == "fatura") {

                        if ($dizi["irsaliye_durum"] == 1) {
                            $stok_baslangic . '<br>';
                            $n = $n + 1;
                            continue;
                        }

                    }

                    if ($dizi["fatura_turu"] == "Satış") {$stok_baslangic = $stok_baslangic - $dizi["adet"];}
                    if ($dizi["fatura_turu"] == "Alış") {$stok_baslangic = $stok_baslangic + $dizi["adet"];}
                    $stok_baslangic . '<br>';
                    $n = $n + 1;
                    continue;

                    $n = $n + 1;endforeach;endif;

            return $stok_baslangic;

        }

    }

    public function stok_satis_degeri_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $stok_baslangic = $this->admin_model->stok_baslangic($row->id, $this->session->userdata('kullanici_id'));

            $satis_fiyat = $this->admin_model->satis_fiyat($row->id, $this->session->userdata('kullanici_id'));

            $stok_toplam_getir = $this->admin_model->stok_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            $irs_toplam_getir = $this->admin_model->irs_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            if (($irs_toplam_getir == "") and ($stok_toplam_getir == "")) {

                if ($stok_baslangic <= 0) {return "0.00";} else {
                    return $stok_baslangic * $satis_fiyat;

                }

            }

            if ($irs_toplam_getir != "") {

                $say   = count($irs_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $irs_toplam_getir[$i]["islem_turu"] = "irsaliye";

                    $irs_toplam_getir[$i]["fatura_turu"] = $this->admin_model->fatura_turu_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $irs_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {
                $irs_toplam_getir[] = "";

            }

            if ($stok_toplam_getir != "") {

                $say   = count($stok_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $stok_toplam_getir[$i]["islem_turu"] = "fatura";

                    $stok_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $stok_toplam_getir[$i]["irsaliye_durum"] = $this->admin_model->fatura_irs_durum_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {

                $stok_toplam_getir[] = "";
            }

            $stokhareket = array_merge($stok_toplam_getir, $irs_toplam_getir);

            $say   = count($stokhareket);
            $donus = $say - 1;

            for ($i = 0; $i <= $donus; $i++) {

                if ($stokhareket[$i] == "") {unset($stokhareket[$i]);}

            }

            $fatura_tarihi = array_column($stokhareket, 'fatura_tarihi');
            array_multisort($fatura_tarihi, SORT_ASC, $stokhareket);

            $n = 0;if ($stokhareket): foreach ($stokhareket as $dizi):

                    if ($dizi["fatura_turu"] == "Gider") {continue;}

                    if ($dizi["islem_turu"] == "fatura") {

                        if ($dizi["irsaliye_durum"] == 1) {
                            $stok_baslangic . '<br>';
                            $n = $n + 1;
                            continue;
                        }

                    }

                    if ($dizi["fatura_turu"] == "Satış") {$stok_baslangic = $stok_baslangic - $dizi["adet"];}
                    if ($dizi["fatura_turu"] == "Alış") {$stok_baslangic = $stok_baslangic + $dizi["adet"];}
                    $stok_baslangic . '<br>';
                    $n = $n + 1;
                    continue;

                    $n = $n + 1;endforeach;endif;

            if ($stok_baslangic <= 0) {return "0.00";} else {
                return $stok_baslangic * $satis_fiyat;

            }

        }

    }

    public function stok_kar_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $stok_baslangic = $this->admin_model->stok_baslangic($row->id, $this->session->userdata('kullanici_id'));

            $satis_fiyat = $this->admin_model->satis_fiyat($row->id, $this->session->userdata('kullanici_id'));

            $alis_fiyat = $this->admin_model->alis_fiyat($row->id, $this->session->userdata('kullanici_id'));

            $stok_toplam_getir = $this->admin_model->stok_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            $irs_toplam_getir = $this->admin_model->irs_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            if (($irs_toplam_getir == "") and ($stok_toplam_getir == "")) {

                //     return $stok_baslangic;

                if ($stok_baslangic <= 0) {return "0.00";} else {
                    $kar = $satis_fiyat - $alis_fiyat;
                    return $stok_baslangic * $kar;

                }

            }

            if ($irs_toplam_getir != "") {

                $say   = count($irs_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $irs_toplam_getir[$i]["islem_turu"] = "irsaliye";

                    $irs_toplam_getir[$i]["fatura_turu"] = $this->admin_model->fatura_turu_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $irs_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {
                $irs_toplam_getir[] = "";

            }

            if ($stok_toplam_getir != "") {

                $say   = count($stok_toplam_getir);
                $dongu = $say - 1;
                for ($i = 0; $i <= $dongu; $i++) {

                    $stok_toplam_getir[$i]["islem_turu"] = "fatura";

                    $stok_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    $stok_toplam_getir[$i]["irsaliye_durum"] = $this->admin_model->fatura_irs_durum_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                }

            } else {

                $stok_toplam_getir[] = "";
            }

            $stokhareket = array_merge($stok_toplam_getir, $irs_toplam_getir);

            $say   = count($stokhareket);
            $donus = $say - 1;

            for ($i = 0; $i <= $donus; $i++) {

                if ($stokhareket[$i] == "") {unset($stokhareket[$i]);}

            }

            $fatura_tarihi = array_column($stokhareket, 'fatura_tarihi');
            array_multisort($fatura_tarihi, SORT_ASC, $stokhareket);

            $n = 0;if ($stokhareket): foreach ($stokhareket as $dizi):

                    if ($dizi["fatura_turu"] == "Gider") {continue;}

                    if ($dizi["islem_turu"] == "fatura") {

                        if ($dizi["irsaliye_durum"] == 1) {
                            $stok_baslangic . '<br>';
                            $n = $n + 1;
                            continue;
                        }

                    }

                    if ($dizi["fatura_turu"] == "Satış") {$stok_baslangic = $stok_baslangic - $dizi["adet"];}
                    if ($dizi["fatura_turu"] == "Alış") {$stok_baslangic = $stok_baslangic + $dizi["adet"];}
                    $stok_baslangic . '<br>';
                    $n = $n + 1;
                    continue;

                    $n = $n + 1;endforeach;endif;

            if ($stok_baslangic <= 0) {return "0.00";} else {
                $kar = $satis_fiyat - $alis_fiyat;
                return $stok_baslangic * $kar;

            }

        }

    }

    public function stok_detay_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/stok_detay_git/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function stok_detay_git($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $stok_baslangic         = $this->admin_model->stok_baslangic($id, $this->session->userdata('kullanici_id'));
            $data["stok_baslangic"] = $stok_baslangic;
            $data["stok_id"]        = $id;

            $data["stok_adi"] = $this->admin_model->stok_adi($id, $this->session->userdata('kullanici_id'));

            $stok_toplam_getir = $this->admin_model->stok_toplam_getir($id, $this->session->userdata('kullanici_id'));

            $irs_toplam_getir = $this->admin_model->irs_toplam_getir($id, $this->session->userdata('kullanici_id'));

            $iliski_irs_getir = $this->admin_model->iliski_irs_getir($this->session->userdata('kullanici_id'));

            $iliski_ft_getir = $this->admin_model->iliski_ft_getir($this->session->userdata('kullanici_id'));

            if (($irs_toplam_getir == "") and ($stok_toplam_getir == "")) {

                $data["stokhareket"]    = 0;
                $data["stok_baslangic"] = $stok_baslangic;

            } else {

                if ($irs_toplam_getir != "") {

                    $say   = count($irs_toplam_getir);
                    $dongu = $say - 1;
                    for ($i = 0; $i <= $dongu; $i++) {

                        $irs_toplam_getir[$i]["islem_turu"] = "irsaliye";

                        $irs_toplam_getir[$i]["fatura_turu"] = $this->admin_model->fatura_turu_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                        $irs_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_irs($irs_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    }

                } else {
                    $irs_toplam_getir[] = "";

                }

                if ($stok_toplam_getir != "") {

                    $say   = count($stok_toplam_getir);
                    $dongu = $say - 1;
                    for ($i = 0; $i <= $dongu; $i++) {

                        $stok_toplam_getir[$i]["islem_turu"] = "fatura";

                        $stok_toplam_getir[$i]["fatura_tarihi"] = $this->admin_model->fatura_tar_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                        $stok_toplam_getir[$i]["irsaliye_durum"] = $this->admin_model->fatura_irs_durum_getir_fat($stok_toplam_getir[$i]["fatura_id"], $this->session->userdata('kullanici_id'));

                    }

                } else {
                    $stok_toplam_getir[] = "";

                }

                $stokhareket = array_merge($stok_toplam_getir, $irs_toplam_getir);

                $say   = count($stokhareket);
                $donus = $say - 1;

                for ($i = 0; $i <= $donus; $i++) {

                    if ($stokhareket[$i] == "") {unset($stokhareket[$i]);}

                }

                $fatura_tarihi = array_column($stokhareket, 'fatura_tarihi');
                array_multisort($fatura_tarihi, SORT_ASC, $stokhareket);
                $data["stokhareket"]    = $stokhareket;
                $data["stok_baslangic"] = $stok_baslangic;

                $n = 0;if ($stokhareket): foreach ($stokhareket as $dizi):
                        if ($dizi["fatura_turu"] == "Gider") {continue;}

                        if ($dizi["islem_turu"] == "fatura") {

                            if ($dizi["irsaliye_durum"] == 1) {
                                $stok_baslangic . '<br>';
                                $n = $n + 1;
                                continue;
                            }

                        }

                        if ($dizi["fatura_turu"] == "Satış") {$stok_baslangic = $stok_baslangic - $dizi["adet"];}
                        if ($dizi["fatura_turu"] == "Alış") {$stok_baslangic = $stok_baslangic + $dizi["adet"];}
                        $stok_baslangic . '<br>';
                        $n = $n + 1;
                        continue;

                        $n = $n + 1;endforeach;endif;
            }
            $this->load->view('stokhareket', $data);

            return false;

            echo $data["stok_total"] = "Stoğunuzda " . $stok_baslangic . " adet ürün bulunmaktadır";

            return false;

            $crud->callback_column('islem_turu', array($this, 'stok_islem_turu_getir'));
            $crud->callback_column('fatura_id', array($this, 'stok_fatura_git'));

            $crud->set_theme('flexigrid');
            $crud->set_table('fatura_item');

            $crud->set_subject('Stok İşlemleri');
            $crud->columns('islem_turu', 'fatura_id', 'adet');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('hizmet_urun_id', $id);
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->unset_clone();
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Stok İşlemleri Ayarları";
            $data['kilavuz']   = "  <b>Stok İşlemleri Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function stok_islem_turu_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            return $fatura_turu_getir = $this->admin_model->fatura_turu_getir($row->fatura_id, $this->session->userdata('kullanici_id'));

        }

    }

    public function stok_fatura_git($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            return "<a class='btn btn-default' href='" . site_url('yonetim/fatura/read/' . $row->fatura_id) . "'>Görüntüle</a>";

        }

    }

    public function islem_turu_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
            if ($row->islem_turu == 2) {
                if ($row->giris_cikis == 0) {

                    //  return "Cari alacaklandırıldı";
                    return "Alacak Dekontu";

                }

                if ($row->giris_cikis == 1) {

                    //  return "Cari borçlandırıldı";
                    return "Borç Dekontu";

                }

            }

            if ($row->islem_turu == 3) {
                if ($row->giris_cikis == 0) {

                    return "Ödeme Yapıldı";

                }

                if ($row->giris_cikis == 1) {

                    return "Tahsil edildi";

                }

            }

            if ($row->islem_turu == 4) {
                if ($row->giris_cikis == 0) {

                    return "Satış Faturası";

                }

                if ($row->giris_cikis == 1) {

                    return "Alış Faturası";

                }

            }

        }

    }

    public function vade_tarihi_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            if ($row->relation_type == "Borç_Alacak") {
                return $vade_tarihi_getir = $this->admin_model->vade_tarihi_getir($row->relation_id, $this->session->userdata('kullanici_id'));

            }

            if ($row->relation_type == "Fatura") {
                return $vade_tarihi_getir = $this->admin_model->vade_tarihi_getir_fatura($row->relation_id, $this->session->userdata('kullanici_id'));

            }

        }

    }

    public function tutar_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return round($row->tutar, 2) . " " . $this->session->userdata('para_birim') . "";

        }

    }

    public function kasa_detay()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            $this->load->model('admin_model');

            $crud->set_theme('flexigrid');
            $crud->set_table('kasa');

            $crud->set_subject('Kasa Durum');
            $crud->columns('adi', 'durum', 'detay');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->callback_column('durum', array($this, 'kasa_durum_getir'));
            $crud->callback_column('detay', array($this, 'kasa_detay_getir'));

            $crud->unset_add();
            $crud->unset_delete();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "Kasa Giriş Çıkış Görünüm Ayarları";
            $data['kilavuz']   = "  <b>Kasa Giriş Çıkış Görünüm Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function kasa_durum_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $kasa_baslangic    = $this->admin_model->kasa_baslangic($row->id, $this->session->userdata('kullanici_id'));
            $kasa_toplam_getir = $this->admin_model->kasa_toplam_getir($row->id, $this->session->userdata('kullanici_id'));

            if ($kasa_toplam_getir): foreach ($kasa_toplam_getir as $dizi):

                    if ($dizi["islem_turu"] == 0) {

                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}

                    }
                    if ($dizi["islem_turu"] == 1) {

                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}

                    }

                    if ($dizi["islem_turu"] == 3) {
                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}
                    }

                endforeach;endif;

            if ($kasa_baslangic < 0) {
                $kasa_baslangic = $kasa_baslangic + $kasa_baslangic * -2;
                return "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Kasa Ekside";
            }
            if ($kasa_baslangic == 0) {
                return "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Kasa Boş";
            }
            if ($kasa_baslangic > 0) {
                return "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Mevcut";
            }

        }

    }

    public function kasa_detay_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/kasa_detay_git/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function kasa_detay_git($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_islem = $this->admin_model->yetki_kontrol_islem($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_islem != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            if ($state == 'list') {

                $this->load->model('admin_model');
                $yetki_kontrol_kasa_detay = $this->admin_model->yetki_kontrol_kasa_detay($this->session->userdata('kullanici_id'), $id);

                if ($yetki_kontrol_kasa_detay != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $this->load->model('admin_model');
            $kasa_baslangic         = $this->admin_model->kasa_baslangic($id, $this->session->userdata('kullanici_id'));
            $data["kasa_baslangic"] = $kasa_baslangic;
            $data["kasa_adi"]       = $this->admin_model->kasa_adi($id, $this->session->userdata('kullanici_id'));
            $kasa_toplam_getir      = $this->admin_model->kasa_toplam_getir($id, $this->session->userdata('kullanici_id'));

            if ($kasa_toplam_getir): foreach ($kasa_toplam_getir as $dizi):

                    if ($dizi["islem_turu"] == 0) {

                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}

                    }
                    if ($dizi["islem_turu"] == 1) {

                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}

                    }

                    if ($dizi["islem_turu"] == 3) {
                        if ($dizi["giris_cikis"] == 0) {
                            $kasa_baslangic = $kasa_baslangic - $dizi["tutar"];
                            continue;}
                        if ($dizi["giris_cikis"] == 1) {
                            $kasa_baslangic = $kasa_baslangic + $dizi["tutar"];
                            continue;}
                    }

                endforeach;endif;

            if ($kasa_baslangic < 0) {
                $kasa_baslangic     = $kasa_baslangic + $kasa_baslangic * -2;
                $data["kasa_total"] = "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Kasa Ekside";
            } else if ($kasa_baslangic == 0) {
                $data["kasa_total"] = "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Kasa Boş";
            } elseif ($kasa_baslangic > 0) {
                $data["kasa_total"] = "" . round($kasa_baslangic, 2) . " " . $this->session->userdata('para_birim') . " Mevcut";
            } else {}

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Kasa İşlemleri');
            $crud->columns('islem_turu', 'giris_cikis', 'tarih', 'tutar');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kasa_id', $id);
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('islem_turu', 'dropdown',
                array('0' => 'Gelir Gider', '2' => 'Borç Alacak', '3' => 'Tahsilat Ödeme'));

            $crud->field_type('giris_cikis', 'dropdown',
                array('0' => 'Kasadan çıkış', '1' => 'Kasaya giriş'));
            $crud->callback_column('tutar', array($this, 'tutar_getir'));
            $crud->unset_clone();
            $crud->unset_edit();
            $crud->unset_add();
            $crud->unset_back_to_list();
            $crud->unset_delete();

            $this->crud_status($crud, 0, 0, 1, 0); // add edit read delete

            $crud->unset_read_fields("islem_turu", "relation_type", "relation_id", "giris_cikis", "tutar", "tarih", "kategori", "cari_id"
                , "kasa_id", "kullanici_id");

            $data['side_menu'] = "Kasa İşlemleri Ayarları";
            $data['kilavuz']   = "  <b>Kasa İşlemleri Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function tahsilat_odeme($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gelir_gider = $this->admin_model->yetki_kontrol_gelir_gider($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gelir_gider != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gelir_gider = $this->admin_model->yetki_kontrol_gelir_gider($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gelir_gider != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);
                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Tahsilat - Ödeme');
            $crud->columns('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('islem_turu', 3);
            $crud->required_fields('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id', 'aciklama');
            $crud->unset_fields('kategori');
            $crud->display_as('kasa_id', 'Kasa Banka');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('giris_cikis', 'Tahsilat - Ödeme');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('islem_turu', 'hidden', 3);
            $crud->field_type('relation_type', 'hidden', 'Tahsilat-Ödeme');
            $crud->field_type('relation_id', 'hidden', 0);
            $crud->field_type('giris_cikis', 'dropdown',
                array('1' => 'Tahsilat', '0' => 'Ödeme'));
            $crud->field_type('gelir_gider_fat', 'hidden', 0);

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_column('kasa_id', array($this, 'callback_kasa_getir'));

            $this->log_grocery($crud, "Tahsilat Ödeme", "islem");

            $crud->unset_back_to_list();
            $crud->unset_delete();
            $crud->unset_clone();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Tahsilat - Ödeme Ayarları";
            $data['kilavuz']   = "  <b>Tahsilat - Ödeme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_kasa_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            //    return $row->cari_id;

            $this->load->model('admin_model');
            $kasa_id = $this->admin_model->kasa_ad($row->kasa_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/kasa/read/' . $row->kasa_id) . "'>" . $kasa_id . "</a>";
        }

    }

    public function cari_tahsilat_odeme($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                $data["cari_adi"] = $this->admin_model->cari_ad($id);
                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $id);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Cari Tahsilat - Ödeme');
            $crud->columns('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('cari_id', $id);
            $crud->where('islem_turu', 3);
            $crud->required_fields('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id', 'aciklama');
            $crud->unset_fields('kategori');
            $crud->display_as('kasa_id', 'Kasa Banka');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('giris_cikis', 'Tahsilat - Ödeme');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->field_type('cari_id', 'hidden', $id);
            $crud->field_type('islem_turu', 'hidden', 3);
            $crud->field_type('relation_type', 'hidden', 'Tahsilat-Ödeme');
            $crud->field_type('gelir_gider_fat', 'hidden', '0');
            $crud->field_type('relation_id', 'hidden', 0);
            $crud->field_type('giris_cikis', 'dropdown',
                array('1' => 'Tahsilat', '0' => 'Ödeme'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_column('kasa_id', array($this, 'callback_kasa_getir'));

            $this->log_grocery($crud, "Cari Tahsilat Ödeme", "islem");

            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Cari Tahsilat - Ödeme Ayarları";
            $data['kilavuz']   = "  <b>Cari Tahsilat - Ödeme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function fatura_tahsilat($edit = null, $fid = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                //    $data["cari_adi"]=$this->admin_model->cari_ad($id);
                $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($fid, $this->session->userdata('kullanici_id'));

                if ($yetki_kontrol_fatura != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $fat = $this->admin_model->fatura_getir_duzenle($fid, $this->session->userdata('kullanici_id'));

                if ($fat): foreach ($fat as $dizi):

                        $cari_id           = $dizi["cari_id"];
                        $data["fatura_no"] = $dizi["fatura_no"];

                    endforeach;endif;

                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Fatura Tahsilat');
            $crud->columns('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id');
            $crud->required_fields('tutar', 'tarih', 'kasa_id', 'aciklama');
            $crud->unset_fields('kategori');
            $crud->display_as('kasa_id', 'Kasa Banka');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('giris_cikis', 'Tahsilat - Ödeme');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->field_type('relation_id', 'hidden', $fid);
            $crud->field_type('islem_turu', 'hidden', 3);
            $crud->field_type('relation_type', 'hidden', 'Tahsilat-Ödeme');
            $crud->field_type('cari_id', 'hidden', $cari_id);
            $crud->field_type('giris_cikis', 'hidden', 1);
            $crud->field_type('gelir_gider_fat', 'hidden', 0);

            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $this->log_grocery($crud, "Fatura Tahsilat", "islem");

            $data['side_menu'] = "Fatura Tahsilat Ayarları";
            $data['kilavuz']   = "  <b>Fatura Tahsilat Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function fatura_odeme($edit = null, $fid = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                //    $data["cari_adi"]=$this->admin_model->cari_ad($id);
                $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($fid, $this->session->userdata('kullanici_id'));

                if ($yetki_kontrol_fatura != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $fat = $this->admin_model->fatura_getir_duzenle($fid, $this->session->userdata('kullanici_id'));

                if ($fat): foreach ($fat as $dizi):

                        $cari_id           = $dizi["cari_id"];
                        $data["fatura_no"] = $dizi["fatura_no"];

                    endforeach;endif;

                $crud->set_relation('kasa_id', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('islem');

            $crud->set_subject('Fatura Ödeme');
            $crud->columns('giris_cikis', 'tutar', 'tarih', 'cari_id', 'kasa_id');
            $crud->required_fields('tutar', 'tarih', 'kasa_id', 'aciklama');
            $crud->unset_fields('kategori');
            $crud->display_as('kasa_id', 'Kasa Banka');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('giris_cikis', 'Tahsilat - Ödeme');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->field_type('relation_id', 'hidden', $fid);
            $crud->field_type('islem_turu', 'hidden', 3);
            $crud->field_type('relation_type', 'hidden', 'Tahsilat-Ödeme');
            $crud->field_type('cari_id', 'hidden', $cari_id);
            $crud->field_type('giris_cikis', 'hidden', 0);
            $crud->field_type('gelir_gider_fat', 'hidden', 0);

            $this->log_grocery($crud, "Fatura Ödeme", "islem");
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete
            $data['side_menu'] = "Fatura Ödeme Ayarları";
            $data['kilavuz']   = "  <b>Fatura Ödeme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function cari_borc_alacak($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_cari')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                $data["cari_adi"] = $this->admin_model->cari_ad($id);
                $this->load->model('admin_model');
                $yetki_kontrol_cari = $this->admin_model->yetki_kontrol_cari($this->session->userdata('kullanici_id'), $id);

                if ($yetki_kontrol_cari != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->display_as('fatura_turu', 'Borç Alacak');
                $crud->field_type('fatura_turu', 'dropdown',
                    array('1' => 'Cari Borçlandır', '0' => 'Cari Alacaklandır'));

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('borc_alacak');

            $crud->set_subject('Cari Borç Alacak');
            $crud->columns('fatura_turu', 'cari', 'toplam', 'vade_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('cari_id', $id);
            $crud->required_fields('fatura_turu', 'cari_id', 'toplam', 'vade_tarihi');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('tarih', 'hidden', date("Y-m-d"));
            $crud->field_type('cari_id', 'hidden', $id);

            $crud->callback_column('cari', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'islem_sil_boal'));
            $crud->callback_after_insert(array($this, 'islem_kayit_boal'));
            $crud->unset_fields("paylasim_turu", "ortak_alan_paylasim_turu", "ortak_alan_yuzdesi");

            $this->log_grocery($crud, "Cari Borç Alacak", "borc_alacak");
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 1, 0, 1, 1); // add edit read delete

            $data['side_menu'] = "Cari Borç Alacak Ayarları";
            $data['kilavuz']   = "  <b>Cari Borç Alacak Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function hesap()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->view('hesap');

        }

    }

    public function kur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->view('kur');
        }

    }

    public function yapilacaklar()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Yapılacaklar Listesi Ayarları";
            $data['kilavuz']   = "  <b>Yapılacaklar Listesi Ayarları</b>";
            $this->load->model('admin_model');
            $data["list"] = $this->admin_model->list_getir($this->session->userdata('id'));

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('yapilacaklar', (array) $output);

        }

    }

    public function log_goruntule()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();
            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Log Görüntüleme Ayarları";
            $data['kilavuz']   = "  <b>Log Görüntüleme Ayarları</b>";
            $this->load->model('admin_model');
            $data["log"] = $this->admin_model->log_getir($this->session->userdata('kullanici_id'));

            $n = 1;if ($data["log"]): foreach ($data["log"] as $dizi):

                    $data["u_ad"][$n] = $this->admin_model->uye_ad($dizi["kim"]);

                    $n = $n + 1;endforeach;endif;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('log', (array) $output);

        }

    }

    public function log_temizle()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $tarih = $this->input->post('tarih', true);
            $tarih = trim($tarih);
            $tarih = strip_tags($tarih);
            $tarih = htmlentities($tarih);

            if (($tarih == "0") or (!is_numeric($tarih))) {

                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim/log_goruntule');
                return false;

            }

            if ($tarih == "11") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-1 hours'));
            }

            if ($tarih == "44") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-4 hours'));
            }

            if ($tarih == "1") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-1 days'));
            }

            if ($tarih == "7") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-7 days'));
            }

            if ($tarih == "30") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-30 days'));
            }

            if ($tarih == "90") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-90 days'));
            }

            if ($tarih == "365") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('Y-m-d H:i:s', strtotime('-365 days'));
            }

            if ($tarih == "100") {
                $bugun   = date("Y-m-d H:i:s");
                $nereden = date('2000-01-01 00:00:00');

            }

            if ($this->session->userdata('yetki') == 0) {

                $this->db->where('tarih>=', $nereden);
                $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
                $this->db->delete('log');

                $this->load->library('Messages');
                echo $this->messages->True_Add('yonetim/log_temizle');
                return false;

            }

            $this->load->library('Messages');
            echo $this->messages->False_Add('yonetim/log_temizle');
            return false;

        }

    }

    public function list_al()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $task   = $this->input->post('task', true);
            $task   = trim($task);
            $task   = strip_tags($task);
            $task   = htmlentities($task);
            $insert = array(
                'task'         => $task,
                'tarih'        => date("Y-m-d"),
                'kim'          => $this->session->userdata('id'),
                'durum'        => 0,
                'kullanici_id' => $this->session->userdata('kullanici_id'),
            );

            $this->db->insert('task', $insert);
//    $this->log("Görev Ekleme","task","Ekleme",$this->db->insert_id());

            $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/yapilacaklar');
            return false;

        }

    }

    public function tasksil($id = null, $kim = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if (!is_numeric($id)) {
                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim/yapilacaklar');
                return false;

            }

            if (!is_numeric($kim)) {

                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim/yapilacaklar');
                return false;

            }

            $this->db->where('id', $id);
            $this->db->where('kim', $kim);
            $this->db->delete('task');
//   $this->log("Görev Silme","task","Silme",0);

            $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/yapilacaklar');
            return false;

        }

    }

    public function sss()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "SSS Ayarları";
            $data['kilavuz']   = "  <b>SSS Ayarları</b>";
            $this->load->model('admin_model');
            $data["sss"] = $this->admin_model->sss_getir();

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('sss', (array) $output);

        }

    }

    public function gorusme($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gorusme = $this->admin_model->yetki_kontrol_gorusme($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gorusme != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_gorusme = $this->admin_model->yetki_kontrol_gorusme($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_gorusme != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('gorusme');

            $crud->set_subject('Görüşme - Arama');
            $crud->columns('tur', 'tarih', 'saat', 'kim', 'kiminle', 'konu');

            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            //     $crud->where('kim',$this->session->userdata('id'));
            $crud->required_fields('konu', 'teklif');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            //       $crud->callback_column('kim',array($this,'callback_cari_getir4'));

            $crud->display_as('teklif', 'Açıklama');
            $crud->field_type('tur', 'dropdown',
                array('0' => 'Arama', '1' => 'Telefon Görüşmesi'));
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->log_grocery($crud, "Gorusme", "gorusme");
            $data['side_menu'] = "Görüşme Ayarları";
            $data['kilavuz']   = "  <b>Görüşme Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function notlar($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_not = $this->admin_model->yetki_kontrol_not($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_not != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_not = $this->admin_model->yetki_kontrol_not($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_not != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('notlar');

            $crud->set_subject('Notlar');
            $crud->columns('tarih', 'konu');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kim', $this->session->userdata('id'));
            $crud->required_fields('konu', 'teklif');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('kim', 'hidden', $this->session->userdata('id'));
            $crud->field_type('tarih', 'hidden', date("Y-m-d"));
            $crud->display_as('teklif', 'Notunuz');
            $crud->unset_back_to_list();
            $crud->unset_clone();
            $this->log_grocery($crud, "Notlar", "notlar");

            $data['side_menu'] = "Not Ayarları";
            $data['kilavuz']   = "  <b>Not Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function zaman($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_not = $this->admin_model->yetki_kontrol_not($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_not != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_not = $this->admin_model->yetki_kontrol_not($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_not != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('zaman');

            $crud->set_subject('Zaman Yönetimi');
            $crud->columns('tarih_bas', 'tarih_bit', 'islem');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('kim', $this->session->userdata('id'));
            $crud->required_fields('tarih_bas', 'tarih_bit', 'islem');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('kim', 'hidden', $this->session->userdata('id'));

            $crud->unset_back_to_list();
            $crud->unset_clone();
            $this->log_grocery($crud, "Zaman", "zaman");

            $data['side_menu'] = "Zaman Yönetimi Ayarları";
            $data['kilavuz']   = "  <b>Zaman Yönetimi Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function takvim()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->view('takvim');
        }

    }

    public function fatura($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
			if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}		
			
			

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('fatura');

            $crud->set_subject('Faturalar');
            $crud->columns('fatura_turu', 'fatura_no', 'cari_id', 'toplam',   'görüntüle', 'personel', 'Sipariş Kaldır');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->display_as('fatura_turu', 'Sipariş Türü');			
            $crud->display_as('fatura_no', 'Sipariş No');
			
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
				
			if($this->session->userdata('uye_turu')==2){$crud->where('personel', $this->session->userdata('cari_id'));}
            			
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));

            $crud->callback_column('Sipariş Kaldır', array($this, 'callback_fat_kaldir'));

            $crud->callback_column('düzenle', array($this, 'fatura_duzenle_link'));
            $crud->callback_column('görüntüle', array($this, 'fatura_goruntule_link'));
            $crud->callback_column('personel', array($this, 'callback_personel_getir'));
            // $crud->set_rules('fatura_turu','Department','callback_aaa_kontrol');
            //     $crud->callback_before_delete(array($this,'fatura_delete'));

            $crud->unset_delete();
            $crud->unset_add();

            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->log_grocery($crud, "Fatura", "fatura");

            $this->crud_status($crud, 0, 0, 1, 0); // add edit read delete

            $data['side_menu'] = "Fatura Ayarları";
            $data['kilavuz']   = "  <b>Fatura Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_fat_kaldir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/fatura_delete/' . $row->id) . "'>Sipariş Kaldır</a>";
        }

    }

    public function fatura_delete($primary_key)
    {
		
				if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

        $k_id = $this->session->userdata('kullanici_id');

        $this->load->model('admin_model');

        $fat_silme_kontrol = $this->admin_model->fat_silme_kontrol($primary_key, $k_id);





        if ($fat_silme_kontrol == 0) {

            $this->load->library('Messages');
            echo $this->messages->False_Cari_Kasa_Delete('yonetim/fatura', "Fatura");
            return false;

        }

  

        $this->db->query('delete from fatura where kullanici_id=' . $k_id . ' and id=' . $primary_key);

        $this->db->query('delete from fatura_item where kullanici_id=' . $k_id . ' and fatura_id=' . $primary_key);
        $this->db->query('delete from islem where kullanici_id=' . $k_id . ' and islem_turu=4 and relation_id=' . $primary_key);
        $this->log("Fatura Silme", "fatura", "Silme", 0);

        $this->load->library('Messages');
        echo $this->messages->True_Add('yonetim/fatura');
        return false;

    }

    public function fatura_duzenle_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            if ($row->fatura_turu == "Gider") {
                return "<a class='btn btn-default' href='" . site_url('yonetim/gider_fatura_duzenle/' . $row->id) . "'>Düzenle</a>";
            }
            return "<a class='btn btn-default' href='" . site_url('yonetim/fatura_duzenle2/' . $row->id) . "'>Düzenle</a>";

        }

    }

    public function fatura_goruntule_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            if ($row->fatura_turu == "Gider") {
                return "<a class='btn btn-default' href='" . site_url('yonetim/gider_fatura_goruntule/' . $row->id) . "'>Görüntüle</a>";
            }
            return "<a class='btn btn-default' href='" . site_url('yonetim/fatura_goruntule/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function satis_fatura_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";
            $this->load->model('admin_model');
			
			//     $uye_turu     = $dizi["uye_turu"];	
			//	    $cari        = $dizi["cari"];	

			
            $data["cari_getir"] = $this->admin_model->tum_cari_getir2($this->session->userdata('kullanici_id'),$this->session->userdata('cari_id'),$this->session->userdata('uye_turu'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('fatura', (array) $output);

        }

    }
	
	
	
	public function ygd()
    {


        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";
            $this->load->model('admin_model');
			
			//     $uye_turu     = $dizi["uye_turu"];	
			//	    $cari        = $dizi["cari"];	

			
            $data["cari_getir"] = $this->admin_model->tum_cari_getir2($this->session->userdata('kullanici_id'),$this->session->userdata('cari_id'),$this->session->userdata('uye_turu'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
	
            //  $this->_example_output($output);
            $this->load->view('ygd', (array) $output);

        }

    }
	
	
	
	
	
	
	
	
	

    //  return FALSE;

    public function alis_fatura_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Alış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"]     = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]     = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"]     = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('fatura', (array) $output);

        }

    }

    public function gider_fatura_olustur()
    {
        //     $this->load->library('messages');
        //    $this->messages->config2('Yonetim/fatura');

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Gider Fatura Ayarları";
            $data['kilavuz']   = "  <b>Gider Fatura Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_gider_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gider_fatura', (array) $output);

        }

    }

    public function irsaliye_getir()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "İrsaliye Fatura Ayarları";
            $data['kilavuz']   = "  <b>İrsaliye Fatura Ayarları</b>";
            $this->load->model('admin_model');

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            if ($mus == "") {

                $this->load->library('messages');
                $this->messages->config2('Yonetim/irs_fat_sec');

            }

            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["irsaliye"]   = $this->admin_model->irs_getir($mus, $fat_turu, $this->session->userdata('kullanici_id'));

            $n = 0;
            if ($data["irsaliye"]): foreach ($data["irsaliye"] as $dizi):

                    $data["fat_durum"][$n] = $this->admin_model->irs_durum_getir($dizi["id"], $fat_id, $this->session->userdata('kullanici_id'));

                    $n = $n + 1;

                endforeach;endif;

//print_r($data["fat_durum"]);
            //return FALSE;

//print_r($data["irsaliye"]);
            //

            $data["musteri_id"] = $mus;
            $data["musteri"]    = $this->admin_model->cari_ad($mus);
            $data["fat_turu"]   = $fat_turu;
            $data["fat_id"]     = $fat_id;

            //  print_r($data["irsaliye"]);
            //  return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('irs_fat_sec', (array) $output);

        }

    }

    public function irs_durum($id, $fat_id, $kul_id)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            //$this->load->model('admin_model');
            $fat_durum = $this->admin_model->irs_fat_durum($id, $this->session->userdata('kullanici_id'));

            if ($fat_durum == 1) {
                return "Açık İrsaliye";
            } else {

                $irs_urun_getir = $this->admin_model->irs_urun_getir($id, $this->session->userdata('kullanici_id'));

                // return $irs_urun_getir[0]["hizmet_urun_id"];

                $iliskili_fat_getir = $this->admin_model->iliskili_fat_getir($id, $this->session->userdata('kullanici_id'));

                $fat_durum = "Açık İrsaliye";
                $i         = 0;if ($irs_urun_getir): foreach ($irs_urun_getir as $dizi):

                        $sonuc[$dizi["hizmet_urun_id"]] = $this->admin_model->irs_urun_top($id, $dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));

                        $urun_id   = $dizi["hizmet_urun_id"];
                        $urun_adet = $sonuc[$dizi["hizmet_urun_id"]];
                        //   return $urun_id."-".$urun_adet;
                        $toplam       = 0;
                        $urun_durum[] = "";

                        if ($iliskili_fat_getir): foreach ($iliskili_fat_getir as $dizi2):

                                $fat_urun_toplam = $this->admin_model->urunler_ft_item_adet($urun_id, $dizi2["fat_id"], $this->session->userdata('kullanici_id'));
                                $toplam          = $toplam + $fat_urun_toplam;

                            endforeach;endif;

                        $toplam;

                        if ($urun_adet > $toplam) {
                            if ($toplam == 0) {

                                $urun_durum[$i] = 2;
                            } else {

                                $urun_durum[$i] = 1;

                            }

                        } else {
                            $urun_durum[$i] = 0;

                        }

                        if ($urun_durum[$i] == 0) {$fat_durum = "Kapalı İrsaliye";}
                        if ($urun_durum[$i] == 1) {$fat_durum = "Kısmi İrsaliye";}

                        $i = $i + 1;endforeach;endif;

                return $fat_durum;

            }

        }}

    public function fat_irs_ekle()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "İrsaliye Fatura Ayarları";
            $data['kilavuz']   = "  <b>İrsaliye Fatura Ayarları</b>";
            $this->load->model('admin_model');

            $irsaliye = $this->input->post('irsaliye', true);

            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $mus_id = $this->input->post('mus_id', true);
            $mus_id = trim($mus_id);
            $mus_id = strip_tags($mus_id);
            $mus_id = htmlentities($mus_id);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            $say = count($irsaliye);

            if ($say == 0) {

                $this->load->library('messages');
                $this->messages->config2('Yonetim/irs_fat_sec');
                return false;

            }

            $data["fatura_getir_duzenle"] = $this->admin_model->fatura_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));

            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));

            $top_alan = count($data["fatura_item_getir_duzenle"]);

            $i = 1;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):

                    $item[$i] = $dizi["hizmet_urun_id"];
                    $qty[$i]  = $dizi["adet"];

                    $i = $i + 1;endforeach;endif;

            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $this->admin_model->fat_irs_iliski_kaydet($fat_id, $irsaliye[$i], $this->session->userdata('kullanici_id'));

                $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($irsaliye[$i], $this->session->userdata('kullanici_id'));
                $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($irsaliye[$i], $this->session->userdata('kullanici_id'));

                $tek_ur[]                          = "";
                $sip_ur[]                          = "";
                $n                                 = 1;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                        $tek_ur[$dizi["hizmet_urun_id"]] = 0;
                        $n                               = $n + 1;endforeach;endif;

                $adet                              = 0;
                $n                                 = 1;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                        $tek_ur[$dizi["hizmet_urun_id"]] = $tek_ur[$dizi["hizmet_urun_id"]] + 1;
                        $sip_ur[$dizi["hizmet_urun_id"]] = 0;

                        for ($i = 1; $i <= $top_alan; $i++) {

                            if ($dizi["hizmet_urun_id"] == $item[$i]) {
                                $sip_ur[$item[$i]] = $sip_ur[$item[$i]] + 1;

                                if ($tek_ur[$dizi["hizmet_urun_id"]] == $sip_ur[$item[$i]]) {

                                    $adet = $qty[$i];

                                    $gnc = $this->admin_model->irs_item_gunc($dizi["id"], $adet, $this->session->userdata('kullanici_id'));

                                }

                            }}

                        $n = $n + 1;endforeach;endif;

            }

            $this->log("Fatura İrsaliye Ekleme", "fatura", "Ekleme", $fat_id);

            $this->load->library('messages');
            $this->messages->True_Add('Yonetim/fatura_goruntule/' . $fat_id);
            return false;

        }

    }

    public function fatura_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
			
			
	    // kişi bilgileri	

	   		
			
	        $ad = htmlentities(strip_tags(trim($this->input->post('ad', true))));
	        $yet = htmlentities(strip_tags(trim($this->input->post('yet', true))));
	        $vd = htmlentities(strip_tags(trim($this->input->post('vd', true))));			
	        $vn = htmlentities(strip_tags(trim($this->input->post('vn', true))));
	        $tc = htmlentities(strip_tags(trim($this->input->post('tc', true))));
	        $ep = htmlentities(strip_tags(trim($this->input->post('ep', true))));
	        $cp = htmlentities(strip_tags(trim($this->input->post('cp', true))));			
	        $tl = htmlentities(strip_tags(trim($this->input->post('tl', true))));
	        $fx = htmlentities(strip_tags(trim($this->input->post('fx', true))));
	        $ilc = htmlentities(strip_tags(trim($this->input->post('ilc', true))));
	        $il = htmlentities(strip_tags(trim($this->input->post('il', true))));			
	        $adr = htmlentities(strip_tags(trim($this->input->post('adr', true))));
	        $fkd = htmlentities(strip_tags(trim($this->input->post('fkd', true))));			
	        $fad = htmlentities(strip_tags(trim($this->input->post('fad', true))));
	        $mn = htmlentities(strip_tags(trim($this->input->post('mn', true))));			

			if($this->input->post('mus', true)==""){
            $mus_kayit = $this->admin_model->mus_kayit($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad, $mn);
            $mus_kayit_id    = $mus_kayit;
			
			}
            else{
            $mus_guncelle = $this->admin_model->mus_guncelle($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad ,$mn, $this->input->post('mus', true));			
			}


			
		// kişi bilgileri			
			
			
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);
			
			if($mus==""){$mus=$mus_kayit_id;}

          /*  $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);
			*/
			$per = $this->session->userdata('cari_id');

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

     

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);
			
			
			

            $fat_kayit = $this->admin_model->fat_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $this->session->userdata('cari_id'));
            $fat_id    = $fat_kayit;


            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "1";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

                $islem_kayit = $this->admin_model->islem_kayit_tahsilat_odeme("3", "Tahsilat-Ödeme", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $this->session->userdata('kullanici_id'));

            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);
				


                $fat_item_kayit = $this->admin_model->fat_item_kayit_tarihli($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu,$duz_ta, $this->session->userdata('kullanici_id'));


                $ekvkn[$i] = $this->input->post('ekvkn_' . $i, true);
                $ekvkn[$i] = trim($ekvkn[$i]);
                $ekvkn[$i] = strip_tags($ekvkn[$i]);
                $ekvkn[$i] = htmlentities($ekvkn[$i]);
				
				if($ekvkn[$i]!=""){
				$ekvkn_kayit = $this->admin_model->ekvkn_kayit($fat_id,$mus,$fat_item_kayit,$item[$i], $ekvkn[$i]);					
				}
				




            }

            /*       $this->load->library('messages');
            $this->messages->config2('Yonetim/fatura');
            return FALSE;
             */

            echo '{"success":true}';

        }

    }

    public function iade_fatura_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $fat_kontrol = $this->admin_model->fat_kontrol($seri, $no);
            if ($fat_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);

            $fat_kayit = $this->admin_model->iade_fat_kayit($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $per);
            $fat_id    = $fat_kayit;

            $this->log("İade Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "0";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

/*
$islem_kayit=$this->admin_model->islem_kayit_tahsilat_odeme("3","Tahsilat-Ödeme",$fat_id,$gircik,$toplam,$duz_ta,$ack,$mus,$kasa,$fat_turu,$this->session->userdata('kullanici_id'));
 */
            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->fat_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/fatura');
return FALSE;
 */

            echo '{"success":true}';

        }

    }

    public function fatura_guncelle()
    {	    
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {
	            $this->load->model('admin_model');		
			
			
		
            $ad = htmlentities(strip_tags(trim($this->input->post('ad', true))));
	        $yet = htmlentities(strip_tags(trim($this->input->post('yet', true))));
	        $vd = htmlentities(strip_tags(trim($this->input->post('vd', true))));			
	        $vn = htmlentities(strip_tags(trim($this->input->post('vn', true))));
	        $tc = htmlentities(strip_tags(trim($this->input->post('tc', true))));
	        $ep = htmlentities(strip_tags(trim($this->input->post('ep', true))));
	        $cp = htmlentities(strip_tags(trim($this->input->post('cp', true))));			
	        $tl = htmlentities(strip_tags(trim($this->input->post('tl', true))));
	        $fx = htmlentities(strip_tags(trim($this->input->post('fx', true))));
	        $ilc = htmlentities(strip_tags(trim($this->input->post('ilc', true))));
	        $il = htmlentities(strip_tags(trim($this->input->post('il', true))));			
	        $adr = htmlentities(strip_tags(trim($this->input->post('adr', true))));
	        $fkd = htmlentities(strip_tags(trim($this->input->post('fkd', true))));			
	        $fad = htmlentities(strip_tags(trim($this->input->post('fad', true))));
	        $mn = htmlentities(strip_tags(trim($this->input->post('mn', true))));	
	        $adm = htmlentities(strip_tags(trim($this->input->post('adm', true))));			

            $mus_guncelle = $this->admin_model->mus_guncelle($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad , $mn, $this->input->post('mus', true));			
		
    	
			
			
			
			


            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "1";}

            $fat_kayit = $this->admin_model->fat_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,$adm, $this->session->userdata('kullanici_id'));

            $this->log("Fatura Güncelle", "fatura", "Güncelleme", $fat_id);

            $islem_kayit = $this->admin_model->islem_gunc_fat($fat_id, "4", "Fatura",  $gircik, $toplam, $duz_ta, $ack, $mus, $this->session->userdata('kullanici_id'));

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                //$fat_item_kayit = $this->admin_model->fat_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));
                $fat_item_kayit = $this->admin_model->fat_item_kayit_tarihli($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu,$duz_ta, $this->session->userdata('kullanici_id'));
	
	            $ekvkn[$i] = $this->input->post('ekvkn_' . $i, true);
                $ekvkn[$i] = trim($ekvkn[$i]);
                $ekvkn[$i] = strip_tags($ekvkn[$i]);
                $ekvkn[$i] = htmlentities($ekvkn[$i]);
				
				if($ekvkn[$i]!=""){
				$ekvkn_kayit = $this->admin_model->ekvkn_kayit($fat_id,$mus,$fat_item_kayit,$item[$i], $ekvkn[$i]);					
				}
				
	
	
	
            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/fatura');
return FALSE;

 */

            echo '{"success":true}';

        }

    }
	
	
	
	
	

    public function fatura_duzenle($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
					if($this->session->userdata('yetki_siparis')!=1){
		
	                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;	
		
	}

            $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];

                endforeach;endif;

            if ($data["fat_turu"] == "Satış") {
                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["fat_turu"] == "Alış") {
                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('fatura_duzenle', (array) $output);

        }

    }
	
	      
	
     public function fatura_duzenle2($id=null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {
			
			
			
		      $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }			
			
			$data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));
			

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
			        $data["cari_id"]  = $dizi["cari_id"];
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];

                endforeach;endif;

            if ($data["fat_turu"] == "Satış") {
                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["fat_turu"] == "Alış") {
                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $data["ek_vkn"][$n] = $this->admin_model->ekvkn_getir($dizi["id"]);					
					
                    $n                   = $n + 1;
					
					
					
                endforeach;endif;	
			
	
			

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
			$data["id"] = $id;

            $data["uye_turu"] = $this->session->userdata('uye_turu');

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            $crud->unset_back_to_list();
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('fatura_duzenle2', (array) $output);

        }

    }


    public function iade($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış Fatura Ayarları";
            $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            $data["cari_getir"]                = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["fat_turu"] == "Gider") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["kasa_getir"] = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('iade', (array) $output);

        }

    }

    public function fatura_goruntule($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["fatura_odeme_getir"] = $this->admin_model->fatura_odeme_getir($id, $this->session->userdata('kullanici_id'));

            $data["fatura_cek_getir"] = $this->admin_model->fatura_cek_getir($id, $this->session->userdata('kullanici_id'));

            $data["fatura_iade_getir"] = $this->admin_model->fatura_iade_getir($id, $this->session->userdata('kullanici_id'));

            $data["fatura_not_getir"] = $this->admin_model->fatura_not_getir('fatura', $id, $this->session->userdata('kullanici_id'));

            if ($data["fatura_iade_getir"]) {
                $say   = count($data["fatura_iade_getir"]);
                $dongu = $say - 1;

                $i                   = 0;
                $data["fatura_iade"] = array();
                for ($n = 0; $n <= $dongu; $n++) {

                    $iade_kontrol = $this->admin_model->iade_kontrol($data["fatura_iade_getir"][$n]["relation_id"], $id, $this->session->userdata('kullanici_id'));

                    if ($iade_kontrol == false) {continue;}

                    $data["fatura_iade"][$i] = $data["fatura_iade_getir"][$n];

                    $i = $i + 1;
                }
            } else {
                $data["fatura_iade"][$n] = array();

            }

            if ($data["fatura_cek_getir"]) {
                $say   = count($data["fatura_cek_getir"]);
                $dongu = $say - 1;

                for ($n = 0; $n <= $dongu; $n++) {

                    $data["fatura_cek_getir"][$n]["cek_id"] = $data["fatura_cek_getir"][$n]["relation_id"];

                    $data["fatura_cek_getir"][$n]["relation_id"] = $this->admin_model->cek_fat_id_getir($data["fatura_cek_getir"][$n]["relation_id"], $this->session->userdata('kullanici_id'));

                }
            } else {
                $data["fatura_cek_getir"] = array();

            }

            if ($data["fatura_odeme_getir"]) {
            } else {

                $data["fatura_odeme_getir"] = array();
            }

            $data["fatura_odeme_getir"] = array_merge($data["fatura_odeme_getir"], $data["fatura_cek_getir"], $data["fatura_iade"]);

            $data["fatura_irsaliye_getir"] = $this->admin_model->fatura_irsaliye_getir($id, $this->session->userdata('kullanici_id'));

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                    $data["iade_fat"] = $dizi["iade_fat"];
                endforeach;endif;

            $data["iade_edilen_fatura_miktari"] = 0;
            if ($data["iade_fat"] != 0) {

                $data["iade_edilen_fatura_miktari"] = $this->admin_model->iade_edilen_fatura_miktari($dizi["iade_fat"], $this->session->userdata('kullanici_id'));

            }

            $data['side_menu'] = $data["fat_turu"] . " Fatura Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " Fatura Ayarları</b>";

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["irsaliyeler"] = "";
            $n                   = 0;if ($data["fatura_irsaliye_getir"]): foreach ($data["fatura_irsaliye_getir"] as $dizi):

                    $data["irsaliyeler"][$n] = $this->admin_model->irs_detay_getir($dizi["irs_id"], $this->session->userdata('kullanici_id'));
                    $n                       = $n + 1;
                endforeach;endif;

            //  print_r($data["irsaliyeler"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('fatura_goruntule', (array) $output);

        }

    }

    public function gider_fatura_duzenle($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Gider Fatura Ayarları";
            $data['kilavuz']   = "  <b>Gider Fatura Ayarları</b>";

            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_gider_urun_getir($this->session->userdata('kullanici_id'));

            $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
                    $data["cari_ad"] = $this->admin_model->cari_ad($dizi["cari_id"]);
                endforeach;endif;

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->gider_kat_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gider_fatura_duzenle', (array) $output);

        }

    }

    public function gider_fatura_goruntule($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_fatura != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Gider Fatura Ayarları";
            $data['kilavuz']   = "  <b>Gider Fatura Ayarları</b>";

            $data["fatura_getir_duzenle"]      = $this->admin_model->fatura_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["fatura_item_getir_duzenle"] = $this->admin_model->fatura_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["fatura_odeme_getir"] = $this->admin_model->fatura_odeme_getir($id, $this->session->userdata('kullanici_id'));

            $data["fatura_not_getir"] = $this->admin_model->fatura_not_getir('gider_fatura', $id, $this->session->userdata('kullanici_id'));

//print_r($data["fatura_odeme_getir"]);
            //return FALSE;

            if ($data["fatura_getir_duzenle"]): foreach ($data["fatura_getir_duzenle"] as $dizi):
                    $data["cari_ad"] = $this->admin_model->cari_ad($dizi["cari_id"]);
                endforeach;endif;

            $n                     = 0;if ($data["fatura_item_getir_duzenle"]): foreach ($data["fatura_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gider_fatura_goruntule', (array) $output);

        }

    }

    public function irsaliye($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('irsaliye');

            $crud->set_subject('Faturalar');
            $crud->columns('fatura_turu', 'irsaliye_no', 'cari_id', 'vade_tarihi', 'düzenle', 'görüntüle', 'irsaliye durumu');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'irsaliye_delete'));
            $crud->callback_column('düzenle', array($this, 'irsaliye_duzenle_link'));
            $crud->callback_column('görüntüle', array($this, 'irsaliye_goruntule_link'));
            $crud->callback_column('irsaliye durumu', array($this, 'irsaliye_durumu_getir'));

            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 1); // add edit read delete

            $data['side_menu'] = "İrsaliye Ayarları";
            $data['kilavuz']   = "  <b>İrsaliye Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function irsaliye_delete($primary_key)
    {

        $k_id = $this->session->userdata('kullanici_id');
        $this->db->query('delete from irsaliye_item where kullanici_id=' . $k_id . ' and fatura_id=' . $primary_key);
        $this->log("İrsaliye Sil", "irsaliye", "Silme", 0);
        return true;

    }

    public function irsaliye_duzenle_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/irsaliye_duzenle/' . $row->id) . "'>Düzenle</a>";

        }

    }

    public function irsaliye_goruntule_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);

            return "<a class='btn btn-default' href='" . site_url('yonetim/irsaliye_goruntule/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function irsaliye_durumu_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            //$this->load->model('admin_model');
            $fat_durum = $this->admin_model->irs_fat_durum($row->id, $this->session->userdata('kullanici_id'));

            if ($fat_durum == 1) {
                return "Açık İrsaliye";
            } else {

                $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($row->id, $this->session->userdata('kullanici_id'));

                $n = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):

                        if ($dizi["adet"] > $dizi["aktarim"]) {
                            return "Kısmi İrsaliye";

                        }

                        $n = $n + 1;
                    endforeach;endif;

                return "Kapalı İrsaliye";

            }

        }

    }

    public function satis_irsaliye_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Satış İrsaliye Ayarları";
            $data['kilavuz']   = "  <b>Satış İrsaliye Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));

            //  print_r($data["urun_getir"]);
            //  return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('irsaliye', (array) $output);

        }

    }

    public function alis_irsaliye_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Alış İrsaliye Ayarları";
            $data['kilavuz']   = "  <b>Alış İrsaliye Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('irsaliye', (array) $output);

        }

    }

    public function irsaliye_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $irs_kontrol = $this->admin_model->irs_kontrol($no);
            if ($kayit_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $il = $this->input->post('il', true);
            $il = trim($il);
            $il = strip_tags($il);
            $il = htmlentities($il);

            $adr = $this->input->post('adr', true);
            $adr = trim($adr);
            $adr = strip_tags($adr);
            $adr = htmlentities($adr);

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_kayit = $this->admin_model->irs_kayit($fat_turu, $mus, $no, $duz_ta, $va_ta, $il, $adr, $ack, $this->session->userdata('kullanici_id'));
            $fat_id    = $fat_kayit;

            $this->log("İrsaliye Kayıt", "irsaliye", "Ekleme", $this->db->insert_id());

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $fat_item_kayit = $this->admin_model->irs_item_kayit($fat_id, $item[$i], $qty[$i], $des[$i], $this->session->userdata('kullanici_id'));

            }

            /*       $this->load->library('messages');
            $this->messages->config2('Yonetim/irsaliye');
            return FALSE;
             */

            echo '{"success":true}';

        }

    }

    public function irsaliye_guncelle()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $il = $this->input->post('il', true);
            $il = trim($il);
            $il = strip_tags($il);
            $il = htmlentities($il);

            $adr = $this->input->post('adr', true);
            $adr = trim($adr);
            $adr = strip_tags($adr);
            $adr = htmlentities($adr);

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

/*
$fat_sil=$this->admin_model->irs_sil($fat_id);

$this->db->where('fatura_id',$f_id);
$this->db->delete('irsaliye_item');
 */

            $fat_kayit = $this->admin_model->irs_guncelle($fat_id, $fat_turu, $mus, $no, $duz_ta, $va_ta, $il, $adr, $ack, $this->session->userdata('kullanici_id'));
//$fat_id=$fat_kayit;
            $this->log("İrsaliye Güncelle", "irsaliye", "Güncelleme", $fat_id);

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->irs_item_kayit($fat_id, $item[$i], $qty[$i], $des[$i], $this->session->userdata('kullanici_id'));

                //print_r($qty[$i]);
            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/irsaliye');
return FALSE;
 */

            echo '{"success":true}';

        }

    }

    public function irsaliye_duzenle($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_irsaliye = $this->admin_model->yetki_kontrol_irsaliye($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_irsaliye != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                  = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                  = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                endforeach;endif;

            $n                     = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " İrsaliye Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " İrsaliye Ayarları</b>";

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('irsaliye_duzenle', (array) $output);

        }

    }

    public function irsaliye_goruntule($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_irsaliye = $this->admin_model->yetki_kontrol_irsaliye($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_irsaliye != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["irsaliye_fatura_getir"] = $this->admin_model->irsaliye_fatura_getir($id, $this->session->userdata('kullanici_id'));

            $data["faturalar"] = "";
            $n                 = 0;if ($data["irsaliye_fatura_getir"]): foreach ($data["irsaliye_fatura_getir"] as $dizi):

                    $data["faturalar"][$n] = $this->admin_model->fat_detay_getir($dizi["fat_id"], $this->session->userdata('kullanici_id'));
                    $n                     = $n + 1;
                endforeach;endif;

            if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi):
                    $data["cari_ad"] = $this->admin_model->cari_ad($dizi["cari_id"]);

                    $data["fat_turu"] = $dizi["fatura_turu"];

                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " İrsaliye Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " İrsaliye Ayarları</b>";

            $n                     = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["fatura_not_getir"] = $this->admin_model->fatura_not_getir('irsaliye', $id, $this->session->userdata('kullanici_id'));

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('irsaliye_goruntule', (array) $output);

        }

    }

    public function genel_rapor()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                $this->load->view('admin_login');
            } else { $this->load->view('admin_register');}

        } else {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Raporlar Ayarları";
            $data['kilavuz']   = "  <b>Raporlar Ayarları</b>";
            $this->load->model('admin_model');

            $this->load->model('admin_model');
//Bugün

            $bas         = $_POST["t1"];
            $bit         = $_POST["t2"];
            $data['bas'] = $_POST["t1"];
            $data['bit'] = $_POST["t2"];

            if (($bas == "") or ($bit == "")) {

                $bas = "2000-01-01";
                $bit = date("Y-m-d");

                $data['bas'] = $bas;
                $data['bit'] = $bit;

            }

            $data['tahsilat'] = $this->admin_model->toplam_tahsilat($bas, $bit);
            $data['odeme']    = $this->admin_model->toplam_odeme($bas, $bit);
            $data['gelir']    = $this->admin_model->toplam_gelir($bas, $bit);
            $data['gider']    = $this->admin_model->toplam_gider($bas, $bit);
            $data['alis']     = $this->admin_model->toplam_alis($bas, $bit);
            $data['satis']    = $this->admin_model->toplam_satis($bas, $bit);
            $data["currency"] = $this->session->userdata('para_birim');

            $data['durum'] = $this->admin_model->toplam_durum($bas, $bit);
            $data['durum'] = $data['durum'] - $this->admin_model->genel_durum_cari($bas, $bit);
            $data['kasa']  = $this->admin_model->toplam_durum_kasa($bas, $bit);
            $data['kasa']  = $data['kasa'] - $this->admin_model->genel_durum_kasa($bas, $bit);

            $tum_urunler                        = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data['toplam_stok_satis_degeri']   = 0.00;
            $n                                  = 0;if ($tum_urunler): foreach ($tum_urunler as $dizi):
                    $tum_urunler[$n]                  = json_decode(json_encode($tum_urunler[$n]), false);
                    $tum_urunler[$n]                  = $this->stok_satis_degeri_getir("", $tum_urunler[$n]);
                    $data['toplam_stok_satis_degeri'] = $data['toplam_stok_satis_degeri'] + $tum_urunler[$n];
                    $n                                = $n + 1;endforeach;endif;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('genel_rapor', (array) $output);

        }

    }

    public function cek_senet($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('cek_senet');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Çek Senet');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('adi', 'Çek Senet Adı');
            $crud->unset_fields('giris_tarihi');
            $crud->display_as('banka', 'Çekin tahsil edileceği Banka (Opsiyonel)');
            $crud->display_as('kasa_banka', 'Çekin aktarılacağı/alınacağı kasa-banka');
            $crud->columns('cari_id', 'vade_tarihi', 'tutar', 'banka', 'İliskili_fatura_git');

            $crud->field_type('tur', 'dropdown',
                array('0' => 'Verilen Çek Senet', '1' => 'Alınan Çek Senet'));
            $crud->field_type('durum', 'dropdown',
                array('0' => 'Tahsil edilmedi', '1' => 'Tahsil edildi'));

            $crud->field_type('islem_id', 'hidden', 0);
            $crud->field_type('islem_tah_id', 'hidden', 0);
            $crud->field_type('fat_id', 'hidden', 0);
            $crud->callback_before_delete(array($this, 'cek_islem_sil'));
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_before_update(array($this, 'cek_islem_guncelle'));
            $crud->callback_after_update(array($this, 'cek_tahsilat_ekle'));
            $crud->callback_column('İliskili_fatura_git', array($this, 'cek_fatura_git'));
            /*        $crud->set_lang_string('update_success_message',
            'İşlem Başarılı.
            <script type="text/javascript">
            window.location = "' . site_url(strtolower(__CLASS__) . '/' . strtolower(__FUNCTION__)) . '";
            </script>
            <div style="display:none">
            '
            );*/
            $crud->required_fields('cari_id', 'vade_tarihi', 'tutar', 'kasa_banka');
            $this->load->model('admin_model');

            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
                $crud->field_type('durum', 'hidden', 0);
                //       $crud->field_type('kasa_banka', 'hidden', 0);

                $crud->set_relation('kasa_banka', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

                //       $crud->required_fields('cari_id', 'vade_tarihi', 'tutar');

            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cek_senet = $this->admin_model->yetki_kontrol_cek_senet($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cek_senet != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }
                $crud->set_rules('vade_tarihi', 'buy Price', 'numeric');
                $crud->required_fields('vade_tarihi', 'tutar', 'kasa_banka');

                $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

                $cek_bilgi_getir = $this->admin_model->cek_bilgi_getir($this->session->userdata('kullanici_id'), $primary_key);

                if ($cek_bilgi_getir): foreach ($cek_bilgi_getir as $dizi):

                        $fat_id = $dizi["fat_id"];

                    endforeach;endif;

                if ($fat_id != 0) {

                    //    $crud->unset_edit_fields('cari_id','tur');
                    $crud->field_type('cari_id', 'hidden');
                    $crud->field_type('tur', 'hidden');
                }

                $crud->set_relation('kasa_banka', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_cek_senet = $this->admin_model->yetki_kontrol_cek_senet($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_cek_senet != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);

                $crud->set_relation('kasa_banka', 'kasa', 'adi', [
                    'kullanici_id = ' => $this->session->userdata('kullanici_id'),
                ]);

            }

            $this->log_grocery($crud, "Çek Senet", "cek_senet");

            $data['side_menu'] = "Çek Senet Ayarları";
            $data['kilavuz']   = "  <b>Çek Senet Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function cek_fatura_git($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if ($row->fat_id != 0) {
                return "<a class='btn btn-default' href='" . site_url('yonetim/fatura_goruntule/' . $row->fat_id) . "'>İlişkili Fatura</a>";
            }

            return false;

        }

    }

    public function cek_tahsilat_ekle($post_array, $primary_key)
    {

        $tahsilat_id = $post_array['islem_tah_id'];

        if ($tahsilat_id == 0) {

            if ($post_array['durum'] == 0) {
                //daha önce tahsilat kaydı yapılmamış şu an yapılmayacak
            }

            if ($post_array['durum'] == 1) {
//daha önce tahsilat kaydı yapılmamış şu an yapılacak

                $insert = array(
                    'islem_turu'      => 3,
                    'relation_type'   => "Tahsilat-Ödeme",
                    'relation_id'     => 0,
                    'giris_cikis'     => $post_array['tur'],
                    'tutar'           => $post_array['tutar'],
                    'tarih'           => date("Y-m-d"),
                    'cari_id'         => $post_array['cari_id'],
                    'kasa_id'         => $post_array['kasa_banka'],
                    'kullanici_id'    => $post_array['kullanici_id'],
                    'gelir_gider_fat' => 0,

                );
                $this->db->insert('islem', $insert);

                $insert = array(
                    'islem_tah_id' => $this->db->insert_id(),
                );

                $this->db->where('id', $primary_key);
                $this->db->update('cek_senet', $insert);

//    $this->log("Çek Tahsilat","cek_senet","Tahsilat",$primary_key);

            }
        } else {

            if ($post_array['durum'] == 0) {
                //daha önce tahsilat kaydı yapılmış şu an silinecek

                $this->db->where('id', $post_array['islem_tah_id']);
                $this->db->delete('islem');

                $insert = array(
                    'islem_tah_id' => 0,
                );

                $this->db->where('id', $primary_key);
                $this->db->update('cek_senet', $insert);
                $this->log("Çek Tahsilat", "cek_senet", "Tahsilat İptal", $primary_key);

            }

            if ($post_array['durum'] == 1) {
//daha önce tahsilat kaydı yapılmış şu an güncellenecek

                $insert = array(
                    'islem_turu'      => 3,
                    'relation_type'   => "Tahsilat-Ödeme",
                    'relation_id'     => 0,
                    'giris_cikis'     => $post_array['tur'],
                    'tutar'           => $post_array['tutar'],
                    'tarih'           => date("Y-m-d"),
                    'cari_id'         => $post_array['cari_id'],
                    'kasa_id'         => $post_array['kasa_banka'],
                    'kullanici_id'    => $post_array['kullanici_id'],
                    'gelir_gider_fat' => 0,

                );

                $this->db->where('id', $post_array['islem_tah_id']);
                $this->db->update('islem', $insert);
                $this->log("Çek Tahsilat", "cek_senet", "Tahsilat", $primary_key);

            }

        }

        return true;
    }

    public function cek_islem_sil($primary_key)
    {

        $sql   = "SELECT * FROM cek_senet Where id=" . $primary_key;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $cek_bilgi = $query->result_array();
        } else {
            return false;
        }

        if ($cek_bilgi): foreach ($cek_bilgi as $dizi):

                $fat_id       = $dizi["fat_id"];
                $islem_id     = $dizi["islem_id"];
                $islem_tah_id = $dizi["islem_tah_id"];
                $durum        = $dizi["durum"];

            endforeach;endif;

        if ($fat_id != 0) {

            $this->db->where('id', $islem_id);
            return $this->db->delete('islem');

        }

        if ($durum != 0) {

            $this->db->where('id', $islem_tah_id);
            return $this->db->delete('islem');

        }

        return true;
    }

    public function cek_islem_guncelle($post_array, $primary_key)
    {

        if ($post_array['fat_id'] != 0) {

            $insert = array(
                'tutar' => $post_array['tutar'],
                'tarih' => $post_array['giris_tarihi'],

            );

            $this->db->where('islem_turu', 5);
            $this->db->where('id', $post_array['islem_id']);
            $this->db->update('islem', $insert);

        }

        if ($post_array['islem_tah_id'] != 0) {

            $insert = array(
                'tutar' => $post_array['tutar'],
            );

            $this->db->where('islem_turu', 3);
            $this->db->where('id', $post_array['islem_tah_id']);
            $this->db->update('islem', $insert);

        }

        return $post_array;
    }

    public function cek_tahsilat($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                //    $data["cari_adi"]=$this->admin_model->cari_ad($id);
                $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

                if ($yetki_kontrol_fatura != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

                $fatura_cari_id_getir = $this->admin_model->fatura_cari_id_getir($id, $this->session->userdata('kullanici_id'));

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('cek_senet');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Çek Senet');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('adi', 'Çek Senet Adı');

            $crud->display_as('banka', 'Banka (Opsiyonel)');
            $crud->columns('cari_id', 'vade_tarihi', 'tutar', 'banka');
            $crud->required_fields('vade_tarihi', 'tutar');

            $crud->field_type('durum', 'hidden', 0);
            $crud->field_type('islem_id', 'hidden', 0);
            $crud->field_type('islem_tah_id', 'hidden', 0);
            $crud->field_type('fat_id', 'hidden', $id);

            $crud->field_type('cari_id', 'hidden', $fatura_cari_id_getir);
            $crud->field_type('tur', 'hidden', 1);
            $crud->field_type('giris_tarihi', 'hidden', date("Y-m-d H:i:s"));
            $crud->unset_fields("kasa_banka");
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_edit();
            $crud->unset_back_to_list();
            $crud->callback_after_insert(array($this, 'islem_cek_kaydet'));
            $this->log_grocery($crud, "Çek Senet Tahsilat", "cek_senet");

            $this->crud_status($crud, 1, 0, 1, 0); // add edit read delete

            $data['side_menu'] = "Çek Senet Ayarları";
            $data['kilavuz']   = "  <b>Çek Senet Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function islem_cek_kaydet($post_array, $primary_key)
    {

        $insert = array(
            'islem_turu'    => 5,
            'relation_type' => "Çek-Senet",
            'relation_id'   => $primary_key,
            'giris_cikis'   => 1,
            'tutar'         => $post_array["tutar"],
            'tarih'         => $post_array["giris_tarihi"],
            'cari_id'       => $post_array["cari_id"],
            'kullanici_id'  => $post_array["kullanici_id"],
        );

        $this->db->insert('islem', $insert);
        $isl_id = $this->db->insert_id();

        $insert = array(
            'islem_id' => $isl_id,
        );

        $this->db->where('id', $primary_key);
        $this->db->update('cek_senet', $insert);

        return true;
    }

    public function cek_odeme($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'list') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'edit') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            } else if ($state == 'read') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'delete') {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            if ($state == 'add') {

                $this->load->model('admin_model');
                //    $data["cari_adi"]=$this->admin_model->cari_ad($id);
                $yetki_kontrol_fatura = $this->admin_model->yetki_kontrol_fatura($id, $this->session->userdata('kullanici_id'));

                if ($yetki_kontrol_fatura != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

                $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

                $fatura_cari_id_getir = $this->admin_model->fatura_cari_id_getir($id, $this->session->userdata('kullanici_id'));

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('cek_senet');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Çek Senet');
            $crud->display_as('cari_id', 'Cari');
            $crud->display_as('adi', 'Çek Senet Adı');

            $crud->display_as('banka', 'Banka (Opsiyonel)');
            $crud->columns('cari_id', 'vade_tarihi', 'tutar', 'banka');
            $crud->required_fields('vade_tarihi', 'tutar');

            $crud->field_type('durum', 'hidden', 0);
            $crud->field_type('islem_id', 'hidden', 0);
            $crud->field_type('islem_tah_id', 'hidden', 0);
            $crud->field_type('fat_id', 'hidden', $id);
            $crud->field_type('tur', 'hidden', 0);
            $crud->field_type('cari_id', 'hidden', $fatura_cari_id_getir);
            $crud->field_type('giris_tarihi', 'hidden', date("Y-m-d H:i:s"));
            $crud->unset_fields("kasa_banka");
            $crud->unset_clone();
            $crud->unset_delete();
            $crud->unset_edit();
            $crud->unset_back_to_list();
            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_after_insert(array($this, 'islem_cek_kaydet_2'));
            $this->log_grocery($crud, "Çek Senet Ödeme", "cek_senet");

            $this->crud_status($crud, 1, 0, 1, 0); // add edit read delete

            $data['side_menu'] = "Çek Senet Ayarları";
            $data['kilavuz']   = "  <b>Çek Senet Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);
        }
    }

    public function islem_cek_kaydet_2($post_array, $primary_key)
    {

        $insert = array(
            'islem_turu'    => 5,
            'relation_type' => "Çek-Senet",
            'relation_id'   => $primary_key,
            'giris_cikis'   => 0,
            'tutar'         => $post_array["tutar"],
            'tarih'         => $post_array["giris_tarihi"],
            'cari_id'       => $post_array["cari_id"],
            'kullanici_id'  => $post_array["kullanici_id"],
        );

        $this->db->insert('islem', $insert);
        $isl_id = $this->db->insert_id();

        $insert = array(
            'islem_id' => $isl_id,
        );

        $this->db->where('id', $primary_key);
        $this->db->update('cek_senet', $insert);

        return true;
    }

    public function fatura_not_al()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $task     = $this->input->post('task', true);
            $task     = trim($task);
            $task     = strip_tags($task);
            $task     = htmlentities($task);
            $fat_id   = $this->input->post('fat_id', true);
            $fat_id   = trim($fat_id);
            $fat_id   = strip_tags($fat_id);
            $fat_id   = htmlentities($fat_id);
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $insert = array(
                'tarih'        => date("Y-m-d"),
                'aciklama'     => $task,
                'fat_turu'     => $fat_turu,
                'fat_id'       => $fat_id,
                'kullanici_id' => $this->session->userdata('kullanici_id'),
            );

            $this->db->insert('fatura_not', $insert);
            $this->log($fat_turu . "Not Kaydı", "notlar", "Ekleme", $fat_id);

            $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/' . $fat_turu . '_goruntule/' . $fat_id);
            return false;

        }

    }

    public function fat_not_sil($fat_turu = null, $fat_id = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $fat_id   = trim($fat_id);
            $fat_id   = strip_tags($fat_id);
            $fat_id   = htmlentities($fat_id);
            $id       = trim($id);
            $id       = strip_tags($id);
            $id       = htmlentities($id);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            if (!is_numeric($id)) {

                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim');
                return false;

            }

            if (!is_numeric($fat_id)) {

                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim');
                return false;

            }

            if (($fat_turu != 'fatura') and ($fat_turu != 'gider_fatura') and ($fat_turu != 'irsaliye') and ($fat_turu != 'siparis') and ($fat_turu != 'teklif')) {

                $this->load->library('Messages');
                echo $this->messages->False_Add('yonetim');
                return false;

            }

            $this->db->where('fat_turu', $fat_turu);
            $this->db->where('id', $id);
            $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $this->db->delete('fatura_not');
            $this->log($fat_turu . " Not Silme", "notlar", "Silme", 0);

            $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/' . $fat_turu . '_goruntule/' . $fat_id);
            return false;

        }

    }

    public function siparis($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('siparis');

            $crud->set_subject('Siparişler');
            $crud->columns('fatura_turu', 'fatura_no', 'cari_id', 'toplam', 'vade_tarihi', 'düzenle', 'görüntüle', 'siparis durumu');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'siparis_delete'));
            $crud->callback_column('düzenle', array($this, 'siparis_duzenle_link'));
            $crud->callback_column('görüntüle', array($this, 'siparis_goruntule_link'));
            $crud->callback_column('siparis durumu', array($this, 'siparis_durumu_getir'));

            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 1); // add edit read delete

            $data['side_menu'] = "Sipariş Ayarları";
            $data['kilavuz']   = "  <b>Sipariş Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function siparis_delete($primary_key)
    {

        $k_id = $this->session->userdata('kullanici_id');
        $this->db->query('delete from siparis_item where kullanici_id=' . $k_id . ' and fatura_id=' . $primary_key);
        $this->log("Sipariş Silme", "siparis", "Silme", 0);
        return true;

    }

    public function siparis_duzenle_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            return "<a class='btn btn-default' href='" . site_url('yonetim/siparis_duzenle/' . $row->id) . "'>Düzenle</a>";

        }}

    public function siparis_goruntule_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            return "<a class='btn btn-default' href='" . site_url('yonetim/siparis_goruntule/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function siparis_durumu_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($row->id, $this->session->userdata('kullanici_id'));

            $n = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):

                    if ($dizi["aktarim"] == 0) {continue;}

                    $n = $n + 1;
                endforeach;endif;

            if ($n == 0) {return "Açık Sipariş";}

            $n = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):

                    if ($dizi["adet"] > $dizi["aktarim"]) {
                        return "Kısmi Sipariş";

                    }

                    $n = $n + 1;
                endforeach;endif;

            return "Kapalı Sipariş";

        }

    }

    public function gelen_siparis_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Sipariş Ayarları";
            $data['kilavuz']   = "  <b>Sipariş Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["tur"]        = "GelenSiparis";
            $data["sip_tur"]    = "Alınan Sipariş";
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('siparis', (array) $output);

        }

    }

    public function giden_siparis_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Sipariş Ayarları";
            $data['kilavuz']   = "  <b>Sipariş Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["tur"]        = "GidenSiparis";
            $data["sip_tur"]    = "Verilen Sipariş";

            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('siparis', (array) $output);

        }

    }

    public function siparis_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $kayit_kontrol = $this->admin_model->kayit_kontrol("siparis", $seri, $no);
            if ($kayit_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->sip_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $this->session->userdata('kullanici_id'));
            $fat_id    = $fat_kayit;

            $this->log("Sipariş Kayıt", "siparis", "Ekleme", $this->db->insert_id());

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->sip_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/siparis');
return FALSE;
 */

            echo '{"success":true}';

        }

    }

    public function siparis_duzenle($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Siparis Ayarları";
            $data['kilavuz']   = "  <b>Siparis Ayarları</b>";

            $data["cari_getir"]                 = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                 = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi):
                    $data["cari_ad"] = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["sip_tur"] = $dizi["fatura_turu"];
                endforeach;endif;

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('siparis_duzenle', (array) $output);

        }

    }

    public function siparis_guncelle()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->sip_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $this->session->userdata('kullanici_id'));

            $this->log("Sipariş Güncelle", "siparis", "Güncelleme", $fat_id);

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->sip_item_kayit2($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/siparis');
return FALSE;
 */

            echo '{"success":true}';

        }

    }

    public function siparis_goruntule($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                    $data["iade_fat"] = $dizi["iade_fat"];
                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " Sipariş Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " Sipariş Ayarları</b>";

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["fatura_not_getir"] = $this->admin_model->fatura_not_getir('siparis', $id, $this->session->userdata('kullanici_id'));

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('siparis_goruntule', (array) $output);

        }

    }

    public function teklif($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('teklif');

            $crud->set_subject('Teklifler');
            $crud->columns('fatura_turu', 'fatura_no', 'cari_id', 'toplam', 'vade_tarihi', 'düzenle', 'görüntüle', 'teklif durumu');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'teklif_delete'));
            $crud->callback_column('düzenle', array($this, 'teklif_duzenle_link'));
            $crud->callback_column('görüntüle', array($this, 'teklif_goruntule_link'));
            $crud->callback_column('teklif durumu', array($this, 'teklif_durumu_getir'));
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $this->crud_status($crud, 0, 0, 0, 1); // add edit read delete

            $data['side_menu'] = "Teklif Ayarları";
            $data['kilavuz']   = "  <b>Teklif Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function teklif_duzenle_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            return "<a class='btn btn-default' href='" . site_url('yonetim/teklif_duzenle/' . $row->id) . "'>Düzenle</a>";

        }}

    public function teklif_goruntule_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            //    $cari_ad=$this->admin_model->cari_ad($row->sahip_id);
            return "<a class='btn btn-default' href='" . site_url('yonetim/teklif_goruntule/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function teklif_delete($primary_key)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $k_id = $this->session->userdata('kullanici_id');
            $this->db->query('delete from teklif_item where kullanici_id=' . $k_id . ' and fatura_id=' . $primary_key);
            $this->log("Teklif Sil", "teklif", "Silme", 0);
            return true;
        }
    }

    public function teklif_durumu_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($row->id, $this->session->userdata('kullanici_id'));

            $n = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):

                    if ($dizi["aktarim"] == 0) {continue;}

                    $n = $n + 1;
                endforeach;endif;

            if ($n == 0) {return "Açık Teklif";}

            $n = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):

                    if ($dizi["adet"] > $dizi["aktarim"]) {
                        return "Kısmi Teklif";

                    }

                    $n = $n + 1;
                endforeach;endif;

            return "Kapalı Teklif";

        }

    }

    public function alinan_teklif_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Teklif Ayarları";
            $data['kilavuz']   = "  <b>Teklif Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["tur"]        = "AlınanTeklif";
            $data["tek_tur"]    = "Alınan Teklif";

            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('teklif', (array) $output);

        }

    }

    public function verilen_teklif_olustur()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Teklif Ayarları";
            $data['kilavuz']   = "  <b>Teklif Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["tur"]        = "VerilenTeklif";
            $data["tek_tur"]    = "Verilen Teklif";

            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('teklif', (array) $output);

        }

    }

    public function teklif_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $kayit_kontrol = $this->admin_model->kayit_kontrol("teklif", $seri, $no);
            if ($kayit_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->tek_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'));
            $fat_id    = $fat_kayit;

            $this->log("Teklif Kayıt", "teklif", "Ekleme", $this->db->insert_id());

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->tek_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }

            /*$this->load->library('messages');
            $this->messages->config2('Yonetim/teklif');
            return FALSE;*/

            echo '{"success":true}';

        }

    }

    public function teklif_duzenle($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_teklif = $this->admin_model->yetki_kontrol_teklif($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_teklif != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Teklif Ayarları";
            $data['kilavuz']   = "  <b>Teklif Ayarları</b>";

            $data["cari_getir"]                = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["teklif_getir_duzenle"]      = $this->admin_model->teklif_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["teklif_getir_duzenle"]): foreach ($data["teklif_getir_duzenle"] as $dizi):
                    $data["cari_ad"] = $this->admin_model->cari_ad($dizi["cari_id"]);
                endforeach;endif;

            $n                     = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;
            $data["tek_tur"] = "Alınan Teklif";

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('teklif_duzenle', (array) $output);

        }

    }

    public function teklif_guncelle()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_id = $this->input->post('fat_id', true);
            $fat_id = trim($fat_id);
            $fat_id = strip_tags($fat_id);
            $fat_id = htmlentities($fat_id);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->tek_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $this->session->userdata('kullanici_id'));

            $this->log("Teklif Kayıt", "teklif", "Ekleme", $fat_id);

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->tek_item_kayit2($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }
/*
$this->load->library('messages');
$this->messages->config2('Yonetim/teklif');
return FALSE;

 */

            echo '{"success":true}';

        }

    }

    public function teklif_goruntule($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_teklif = $this->admin_model->yetki_kontrol_teklif($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_teklif != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["teklif_getir_duzenle"]      = $this->admin_model->teklif_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["teklif_getir_duzenle"]): foreach ($data["teklif_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                    $data["iade_fat"] = $dizi["iade_fat"];
                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " Teklif Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " Teklif Ayarları</b>";

            $n                     = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["fatura_not_getir"] = $this->admin_model->fatura_not_getir('teklif', $id, $this->session->userdata('kullanici_id'));

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('teklif_goruntule', (array) $output);

        }

    }

    public function arac($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_arac = $this->admin_model->yetki_kontrol_arac($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_arac != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('arac');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Araç Ayar');
            $crud->columns('arac_adi', 'marka', 'model', 'yil', 'bakım', 'km kayıt');
            $crud->required_fields('marka', 'model', 'yil', 'plaka', 'ruhsat_sahibi', 'arac_adi');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
/*
$crud->field_type('para_birim','dropdown',
array('TL' => 'TL', 'Euro' => 'Euro', 'Usd' => 'Usd',
'Pound' => 'Pound', 'Ruble' => 'Ruble', 'Kuveyt Dinar' => 'Kuveyt Dinar'));
 */
            $crud->callback_column('bakım', array($this, 'bakim_link'));
            $crud->callback_column('km kayıt', array($this, 'km_link'));
            $crud->callback_before_delete(array($this, 'arac_item_sil'));
            $this->log_grocery($crud, "Araç İşlemleri", "arac");
            $data['side_menu'] = "Araç Ayarları";
            $data['kilavuz']   = "  <b>Araç Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function arac_item_sil($primary_key)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->db->where('arac_adi', $primary_key);
            $this->db->delete('bakim');

            $this->db->where('arac_adi', $primary_key);
            $this->db->delete('km');

            return true;

        }

    }

    public function bakim_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            return "<a class='btn btn-default' href='" . site_url('yonetim/bakim/' . $row->id) . "'>Bakımlar</a>";

        }

    }

    public function km_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            return "<a class='btn btn-default' href='" . site_url('yonetim/km/' . $row->id) . "'>Km Kayıt</a>";

        }

    }

    public function bakim($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if (!is_numeric($id)) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $this->load->model('admin_model');
            $yetki_kontrol_arac = $this->admin_model->yetki_kontrol_arac($this->session->userdata('kullanici_id'), $id);

            if ($yetki_kontrol_arac == false) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }$crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('bakim');
            $crud->set_subject('Araç Bakımları');
            $crud->columns('arac_adi', 'bakim_adi', 'bakim_tarihi');
            $crud->required_fields('arac_adi', 'bakim_adi', 'bakim_tarihi');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('arac_adi', $id);
            $crud->unset_clone();
            $crud->unset_back_to_list();

            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('arac_adi', array($this, 'callback_arac_getir'));

            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->field_type('arac_adi', 'hidden', $id);
            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;
                $crud->field_type('arac_adi', 'hidden', $id);
                $crud->callback_column('arac_adi', array($this, 'callback_arac_getir'));
            }

            $this->log_grocery($crud, "Araç Bakım", "bakim");
            $data['side_menu'] = "Bakım";
            $data['kilavuz']   = "  <b>Bakım Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function callback_arac_getir($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            return $arac_ad = $this->admin_model->arac_ad($row->id);

        }

    }

    public function km($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if (!is_numeric($id)) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $this->load->model('admin_model');
            $yetki_kontrol_arac = $this->admin_model->yetki_kontrol_arac($this->session->userdata('kullanici_id'), $id);

            if ($yetki_kontrol_arac == false) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('km');
            $crud->set_subject('Araç Km Kayıt');
            $crud->columns('arac_adi', 'yol_bas_tarih', 'yol_bit_tarih', 'km_baslangic', 'km_bitis');
            $crud->required_fields('arac_adi', 'yol_bas_tarih', 'yol_bit_tarih');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->where('arac_adi', $id);
            $crud->order_by('km_baslangic', 'desc');
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->display_as('yol_bas_saat', 'Yolculuk Başlangıç Saat (13:15)');
            $crud->display_as('yol_bit_saat', 'Yolculuk Bitiş Saat (14:15)');
            $crud->callback_column('arac_adi', array($this, 'callback_arac_getir'));

            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'add') {

                $crud->field_type('arac_adi', 'hidden', $id);
            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;
                $crud->field_type('arac_adi', 'hidden', $id);
                $crud->callback_column('arac_adi', array($this, 'callback_arac_getir'));
            }

            $this->log_grocery($crud, "Araç Km Kayıt", "km");

            $data['side_menu'] = "Km";
            $data['kilavuz']   = "  <b>Km Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

/**/

    public function gel_tek_sip_akt($fat_id)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_teklif = $this->admin_model->yetki_kontrol_teklif($fat_id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_teklif != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Sipariş Ayarları";
            $data['kilavuz']   = "  <b>Sipariş Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));

            $data["teklif_getir_duzenle"]      = $this->admin_model->teklif_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));
            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));

            if ($data["teklif_getir_duzenle"]): foreach ($data["teklif_getir_duzenle"] as $dizi):
                    $data["cari_ad"]     = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fatura_turu"] = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["fatura_turu"] != "AlınanTeklif") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["tur"]     = "GidenSiparis";
            $data["sip_tur"] = "Giden Sipariş";

            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gel_tek_sip_akt', (array) $output);

        }

    }

    public function gid_tek_sip_akt($fat_id)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_teklif = $this->admin_model->yetki_kontrol_teklif($fat_id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_teklif != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Sipariş Ayarları";
            $data['kilavuz']   = "  <b>Sipariş Ayarları</b>";
            $this->load->model('admin_model');
            $data["cari_getir"] = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"] = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));

            $data["teklif_getir_duzenle"]      = $this->admin_model->teklif_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));
            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($fat_id, $this->session->userdata('kullanici_id'));

            if ($data["teklif_getir_duzenle"]): foreach ($data["teklif_getir_duzenle"] as $dizi):
                    $data["cari_ad"]     = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fatura_turu"] = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["fatura_turu"] != "VerilenTeklif") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data["tur"]     = "GelenSiparis";
            $data["sip_tur"] = "Gelen Sipariş";
            //  print_r($data["urun_getir"]);
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gid_tek_sip_akt', (array) $output);

        }

    }

    public function tek_siparis_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $teklif_id = $this->input->post('teklif_id', true);
            $teklif_id = trim($teklif_id);
            $teklif_id = strip_tags($teklif_id);
            $teklif_id = htmlentities($teklif_id);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $kayit_kontrol = $this->admin_model->kayit_kontrol("siparis", $seri, $no);
            if ($kayit_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->sip_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $this->session->userdata('kullanici_id'));
            $fat_id    = $fat_kayit;

            $this->log("Teklif Aktar", "siparis", "Aktarım", $teklif_id);
            $this->log("Sipariş Kayıt", "siparis", "Ekleme", $this->db->insert_id());

            $data["teklif_getir_duzenle"]      = $this->admin_model->teklif_getir_duzenle($teklif_id, $this->session->userdata('kullanici_id'));
            $data["teklif_item_getir_duzenle"] = $this->admin_model->teklif_item_getir_duzenle($teklif_id, $this->session->userdata('kullanici_id'));

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->sip_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }

            $tek_ur[]                          = "";
            $sip_ur[]                          = "";
            $n                                 = 1;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = 0;
                    $n                               = $n + 1;endforeach;endif;

            $adet                              = 0;
            $n                                 = 1;if ($data["teklif_item_getir_duzenle"]): foreach ($data["teklif_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = $tek_ur[$dizi["hizmet_urun_id"]] + 1;
                    $sip_ur[$dizi["hizmet_urun_id"]] = 0;

                    for ($i = 1; $i <= $top_alan; $i++) {

                        if ($dizi["hizmet_urun_id"] == $item[$i]) {
                            $sip_ur[$item[$i]] = $sip_ur[$item[$i]] + 1;

                            if ($tek_ur[$dizi["hizmet_urun_id"]] == $sip_ur[$item[$i]]) {

//echo $dizi["id"]." - ".$dizi["adet"]." - ".$qty[$i]."<br>";
                                //adetleri kıyasla
                                /*
                                if($dizi["adet"]>=$qty[$i]){

                                $adet = $qty[$i];

                                }
                                else{
                                $adet = $dizi["adet"];
                                }

                                echo $adet."<br>";
                                 */

//db update burada
                                $adet = $qty[$i];

                                $gnc = $this->admin_model->tek_item_gunc($dizi["id"], $adet, $this->session->userdata('kullanici_id'));

                            }

                        }}

                    $n = $n + 1;endforeach;endif;

            $this->load->library('messages');
            $this->messages->config2('Yonetim/siparis');
            return false;

        }

    }

    public function gel_sip_irs_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');
            $crud->unset_back_to_list();

            $data["cari_getir"]                 = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                 = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi): $data["tur"] = $dizi["fatura_turu"];
                    $data["cari_ad"]                                                                                   = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["sip_tur"]                                                                                   = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["sip_tur"] != "GelenSiparis") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            if ($data["sip_tur"] == "GelenSiparis") {

                $data['side_menu'] = "Satış İrsaliye Ayarları";
                $data['kilavuz']   = "  <b>Satış İrsaliye Ayarları</b>";

            }

            if ($data["sip_tur"] == "GidenSiparis") {

                $data['side_menu'] = "Alış İrsaliye Ayarları";
                $data['kilavuz']   = "  <b>Alış İrsaliye Ayarları</b>";

            }

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gel_sip_irs_akt', (array) $output);

        }

    }

    public function gid_sip_irs_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');
            $crud->unset_back_to_list();

            $data["cari_getir"]                 = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                 = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi): $data["tur"] = $dizi["fatura_turu"];
                    $data["cari_ad"]                                                                                   = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["sip_tur"]                                                                                   = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["sip_tur"] != "GidenSiparis") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            if ($data["sip_tur"] == "GelenSiparis") {

                $data['side_menu'] = "Satış İrsaliye Ayarları";
                $data['kilavuz']   = "  <b>Satış İrsaliye Ayarları</b>";

            }

            if ($data["sip_tur"] == "GidenSiparis") {

                $data['side_menu'] = "Alış İrsaliye Ayarları";
                $data['kilavuz']   = "  <b>Alış İrsaliye Ayarları</b>";

            }

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gid_sip_irs_akt', (array) $output);

        }

    }

    public function sip_irsaliye_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $sip_id = $this->input->post('sip_id', true);
            $sip_id = trim($sip_id);
            $sip_id = strip_tags($sip_id);
            $sip_id = htmlentities($sip_id);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $irs_kontrol = $this->admin_model->irs_kontrol($no);
            if ($kayit_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $il = $this->input->post('il', true);
            $il = trim($il);
            $il = strip_tags($il);
            $il = htmlentities($il);

            $adr = $this->input->post('adr', true);
            $adr = trim($adr);
            $adr = strip_tags($adr);
            $adr = htmlentities($adr);

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $fat_kayit = $this->admin_model->irs_kayit($fat_turu, $mus, $no, $duz_ta, $va_ta, $il, $adr, $ack, $this->session->userdata('kullanici_id'));
            $fat_id    = $fat_kayit;

            $this->log("Sipariş Aktar", "irsaliye", "Aktarım", $sip_id);
            $this->log("İrsaliye Kayıt", "irsaliye", "Ekleme", $this->db->insert_id());

            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($sip_id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($sip_id, $this->session->userdata('kullanici_id'));

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $fat_item_kayit = $this->admin_model->irs_item_kayit($fat_id, $item[$i], $qty[$i], $des[$i], $this->session->userdata('kullanici_id'));

            }

            $tek_ur[]                          = "";
            $sip_ur[]                          = "";
            $n                                 = 1;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = 0;
                    $n                               = $n + 1;endforeach;endif;

            $adet                              = 0;
            $n                                 = 1;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = $tek_ur[$dizi["hizmet_urun_id"]] + 1;
                    $sip_ur[$dizi["hizmet_urun_id"]] = 0;

                    for ($i = 1; $i <= $top_alan; $i++) {

                        if ($dizi["hizmet_urun_id"] == $item[$i]) {
                            $sip_ur[$item[$i]] = $sip_ur[$item[$i]] + 1;

                            if ($tek_ur[$dizi["hizmet_urun_id"]] == $sip_ur[$item[$i]]) {

                                $adet = $qty[$i];

                                $gnc = $this->admin_model->sip_item_gunc($dizi["id"], $adet, $this->session->userdata('kullanici_id'));

                            }

                        }}

                    $n = $n + 1;endforeach;endif;

            $this->load->library('messages');
            $this->messages->config2('Yonetim/irsaliye');
            return false;

        }

    }

    public function sat_irs_fat_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_irsaliye = $this->admin_model->yetki_kontrol_irsaliye($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_irsaliye != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                  = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                  = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"]                  = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["fat_turu"] != "Satış") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " Fatura Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " Fatura Ayarları</b>";

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('sat_irs_fat_akt', (array) $output);

        }

    }

    public function al_irs_fat_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_irsaliye = $this->admin_model->yetki_kontrol_irsaliye($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_irsaliye != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                  = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                  = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"]                  = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            if ($data["irsaliye_getir_duzenle"]): foreach ($data["irsaliye_getir_duzenle"] as $dizi):
                    $data["cari_ad"]  = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["fat_turu"] = $dizi["fatura_turu"];
                endforeach;endif;
            if ($data["fat_turu"] != "Alış") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            $data['side_menu'] = $data["fat_turu"] . " Fatura Ayarları";
            $data['kilavuz']   = "  <b>" . $data["fat_turu"] . " Fatura Ayarları</b>";

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('al_irs_fat_akt', (array) $output);

        }

    }

    public function irs_fatura_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $irs_id = $this->input->post('irs_id', true);
            $irs_id = trim($irs_id);
            $irs_id = strip_tags($irs_id);
            $irs_id = htmlentities($irs_id);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $fat_kontrol = $this->admin_model->fat_kontrol($seri, $no);
            if ($fat_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);

            $fat_kayit = $this->admin_model->fat_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $per);
            $fat_id    = $fat_kayit;

            $this->log("İrsaliye Aktar", "irsaliye", "Aktarım", $irs_id);
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            $data["irsaliye_getir_duzenle"]      = $this->admin_model->irsaliye_getir_duzenle($irs_id, $this->session->userdata('kullanici_id'));
            $data["irsaliye_item_getir_duzenle"] = $this->admin_model->irsaliye_item_getir_duzenle($irs_id, $this->session->userdata('kullanici_id'));

            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "0";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

                $islem_kayit = $this->admin_model->islem_kayit_tahsilat_odeme("3", "Tahsilat-Ödeme", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $this->session->userdata('kullanici_id'));

            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->fat_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }

            $tek_ur[]                          = "";
            $sip_ur[]                          = "";
            $n                                 = 1;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = 0;
                    $n                               = $n + 1;endforeach;endif;

            $adet                              = 0;
            $n                                 = 1;if ($data["irsaliye_item_getir_duzenle"]): foreach ($data["irsaliye_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = $tek_ur[$dizi["hizmet_urun_id"]] + 1;
                    $sip_ur[$dizi["hizmet_urun_id"]] = 0;

                    for ($i = 1; $i <= $top_alan; $i++) {

                        if ($dizi["hizmet_urun_id"] == $item[$i]) {
                            $sip_ur[$item[$i]] = $sip_ur[$item[$i]] + 1;

                            if ($tek_ur[$dizi["hizmet_urun_id"]] == $sip_ur[$item[$i]]) {

                                $adet = $qty[$i];

                                $gnc = $this->admin_model->irs_item_gunc($dizi["id"], $adet, $this->session->userdata('kullanici_id'));

                            }

                        }}

                    $n = $n + 1;endforeach;endif;

            $gnc = $this->admin_model->fat_irs_iliski_kaydet($fat_id, $irs_id, $this->session->userdata('kullanici_id'));

            $this->load->library('messages');
            $this->messages->config2('Yonetim/fatura');
            return false;

        }

    }

    public function gel_sip_fat_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                 = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                 = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"]                 = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi): $data["tur"] = $dizi["fatura_turu"];
                    $data["cari_ad"]                                                                                   = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["sip_tur"]                                                                                   = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["sip_tur"] != "GelenSiparis") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            if ($data["sip_tur"] == "GelenSiparis") {

                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["sip_tur"] == "GidenSiparis") {

                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gel_sip_fat_akt', (array) $output);

        }

    }

    public function gid_sip_fat_akt($id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $yetki_kontrol_siparis = $this->admin_model->yetki_kontrol_siparis($id, $this->session->userdata('kullanici_id'));

            if ($yetki_kontrol_siparis != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data["cari_getir"]                 = $this->admin_model->tum_cari_getir($this->session->userdata('kullanici_id'));
            $data["urun_getir"]                 = $this->admin_model->tum_urun_getir($this->session->userdata('kullanici_id'));
            $data["kasa_getir"]                 = $this->admin_model->kasa_getir($this->session->userdata('kullanici_id'));
            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($id, $this->session->userdata('kullanici_id'));

            $data["personel_getir"] = $this->admin_model->personel_getir($this->session->userdata('kullanici_id'));

            if ($data["siparis_getir_duzenle"]): foreach ($data["siparis_getir_duzenle"] as $dizi): $data["tur"] = $dizi["fatura_turu"];
                    $data["cari_ad"]                                                                                   = $this->admin_model->cari_ad($dizi["cari_id"]);
                    $data["sip_tur"]                                                                                   = $dizi["fatura_turu"];
                endforeach;endif;

            if ($data["sip_tur"] != "GidenSiparis") {
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $n                     = 0;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $data["urun_ad"][$n] = $this->admin_model->stok_adi($dizi["hizmet_urun_id"], $this->session->userdata('kullanici_id'));
                    $n                   = $n + 1;
                endforeach;endif;

            if ($data["sip_tur"] == "GelenSiparis") {

                $data['side_menu'] = "Satış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Satış Fatura Ayarları</b>";

            }

            if ($data["sip_tur"] == "GidenSiparis") {

                $data['side_menu'] = "Alış Fatura Ayarları";
                $data['kilavuz']   = "  <b>Alış Fatura Ayarları</b>";

            }

            // print_r($data["cari_ad"]);
            //      return FALSE;

            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('gid_sip_fat_akt', (array) $output);

        }

    }

    public function sip_fatura_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {

            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {$this->load->view('admin_register');} else { $this->load->view('admin_register');}

        } else {

            $this->load->model('admin_model');
            $fat_turu = $this->input->post('fat_turu', true);
            $fat_turu = trim($fat_turu);
            $fat_turu = strip_tags($fat_turu);
            $fat_turu = htmlentities($fat_turu);

            $sip_id = $this->input->post('sip_id', true);
            $sip_id = trim($sip_id);
            $sip_id = strip_tags($sip_id);
            $sip_id = htmlentities($sip_id);

            $ara_toplam = $this->input->post('ara_toplam', true);
            $ara_toplam = trim($ara_toplam);
            $ara_toplam = strip_tags($ara_toplam);
            $ara_toplam = htmlentities($ara_toplam);

            $indirim = $this->input->post('indirim', true);
            $indirim = trim($indirim);
            $indirim = strip_tags($indirim);
            $indirim = htmlentities($indirim);

            $vergi = $this->input->post('vergi', true);
            $vergi = trim($vergi);
            $vergi = strip_tags($vergi);
            $vergi = htmlentities($vergi);

            $toplam = $this->input->post('toplam', true);
            $toplam = trim($toplam);
            $toplam = strip_tags($toplam);
            $toplam = htmlentities($toplam);

            $top_alan = $this->input->post('top_alan', true);
            $top_alan = trim($top_alan);
            $top_alan = strip_tags($top_alan);
            $top_alan = htmlentities($top_alan);

            $mus = $this->input->post('mus', true);
            $mus = trim($mus);
            $mus = strip_tags($mus);
            $mus = htmlentities($mus);

            $seri = $this->input->post('seri', true);
            $seri = trim($seri);
            $seri = strip_tags($seri);
            $seri = htmlentities($seri);

            $no = $this->input->post('no', true);
            $no = trim($no);
            $no = strip_tags($no);
            $no = htmlentities($no);

            $fat_kontrol = $this->admin_model->fat_kontrol($seri, $no);
            if ($fat_kontrol == 0) {
                echo '{"success":false}';
                return false;

            }

            $duz_ta = $this->input->post('duz_ta', true);
            $duz_ta = trim($duz_ta);
            $duz_ta = strip_tags($duz_ta);
            $duz_ta = htmlentities($duz_ta);

            $duz_ta_par = explode("/", $duz_ta);
            $duz_ta     = $duz_ta_par[2] . "-" . $duz_ta_par[0] . "-" . $duz_ta_par[1];

            $va_ta = $this->input->post('va_ta', true);
            $va_ta = trim($va_ta);
            $va_ta = strip_tags($va_ta);
            $va_ta = htmlentities($va_ta);

            $va_ta_par = explode("/", $va_ta);
            $va_ta     = $va_ta_par[2] . "-" . $va_ta_par[0] . "-" . $va_ta_par[1];

            $ack = $this->input->post('ack', true);
            $ack = trim($ack);
            $ack = strip_tags($ack);
            $ack = htmlentities($ack);

            $durum = $this->input->post('durum', true);
            $durum = trim($durum);
            $durum = strip_tags($durum);
            $durum = htmlentities($durum);

            $kasa = $this->input->post('kasa', true);
            $kasa = trim($kasa);
            $kasa = strip_tags($kasa);
            $kasa = htmlentities($kasa);

            $per = $this->input->post('personel', true);
            $per = trim($per);
            $per = strip_tags($per);
            $per = htmlentities($per);

            $irs_durum = $this->input->post('irs_durum', true);
            $irs_durum = trim($irs_durum);
            $irs_durum = strip_tags($irs_durum);
            $irs_durum = htmlentities($irs_durum);

            $fat_kayit = $this->admin_model->fat_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $this->session->userdata('kullanici_id'), $per);
            $fat_id    = $fat_kayit;

            $this->log("Sipariş Aktar", "siparis", "Aktarım", $sip_id);
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            $data["siparis_getir_duzenle"]      = $this->admin_model->siparis_getir_duzenle($sip_id, $this->session->userdata('kullanici_id'));
            $data["siparis_item_getir_duzenle"] = $this->admin_model->siparis_item_getir_duzenle($sip_id, $this->session->userdata('kullanici_id'));

            if ($fat_turu == "Alış") {$gircik = "1";}
            if ($fat_turu == "Satış") {$gircik = "0";}
            if ($fat_turu == "Gider") {$gircik = "0";}

            $islem_kayit = $this->admin_model->islem_kayit_fat("4", "Fatura", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $this->session->userdata('kullanici_id'));
            $this->log("Fatura Kayıt", "fatura", "Ekleme", $this->db->insert_id());

            if ($durum == 0) {

                if ($fat_turu == "Alış") {$gircik = "0";}
                if ($fat_turu == "Satış") {$gircik = "1";}
                if ($fat_turu == "Gider") {$gircik = "0";}

                $islem_kayit = $this->admin_model->islem_kayit_tahsilat_odeme("3", "Tahsilat-Ödeme", $fat_id, $gircik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $this->session->userdata('kullanici_id'));

            }

            for ($i = 1; $i <= $top_alan; $i++) {

                $item[$i] = $this->input->post('item_' . $i, true);
                $item[$i] = trim($item[$i]);
                $item[$i] = strip_tags($item[$i]);
                $item[$i] = htmlentities($item[$i]);

                $des[$i] = $this->input->post('des_' . $i, true);
                $des[$i] = trim($des[$i]);
                $des[$i] = strip_tags($des[$i]);
                $des[$i] = htmlentities($des[$i]);

                $prc[$i] = $this->input->post('prc_' . $i, true);
                $prc[$i] = trim($prc[$i]);
                $prc[$i] = strip_tags($prc[$i]);
                $prc[$i] = htmlentities($prc[$i]);

                $qty[$i] = $this->input->post('qty_' . $i, true);
                $qty[$i] = trim($qty[$i]);
                $qty[$i] = strip_tags($qty[$i]);
                $qty[$i] = htmlentities($qty[$i]);

                $discount[$i] = $this->input->post('discount_' . $i, true);
                $discount[$i] = trim($discount[$i]);
                $discount[$i] = strip_tags($discount[$i]);
                $discount[$i] = htmlentities($discount[$i]);

                $tax[$i] = $this->input->post('tax_' . $i, true);
                $tax[$i] = trim($tax[$i]);
                $tax[$i] = strip_tags($tax[$i]);
                $tax[$i] = htmlentities($tax[$i]);

                $total[$i] = $this->input->post('total_' . $i, true);
                $total[$i] = trim($total[$i]);
                $total[$i] = strip_tags($total[$i]);
                $total[$i] = htmlentities($total[$i]);

                $fat_item_kayit = $this->admin_model->fat_item_kayit($fat_id, $item[$i], $qty[$i], $prc[$i], $total[$i], $des[$i], $discount[$i], $tax[$i], $fat_turu, $this->session->userdata('kullanici_id'));

            }

            $tek_ur[]                          = "";
            $sip_ur[]                          = "";
            $n                                 = 1;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = 0;
                    $n                               = $n + 1;endforeach;endif;

            $adet                              = 0;
            $n                                 = 1;if ($data["siparis_item_getir_duzenle"]): foreach ($data["siparis_item_getir_duzenle"] as $dizi):
                    $tek_ur[$dizi["hizmet_urun_id"]] = $tek_ur[$dizi["hizmet_urun_id"]] + 1;
                    $sip_ur[$dizi["hizmet_urun_id"]] = 0;

                    for ($i = 1; $i <= $top_alan; $i++) {

                        if ($dizi["hizmet_urun_id"] == $item[$i]) {
                            $sip_ur[$item[$i]] = $sip_ur[$item[$i]] + 1;

                            if ($tek_ur[$dizi["hizmet_urun_id"]] == $sip_ur[$item[$i]]) {

                                $adet = $qty[$i];

                                $gnc = $this->admin_model->sip_item_gunc($dizi["id"], $adet, $this->session->userdata('kullanici_id'));

                            }

                        }}

                    $n = $n + 1;endforeach;endif;

            $this->load->library('messages');
            $this->messages->config2('Yonetim/fatura');
            return false;

        }

    }

    public function mesaj()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            $data["uye_getir"]   = $this->admin_model->tum_uye_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'));
            $data["mesaj_getir"] = $this->admin_model->tum_mesaj_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'));
     
            $data["mesaj_getir"] = $this->array_sort($data["mesaj_getir"], 'tarih', SORT_DESC);

            $data["uye"] = $this->session->userdata('id');
			
			$arr [] = "";

            $i = 0;if ($data["mesaj_getir"]): foreach ($data["mesaj_getir"] as $dizi):

                    if ($dizi['gonderici'] == $data["uye"]) {$name = $dizi['alici'];}
                    if ($dizi['alici'] == $data["uye"]) {$name = $dizi['gonderici'];}
				
				if (in_array($name, $arr))
				{
				}
				else
				{
				array_push($arr,$name);
				
				}
				             $i = $i + 1;endforeach;endif;
							 
							 
				
							 
				$say = count($arr); $don = $say -1;
				for($i=0; $i<=$don; $i++)
				{ 
				if($arr[$i]==""){
				unset($arr[$i]);
				} 	
				else{	}
				}						 
	

	
$ar [] = "";
$s=0;							 
foreach($arr as $n){
	
	$ar [$s] = $n;
	if($n==""){ exit; }
	$s=$s+1;
}	


				$say = count($ar); $don = $say -1;
	for($i=0; $i<=$don; $i++)
	{ 

    $data["name"][$i] = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $ar[$i]);
    $data["okunmamis"][$i] = $this->admin_model->okunmamis_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $ar[$i]);

	}


		


							 
							 
		/*						 
				$say = count($arr); $don = $say -1;
	for($i=0; $i<=$don; $i++)
	{ 
	if($arr[$i]==""){
		 unset($arr[$i]);
	} 	
	else{

    $data["name"][$i] = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $arr[$i]);
    $data["okunmamis"][$i] = $this->admin_model->okunmamis_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $arr[$i]);

	}
	}
						 
							 
						 
	print_r($data["name"]);
	return FALSE;							 
							 
							 
            $i = 0;if ($data["mesaj_getir"]): foreach ($data["mesaj_getir"] as $dizi):							 
		                    if ($dizi['gonderici'] == $data["uye"]) {$name = $dizi['alici'];}
                    if ($dizi['alici'] == $data["uye"]) {$name = $dizi['gonderici'];}					 

                    $data["name"][$i] = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $name);

                    $data["okunmamis"][$i] = $this->admin_model->okunmamis_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $name);

                    $i = $i + 1;endforeach;endif;
*/
            $data['sayfa'] = 'Mesajlar';
            $data['ar'] = $ar;			

		

	

            $this->load->view('mesaj.php', $data);

        }

    }

    public function mesaj_gonder()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin/admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                echo $this->messages->To_Login('admin/admin');
            } else {echo $this->messages->To_Register('admin/admin');}

        } else {

            $uyeler   = $this->input->post('uyeler', true);
            $say      = count($uyeler);
            $ice      = $this->input->post('ice', true);
            $uyedurum = $this->input->post('uyedurum', true);
            $ilk = $this->input->post('ilk', true);
            if ($say == 0) {

                echo "<br><br><center><b>Lütfen en az 1 adet Üye seçiniz.</b></center>";
                echo '<meta http-equiv="refresh" content="2;URL=mesaj">';
                return false;
            }
            if ($say == 1) {

                $yonlenecek_uye = $uyeler[0];
            }

            if ($uyedurum == 0) {

                $url = "mesaj";

            }
            if ($uyedurum == 1) {

                $url = "mesajdetay/" . $yonlenecek_uye;
            }

            $this->load->model('admin_model');
            $dongu = $say - 1;

            for ($i = 0; $i <= $dongu; $i++) {

                $yetki_kontrol_mesaj = $this->admin_model->yetki_kontrol_mesaj($this->session->userdata('kullanici_id'), $uyeler[$i]);

                if ($yetki_kontrol_mesaj != true) {continue;}

                $this->admin_model->mesaj_kaydet($uyeler[$i], $ice, $this->session->userdata('id'), $this->session->userdata('kullanici_id'));

            }

if($ilk==1){
            echo "<br><br><center><b>Gönderim başarılı</b></center>";
            echo '<meta http-equiv="refresh" content="2;URL='.$url.'">';
            return FALSE;

}
else{
      echo '{"success": true}';
            return false;

    
}
            $this->log("Mesaj Gönderim", "mesaj", "Gönderildi", 0);

            

      
        }

    }

    public function mesajdetay($id)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if (!is_numeric($id)) {

                $this->load->library('messages');
                $this->messages->config('yonetim');
                return false;
            }

            if ($this->session->userdata('id') == $id) {

                $this->load->library('messages');
                $this->messages->config('yonetim');
                return false;
            }
            $this->load->model('admin_model');
            $yetki_kontrol_mesaj = $this->admin_model->yetki_kontrol_mesaj($this->session->userdata('kullanici_id'), $id);

            if ($yetki_kontrol_mesaj != true) {
                $this->load->library('messages');
                $this->messages->config('yonetim');
                return false;

            }

            $data["uye_mesaj_getir"] = $this->admin_model->uye_mesaj_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $id);
            $data["uye_adi_getir"]   = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $id);
            $data["uye"]             = $id;

            $n = 0;if ($data["uye_mesaj_getir"]): foreach ($data["uye_mesaj_getir"] as $dizi):
                    if ($data["uye_mesaj_getir"][$n] == "") {unset($data["uye_mesaj_getir"][$n]);}
                    $n = $n + 1;endforeach;endif;

            $data["uye_mesaj_getir"] = $this->array_sort($data["uye_mesaj_getir"], 'tarih', SORT_DESC);

            $data['sayfa'] = 'Mesajlar';

            $this->load->view('mesajdetay.php', $data);

        }

    }

    public function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array      = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function okunmamis_kontrol()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $okunmamis = $this->admin_model->okunmamis_toplam_getir($this->session->userdata('kullanici_id'), $this->session->userdata('id'));

            if ($okunmamis == 0) {echo "";} else {echo $okunmamis;}

        }}

    public function tartisma($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_tartisma = $this->admin_model->yetki_kontrol_tartisma($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $primary_key);

                if ($yetki_kontrol_tartisma != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'read') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_tartisma = $this->admin_model->yetki_kontrol_tartisma($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $primary_key);

                if ($yetki_kontrol_tartisma != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            } else if ($state == 'delete') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_tartisma = $this->admin_model->yetki_kontrol_tartisma($this->session->userdata('kullanici_id'), $this->session->userdata('id'), $primary_key);

                if ($yetki_kontrol_tartisma != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('tartisma');

            $crud->set_subject('Tartışmalar');
            $crud->columns('tarih', 'konu', 'oku');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->required_fields('konu');
            $crud->order_by('tarih', 'desc');
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));
            $crud->field_type('kim', 'hidden', $this->session->userdata('id'));
            $crud->callback_column('oku', array($this, 'tartisma_oku'));

            if (($this->session->userdata('uye_turu') != 0) and ($this->session->userdata('uye_turu') != 1)) {

                $crud->unset_delete();
                $this->crud_status($crud, 1, 1, 1, 0); // add edit read delete

            }

            $crud->callback_before_delete(array($this, 'tartisma_sil'));

            $crud->unset_edit_fields("tarih");
            $crud->unset_add_fields("tarih");
            $crud->unset_clone();
            $this->log_grocery($crud, "tartisma", "tartisma");
            $crud->unset_back_to_list();
            $data['side_menu'] = "Tartışma Ayarları";
            $data['kilavuz']   = "  <b>Tartışma Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }

    }

    public function tartisma_sil($primary_key)
    {

        $this->load->model('admin_model');
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('tartisma_id', $primary_key);
        $this->db->delete('tartisma_msj');

        return true;

    }

    public function tartisma_oku($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');

            return "<a class='btn btn-default' href='" . site_url('yonetim/tartisma_dty/' . $row->id) . "'>Oku</a>";

        }

    }

    public function tartisma_dty($id)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            if (!is_numeric($id)) {

                $this->load->library('messages');
                $this->messages->config('yonetim');
                return false;
            }

            $this->load->model('admin_model');
            $yetki_kontrol_tartisma_detay = $this->admin_model->yetki_kontrol_tartisma_detay($this->session->userdata('kullanici_id'), $id);

            if ($yetki_kontrol_tartisma_detay != 1) {

                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                return false;

            }

            $data["tartisma_bilgi_getir"] = $this->admin_model->tartisma_bilgi_getir($this->session->userdata('kullanici_id'), $id);

            if ($data["tartisma_bilgi_getir"]): foreach ($data["tartisma_bilgi_getir"] as $dizi):

                    $data["tarih"] = $dizi["tarih"];
                    $data["kim"]   = $data["tartisma_bilgi_getir"]   = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $dizi["kim"]);

                     $data["konu"] = $dizi["konu"];

                endforeach;endif;
				

            $data["tartisma_msj_getir"] = $this->admin_model->tartisma_msj_getir($this->session->userdata('kullanici_id'), $id);

            $n = 0;if ($data["tartisma_msj_getir"]): foreach ($data["tartisma_msj_getir"] as $dizi):

                    $data["gonderici"][$n] = $this->admin_model->uye_adi_getir($this->session->userdata('kullanici_id'), $dizi["kim"]);

                    $n = $n + 1;endforeach;endif;

            $data['sayfa']    = 'Tartışmalar';
            $data['tartisma'] = $id;
			
			
			
			

            $this->load->view('tartisma_detay.php', $data);

        }

    }

    public function tartisma_gonder()
    {
        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin/admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                echo $this->messages->To_Login('admin/admin');
            } else {echo $this->messages->To_Register('admin/admin');}

        } else {

            $ice      = $this->input->post('ice', true);
            $tartisma = $this->input->post('tartisma', true);
            $ice      = trim($ice);
            $ice      = strip_tags($ice);
            $ice      = htmlentities($ice);
            $ilk = $this->input->post('ilk', true);




            $this->load->model('admin_model');
            $yetki_kontrol_tartisma_detay = $this->admin_model->yetki_kontrol_tartisma_detay($this->session->userdata('kullanici_id'), $tartisma);

            if ($yetki_kontrol_tartisma_detay != 1) {
                /*
                $this->load->library('Messages');
                echo $this->messages->config('yonetim');
                 */

                echo 'Error';

                return false;

            }

            if (!is_numeric($tartisma)) {

                /*    $this->load->library('Messages');
                echo $this->messages->config('yonetim/tartisma_dty/'.$tartisma);
                 */

                echo 'Error';

                return false;

            }

            if (strlen($ice) < 10) {

                /*    $this->load->library('Messages');
                echo $this->messages->config('yonetim/tartisma_dty/'.$tartisma);

                 */
                echo 'Error';

                return false;

            }



            $this->load->model('admin_model');
            $this->admin_model->tartisma_kaydet($tartisma, $ice, $this->session->userdata('id'), $this->session->userdata('kullanici_id'));

            $this->log("Tartışma Gönderim", "tartisma", "Gönderildi", 0);

                $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/tartisma_dty/'.$tartisma);
            
            //echo '{"success":true}';

  /*         

if($ilk==1){
            $this->load->library('Messages');
            echo $this->messages->True_Add('yonetim/tartisma_dty/'.$tartisma);
        return false;  
}
else{
      echo '{"success":true}';
            return false;  
}

 */








            return false;

        }

    }

    public function log($nerede, $tablo, $islem, $primary_key)
    {

        $insert = array(
            'kim'          => $this->session->userdata('id'),
            'nerede'       => $nerede,
            'tablo'        => $tablo,
            'islem'        => $islem,
            'kayit_id'     => $primary_key,
            'kullanici_id' => $this->session->userdata('kullanici_id'),
        );
        $this->db->insert('log', $insert);
        return true;

    }

    public function log_grocery($crud, $nerede, $tablo)
    {

        $this->nerede = $nerede;
        $this->tablo  = $tablo;
        $crud->callback_after_insert_log(array($this, 'log_user_after_insert'));
        $crud->callback_after_delete_log(array($this, 'log_user_after_delete'));
        $crud->callback_after_update_log(array($this, 'log_user_after_update'));

    }

    public function log_user_after_delete($primary_key)
    {

        $insert = array(
            'kim'          => $this->session->userdata('id'),
            'nerede'       => $this->nerede,
            'tablo'        => $this->tablo,
            'islem'        => "Silme",
            'kayit_id'     => $primary_key,
            'kullanici_id' => $this->session->userdata('kullanici_id'),
        );
        $this->db->insert('log', $insert);
        return true;

    }

    public function log_user_after_update($post_array, $primary_key)
    {

        $insert = array(
            'kim'          => $this->session->userdata('id'),
            'nerede'       => $this->nerede,
            'tablo'        => $this->tablo,
            'islem'        => "Güncelleme",
            'kayit_id'     => $primary_key,
            'kullanici_id' => $this->session->userdata('kullanici_id'),
        );
        $this->db->insert('log', $insert);

        return true;
    }

    public function log_user_after_insert($post_array, $primary_key)
    {
        $insert = array(
            'kim'          => $this->session->userdata('id'),
            'nerede'       => $this->nerede,
            'tablo'        => $this->tablo,
            'islem'        => "Ekleme",
            'kayit_id'     => $primary_key,
            'kullanici_id' => $this->session->userdata('kullanici_id'),
        );
        $this->db->insert('log', $insert);

        return true;
    }

    public function login_kontrol($online)
    {

        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                echo $this->messages->To_Login('Yonetim');
                return false;
            } else {
                echo $this->messages->To_Register('Yonetim');
                return false;

            }

        } else {
            return true;
        }

    }

    public function new_page($token, $output)
    {

        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin/admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                echo $this->messages->To_Login('admin/admin');
            } else {echo $this->messages->To_Register('admin/admin');}

        } else {

            if ($token == $this->session->userdata('anahtar')) {
                echo json_encode((array) $output);
            } else {
                echo $this->load->view('index', (array) $output);
            }

        }

    }

    public function akis()
    {

        error_reporting(0);
        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {
                echo $this->messages->To_Login('yonetim');
            } else {echo $this->messages->To_Register('yonetim');}

        } else {

            $this->load->model('admin_model');

            $teklifler   = $this->admin_model->akis_teklifler($this->session->userdata('kullanici_id'));if ($teklifler == "") {$teklifler[] = "";}
            $siparisler  = $this->admin_model->akis_siparisler($this->session->userdata('kullanici_id'));if ($siparisler == "") {$siparisler[] = "";}
            $irsaliyeler = $this->admin_model->akis_irsaliyeler($this->session->userdata('kullanici_id'));if ($irsaliyeler == "") {$irsaliyeler[] = "";}
            $faturalar   = $this->admin_model->akis_faturalar($this->session->userdata('kullanici_id'));if (faturalar) {$faturalar[] = "";}
            $boal        = $this->admin_model->akis_boal($this->session->userdata('kullanici_id'));if ($boal == "") {$boal[] = "";}
            $cek         = $this->admin_model->akis_cek($this->session->userdata('kullanici_id'));if ($cek == "") {$cek[] = "";}
            $etk         = $this->admin_model->etk_cek($this->session->userdata('kullanici_id'));if ($etk == "") {$etk[] = "";}

            $n                      = 0;if ($teklifler): foreach ($teklifler as $dizi):
                    $teklifler[$n]["tur"] = "Teklif";
                    $n                    = $n + 1;endforeach;endif;

            $n                       = 0;if ($siparisler): foreach ($siparisler as $dizi):
                    $siparisler[$n]["tur"] = "Sipariş";
                    $n                     = $n + 1;endforeach;endif;

            $n                        = 0;if ($irsaliyeler): foreach ($irsaliyeler as $dizi):
                    $irsaliyeler[$n]["tur"] = "İrsaliye";
                    $n                      = $n + 1;endforeach;endif;

            $n                      = 0;if ($faturalar): foreach ($faturalar as $dizi):
                    $faturalar[$n]["tur"] = "Fatura";
                    $n                    = $n + 1;endforeach;endif;

            $n                 = 0;if ($boal): foreach ($boal as $dizi):
                    $boal[$n]["tur"] = "Borç Alacak";
                    $n               = $n + 1;endforeach;endif;

            $n                        = 0;if ($cek): foreach ($cek as $dizi):
                    $cek[$n]["fatura_turu"] = $cek[$n]["tur"];
                    $cek[$n]["tur"]         = "Çek Senet";
                    $n                      = $n + 1;endforeach;endif;

            $n                        = 0;if ($etk): foreach ($etk as $dizi):
                    $etk[$n]["fatura_turu"] = "";
                    $etk[$n]["tur"]         = "Etkinlik";
                    $etk[$n]["vade_tarihi"] = $etk[$n]["start"];
                    $n                      = $n + 1;endforeach;endif;

            $siralama = array_merge($teklifler, $siparisler, $irsaliyeler, $faturalar, $boal, $cek, $etk);

            $siralama         = $this->array_sort($siralama, 'vade_tarihi', SORT_DESC);
            $data["siralama"] = $siralama;

            /*
            $data["icerik"] = "";

            $islem="";
            $n=0; if ($siralama): foreach ($siralama as $dizi):
            $l=base_url()."yonetim/";
            if($dizi["vade_tarihi"]>date("Y-m-d")){ $renk="gray";}
            else if($dizi["vade_tarihi"]<date("Y-m-d")){ $renk="red";}
            else{ $renk="black";}

            if($dizi["fatura_turu"]=="Gider"){$islem="Gider Faturası"; $l.="gider_fatura_goruntule/".$dizi["id"];
            $n="ödemesi";}
            if($dizi["fatura_turu"]=="Alış"){
            if($dizi["tur"]=="İrsaliye"){$islem="Alış İrsaliyesi"; $l.="irsaliye_goruntule/".$dizi["id"]; $n="işlemi";}
            else{$islem="Alış Faturası"; $l.="fatura_goruntule/".$dizi["id"]; $n="ödemesi"; } }
            if($dizi["fatura_turu"]=="Satış"){
            if($dizi["tur"]=="İrsaliye"){$islem="Satış İrsaliyesi"; $l.="irsaliye_goruntule/".$dizi["id"];
            $n="işlemi";}
            else{$islem="Satış Faturası"; $l.="fatura_goruntule/".$dizi["id"]; $n="tahsilatı"; } }
            if($dizi["fatura_turu"]=="AlınanTeklif"){ $islem="Alınan Teklif"; $l.="teklif_goruntule/".$dizi["id"];
            $n="yanıt verme"; }
            if($dizi["fatura_turu"]=="VerilenTeklif"){ $islem="Verilen Teklif"; $l.="teklif_goruntule/".$dizi["id"]; $n="yanıt verme"; }
            if($dizi["fatura_turu"]=="GelenSiparis"){ $islem="Gelen Sipariş"; $l.="siparis_goruntule/".$dizi["id"];
            $n="yanıt verme"; }
            if($dizi["fatura_turu"]=="GidenSiparis"){ $islem="Giden Sipariş"; $l.="siparis_goruntule/".$dizi["id"];
            $n="yanıt verme"; }
            if($dizi["fatura_turu"]=="0"){
            $islem="Borçlanılan İşlem";
            if($dizi["tur"]=="Çek Senet"){ $l.="cek_senet/read/".$dizi["id"]; $n="ödemesi";}
            if($dizi["tur"]=="Borç Alacak"){ $l.="borc_alacak/read/".$dizi["id"]; $n="ödemesi";}
            }
            if($dizi["fatura_turu"]=="1"){
            $islem="Alacaklanan İşlem";
            if($dizi["tur"]=="Çek Senet"){ $l.="cek_senet/read/".$dizi["id"]; $n="tahsilatı";}
            if($dizi["tur"]=="Borç Alacak"){ $l.="borc_alacak/read/".$dizi["id"]; $n="tahsilatı";}

            }
            if($dizi["fatura_turu"]==""){ $islem="Etkinliğiniz "; $l.="etkinlik"; $n="var";}
            if($dizi["vade_tarihi"]!=""){
            $data["icerik"].="<div style='color:".$renk.";'>".$dizi["vade_tarihi"]." tarihinde ".$islem." ".$n." yapılacak <a href='".$l."' style='text-decoration:none;'> Görüntüle</a></div>";
            }

            $n=$n+1; endforeach;endif;

            return $data["icerik"];

             */
            $this->load->view('akis.php', $data);

        }

    }

    public function excel_cari()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

//Yükleme ve post alma fonksiyonu buraya

            $filename = $_FILES['file']['name'];
            echo $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (($ext != "xls") and ($ext != "csv") and ($ext != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;
            }

            $dizin            = 'assets/excel/';
            $yuklenecek_dosya = $dizin . basename($_FILES['file']['name']);

            $parca = explode(".", $_FILES['file']['name']);
            $say   = count($parca);
            $son   = $say - 1;
            if (($parca[$son] != "xls") and ($parca[$son] != "csv") and ($parca[$son] != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            echo '<pre>';
            if (move_uploaded_file($_FILES['file']['tmp_name'], $yuklenecek_dosya)) {

            } else {
                echo "Olası dosya yükleme saldırısı!\n";
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            $file = 'assets/excel/' . $_FILES['file']['name'];

            $baslangic = trim($this->input->post('baslangic', true));
            $baslangic = strip_tags($baslangic);
            $baslangic = htmlentities($baslangic);

            if (($baslangic == "") or (!is_numeric($baslangic))) {
                $baslangic = 0;
            }

            $adi_s = trim($this->input->post('adi', true));
            $adi_s = strip_tags($adi_s);
            $adi_s = htmlentities($adi_s);

            $vn_s = trim($this->input->post('vn', true));
            $vn_s = strip_tags($vn_s);
            $vn_s = htmlentities($vn_s);

            $cep_s = trim($this->input->post('cep', true));
            $cep_s = strip_tags($cep_s);
            $cep_s = htmlentities($cep_s);

            $adr_s = trim($this->input->post('adres', true));
            $adr_s = strip_tags($adr_s);
            $adr_s = htmlentities($adr_s);

            $il_s = trim($this->input->post('il', true));
            $il_s = strip_tags($il_s);
            $il_s = htmlentities($il_s);

            $ep_s = trim($this->input->post('eposta', true));
            $ep_s = strip_tags($ep_s);
            $ep_s = htmlentities($ep_s);

            $bakiye_durum_s = trim($this->input->post('bak_durum', true));
            $bakiye_durum_s = strip_tags($bakiye_durum_s);
            $bakiye_durum_s = htmlentities($bakiye_durum_s);

            $bakiye_miktar_s = trim($this->input->post('bak_miktar', true));
            $bakiye_miktar_s = strip_tags($bakiye_miktar_s);
            $bakiye_miktar_s = htmlentities($bakiye_miktar_s);

            /*

            $file = 'assets/excel/cari_1.xlsx';

            $adi_s           = 9; //boş olamaz
            $vn_s            = ""; //boş olamaz
            $cep_s           = 11;
            $adr_s           = 13;
            $il_s            = 17;
            $ep_s            = 21;
            $bakiye_durum_s  = "";
            $bakiye_miktar_s = "";*/
//Yükleme ve post alma fonksiyonu buraya
            $n = 1;
            include "assets/excel/src/SimpleXLSX.php";
            if ($xlsx = SimpleXLSX::parse($file)) {
                foreach ($xlsx->rows() as $r) {

                    if ($n <= $baslangic) {
                        $n = $n + 1;
                        continue;}
                    //     echo $r[$adi_s]."-".$r[$cep_s]."-".$r[$adr_s]."-".$r[$il_s]."-".$r[$ep_s]."<br>" ;

                    $sql = "INSERT INTO cari ";
                    $db  = "adi_soyadi_unvan";
                    $val = "'" . $r[$adi_s] . "'";

                    if ($vn_s != "") {$db .= ",vergi";}
                    if ($cep_s != "") {$db .= ",tel";}
                    if ($adr_s != "") {$db .= ",adres";}
                    if ($il_s != "") {$db .= "";}
                    if ($ep_s != "") {$db .= ",eposta";}

                    $db .= ",bas_boal_durum";
                    $db .= ",bas_borc_alacak";
                    $db .= ",kullanici_id,kisi_turu";
                    $sql .= "(" . $db . ") values";

                    if ($vn_s != "") {$val .= ",'" . $r[$vn_s] . "'";}
                    if ($cep_s != "") {$val .= ",'" . $r[$cep_s] . "'";}
                    if ($adr_s != "") {$val .= ",'" . $r[$adr_s];}
                    if ($il_s != "") {$val .= " " . $r[$il_s] . "'";}
                    if ($ep_s != "") {$val .= ",'" . $r[$ep_s] . "'";}

                    if ($bakiye_durum_s != "") {
                        if (!is_numeric($r[$bakiye_durum_s])) {
                            $val .= ",0";
                        } else {
                            $val .= "," . $r[$bakiye_durum_s];
                        }

                    } else { $val .= ",0";}
                    if ($bakiye_miktar_s != "") {

                        if (!is_numeric($r[$bakiye_miktar_s])) {
                            $val .= ",0";
                        } else {
                            $val .= "," . $r[$bakiye_miktar_s];
                        }

                    } else { $val .= ",0";}
                    $val .= "," . $this->session->userdata('kullanici_id');
                    $val .= ",2";
                    $sql .= " (" . $val . ")";
                    $this->db->query($sql);
                    $n = $n + 1;
                }

                /*Dosya silinecek*/
                unlink($file);
                /*Dosya silinecek*/
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');

            } else {
                echo SimpleXLSX::parse_error();
            }

        }

    }

    public function excel_urun()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

//Yükleme ve post alma fonksiyonu buraya

            $filename = $_FILES['file']['name'];
            $ext      = pathinfo($filename, PATHINFO_EXTENSION);
            if (($ext != "xls") and ($ext != "csv") and ($ext != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;
            }

            $dizin            = 'assets/excel/';
            $yuklenecek_dosya = $dizin . basename($_FILES['file']['name']);

            $parca = explode(".", $_FILES['file']['name']);
            $say   = count($parca);
            $son   = $say - 1;
            if (($parca[$son] != "xls") and ($parca[$son] != "csv") and ($parca[$son] != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            echo '<pre>';
            if (move_uploaded_file($_FILES['file']['tmp_name'], $yuklenecek_dosya)) {

            } else {
                echo "Olası dosya yükleme saldırısı!\n";
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            $file = 'assets/excel/' . $_FILES['file']['name'];

            $baslangic = trim($this->input->post('baslangic', true));
            $baslangic = strip_tags($baslangic);
            $baslangic = htmlentities($baslangic);

            if (($baslangic == "") or (!is_numeric($baslangic))) {
                $baslangic = 0;
            }

            $adi = trim($this->input->post('adi', true));
            $adi = strip_tags($adi);
            $adi = htmlentities($adi);

            $kod = trim($this->input->post('kod', true));
            $kod = strip_tags($kod);
            $kod = htmlentities($kod);

            $adt = trim($this->input->post('adt', true));
            $adt = strip_tags($adt);
            $adt = htmlentities($adt);

            $fiyat = trim($this->input->post('fiyat', true));
            $fiyat = strip_tags($fiyat);
            $fiyat = htmlentities($fiyat);

            /*

            $file = 'assets/excel/cari_1.xlsx';

            $adi           = 4; //boş olamaz
            $kod            = 0; //boş olamaz
            $adt           = 16;
            $fiyat           = 18;

             */

//Yükleme ve post alma fonksiyonu buraya
            $n = 1;
            include "assets/excel/src/SimpleXLSX.php";
            if ($xlsx = SimpleXLSX::parse($file)) {
                foreach ($xlsx->rows() as $r) {

                    if ($n <= $baslangic) {
                        $n = $n + 1;
                        continue;}
                    //     echo $r[$adi_s]."-".$r[$cep_s]."-".$r[$adr_s]."-".$r[$il_s]."-".$r[$ep_s]."<br>" ;

                    $sql = "INSERT INTO hizmet_urun ";
                    $db  = "adi";
                    $val = "'" . $r[$adi] . "'";

                    if ($kod != "") {$db .= ",urun_kodu";}
                    if ($adt != "") {$db .= ",bas_stok";}
                    if ($fiyat != "") {$db .= ",satis_fiyat";}
                    $db .= ",kullanici_id";

                    $sql .= "(" . $db . ") values";

                    if ($kod != "") {$val .= ",'" . $r[$kod] . "'";}
                    if ($adt != "") {$val .= ",'" . $r[$adt] . "'";}
                    if ($fiyat != "") {$val .= ",'" . $r[$fiyat] . "'";}

                    $val .= "," . $this->session->userdata('kullanici_id');
                    $sql .= " (" . $val . ")";
                    $this->db->query($sql);

                    $n = $n + 1;
                }

                /*Dosya silinecek*/
                unlink($file);
                /*Dosya silinecek*/
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');

            } else {
                echo SimpleXLSX::parse_error();
            }

        }

    }

    public function excel_kasa()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

//Yükleme ve post alma fonksiyonu buraya

            $filename = $_FILES['file']['name'];
            $ext      = pathinfo($filename, PATHINFO_EXTENSION);
            if (($ext != "xls") and ($ext != "csv") and ($ext != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;
            }

            $dizin            = 'assets/excel/';
            $yuklenecek_dosya = $dizin . basename($_FILES['file']['name']);

            $parca = explode(".", $_FILES['file']['name']);
            $say   = count($parca);
            $son   = $say - 1;
            if (($parca[$son] != "xls") and ($parca[$son] != "csv") and ($parca[$son] != "xlsx")) {
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            echo '<pre>';
            if (move_uploaded_file($_FILES['file']['tmp_name'], $yuklenecek_dosya)) {

            } else {
                echo "Olası dosya yükleme saldırısı!\n";
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');
                return false;

            }

            $file = 'assets/excel/' . $_FILES['file']['name'];

            $baslangic = trim($this->input->post('baslangic', true));
            $baslangic = strip_tags($baslangic);
            $baslangic = htmlentities($baslangic);

            if (($baslangic == "") or (!is_numeric($baslangic))) {
                $baslangic = 0;
            }

            $adi = trim($this->input->post('adi', true));
            $adi = strip_tags($adi);
            $adi = htmlentities($adi);

            $kod = trim($this->input->post('kod', true));
            $kod = strip_tags($kod);
            $kod = htmlentities($kod);

            $tur = trim($this->input->post('tur', true));
            $tur = strip_tags($tur);
            $tur = htmlentities($tur);

            $bky = trim($this->input->post('bky', true));
            $bky = strip_tags($bky);
            $bky = htmlentities($bky);

            /*

            $file = 'assets/excel/cari_1.xlsx';

            $adi           = 2; //boş olamaz
            $kod            = 0; //boş olamaz
            $tur           = 1;
            $bky           = 3;

             */

//Yükleme ve post alma fonksiyonu buraya
            $n = 1;
            include "assets/excel/src/SimpleXLSX.php";
            if ($xlsx = SimpleXLSX::parse($file)) {
                foreach ($xlsx->rows() as $r) {

                    if ($n <= $baslangic) {
                        $n = $n + 1;
                        continue;}
                    //     echo $r[$adi_s]."-".$r[$cep_s]."-".$r[$adr_s]."-".$r[$il_s]."-".$r[$ep_s]."<br>" ;

                    $sql = "INSERT INTO kasa ";
                    $db  = "adi";
                    $val = "'" . $r[$adi] . "'";

                    if ($kod != "") {$db .= ",kodu";}
                    if ($tur != "") {$db .= ",turu";}
                    if ($bky != "") {$db .= ",bas_kasa";}
                    $db .= ",kullanici_id";

                    $sql .= "(" . $db . ") values";

                    if ($kod != "") {$val .= ",'" . $r[$kod] . "'";}
                    if ($tur != "") {$val .= ",'" . $r[$tur] . "'";}
                    if ($bky != "") {$val .= ",'" . $r[$bky] . "'";}

                    $val .= "," . $this->session->userdata('kullanici_id');
                    $sql .= " (" . $val . ")";
                    $this->db->query($sql);

                    $n = $n + 1;
                }

                /*Dosya silinecek*/
                unlink($file);
                /*Dosya silinecek*/
                $this->load->library('messages');
                $this->messages->config('yonetim/aktarimlar');

            } else {
                echo SimpleXLSX::parse_error();
            }

        }

    }

    public function aktarimlar()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $data['sayfa'] = 'Aktarımlar';

            $this->load->view('aktarim.php', $data);

        }

    }

    /***E FATURA İŞLEMLERİ ****/

    public function ef_config()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            //orkestra başvuru , e imza , kontör , musteri , kullanıcı , şifre , api

            $sql   = "SELECT * FROM bina Where kullanici_id=" . $this->session->userdata('kullanici_id');
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $bilgi = $query->result_array();
            } else {
                $bilgi = "";
            }

            if ($bilgi): foreach ($bilgi as $dizi):

                    $mus = $dizi["orkestra_musteri_no"];
                    $kul = $dizi["orkestra_kullanici"];
                    $sif = $dizi["orkestra_sifre"];
                    $api = $dizi["orkestra_api"];

                endforeach;endif;

           

            return $conf = array("musteri" => $mus, "kullanici" => $kul, "sifre" => $sif, "url" => ork_portal , "apikey" => $api);

        }

    }

    public function efatura_login()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

/*
require_once APPPATH . 'libraries\orkestra\efaturacim_service.php';
$conf = array("musteri"=>"zirveinternet", "kullanici"=>"zirveinternet", "sifre"=>"958162","url"=>"https://b2.orkestra.com.tr/efaturacim/servis.php", "apikey"=>"93a1683d714b01643de1eca115ca3e5aab43be602f137a6f2a101dc05ffed49851e9607306d6685d8cfc33e9dc98866314b612a88e05c1899123eb5ea3fdcf1d62e3fdc1f5265b813c4da1cf203896c5ce4f369e716be911523cb2d29819a505f2db4e155fe65d4bbb2dbabfe8b29b5b13556856457e554b53e64e8e48f0be07c07bbd798998cc250b2a971307b038d0");

$efaturacim = new EFATURACIM_ISTEMCI($conf);
if($efaturacim->login()){
echo 1;
}else{
echo 2;
}

return FALSE;

 */

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf = $this->ef_config();

            $efaturacim = new EFATURACIM_ISTEMCI($conf);
            $sonuc      = $efaturacim->login();

            $efaturacim->logout();


            if ($sonuc) {
                $efaturacim->showAsHtml("<br><br><button onclick='history.go(-1)'>Geri Dön</button><br><br>Kullanıcı adı ve şifre doğru.", "E-FATURACIM ÖRNEK UYGULAMA EKRANI", "success"); return FALSE;
            } else {
                $efaturacim->showAsHtml("Kullanıcı adı ve şifreniz uygun değil.<br/>Gelen cevap:<br/>" . $efaturacim->_lastMsg, "E-FATURACIM ÖRNEK UYGULAMA EKRANI", "danger");
            }

        }

    }

    public function orkestra_bilgi($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;

                $this->load->model('admin_model');
                $yetki_kontrol_bina = $this->admin_model->yetki_kontrol_bina($this->session->userdata('kullanici_id'), $primary_key);

                if ($yetki_kontrol_bina != 1) {

                    $this->load->library('Messages');
                    echo $this->messages->config('yonetim');
                    return false;

                }

            }

            $crud->set_theme('flexigrid');
            $crud->set_table('bina');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->set_subject('Orkestra Bilgileri');
            $crud->columns('orkestra_musteri_no', 'orkestra_kullanici');
            $crud->field_type('kullanici_id', 'hidden');
            $crud->unset_edit_fields('adi', 'email', 'tel', 'para_birim', 'adres', 'vergi_dairesi', 'vergi_no', 'blok', 'kullanici_id');

            $crud->unset_back_to_list();
            $crud->unset_add();
            $crud->unset_read();

            $crud->unset_delete();
            $this->log_grocery($crud, "Orkestra", "bina");

            $this->crud_status($crud, 0, 1, 0, 0); // add edit read delete

            $data['side_menu'] = "Orkestra Ayarları";
            $data['kilavuz']   = "  <b>Orkestra Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function efatura_vkn_sorgu()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $this->load->model('admin_model');
            $uye_vkn_getir = $this->admin_model->uye_vkn_getir($this->session->userdata('kullanici_id'));

            $sonuc     = $efaturacim->login();
            $gyazilim  = $efaturacim->vknSorgula($uye_vkn_getir);
            $maliye    = $efaturacim->vknSorgula($uye_vkn_getir);
            $tc_kimlik = $efaturacim->vknSorgula($uye_vkn_getir);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>' . $gyazilim["msg"];

/*
$efaturacim->showVariablesAsHtml(
array("gyazilim"=>$gyazilim,"maliye"=>$maliye,"tc_kimlik"=>$tc_kimlik),
"E-FATURACIM VKN SORGULAMA SONUÇLARI");
 */
            $efaturacim->logout();

        }

    }

    public function efatura_kontor_sorgu()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            $kalanKontor   = $efaturacim->kalanKontorSayisi();
            $detayliKontor = $efaturacim->kontorDetayi();

/*
$efaturacim->showVariablesAsHtml(
array("kalanKontor" => $kalanKontor, "detayliKontor" => $detayliKontor),
"E-FATURACIM KONTÖR SORGULAMA"
);
 */
            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>' . $kalanKontor["data"]["kalan_kontor"];
            $efaturacim->logout();

        }

    }

    public function getOrnekFaturaArray($fat_id)
    {

//fatura yoksa false dönder , varsa array dönder

        $this->load->model('admin_model');
        $efat_getir = $this->admin_model->efat_getir($fat_id);
        if ($efat_getir == false) {
            $this->load->library('messages');
            $this->messages->config2('yonetim/efatura_listele');
            return false;
        }

        if ($efat_getir): foreach ($efat_getir as $dizi):

                $fat_no = $dizi["fatura_no"];
                $fat_ta = $dizi["tarih"];

                $say = strlen($fat_no);
                if ($say > 7) {

                    $this->load->library('messages');
                    $this->messages->config2('yonetim/efatura_listele');
                    return false;
                }

                if ($say < 7) {
                    $fark = 7 - $say;
                    for ($i = 0; $i < $fark; $i++) {
                        $fat_no = $i . "" . $fat_no;

                    }}

                $fat_no = "S" . date("Ymd") . $fat_no;

                $cari_getir = $this->admin_model->cari_getir($dizi["cari_id"]);
                if ($cari_getir): foreach ($cari_getir as $dizi2):

                        $cari_ad       = $dizi2["adi_soyadi_unvan"];
                        $cari_vergi_no = $dizi2["vergi"];
                        $cari_vergi_da = $dizi2["vergi_dairesi"];
                        $adres_cadde   = $dizi2["adres"];
                        $adres_sokak   = "";
                        $il            = $dizi2["ilce"]."/".$dizi2["il"];
                        $ilce          = "";
                    endforeach;endif;

                $fat_items                     = $this->admin_model->fat_items($fat_id);
                $n                             = 0;if ($fat_items): foreach ($fat_items as $dizi3):
                        $fat_items_product[$n]       = $this->admin_model->fat_items_product($dizi3["hizmet_urun_id"]);
                        $fat_items_product_birim[$n] = $this->admin_model->fat_items_product_birim($dizi3["hizmet_urun_id"]);
                        $n                           = $n + 1;endforeach;endif;

            endforeach;endif;

        $FATURA_DATA = array(

            "FATURA NO"          => $fat_no,
            "FATURA TARİHİ"      => $fat_ta,
            "CARİ ADI"           => "" . $cari_ad . "",
            "CARİ VERGİNO"       => "" . $cari_vergi_no . "",
            "CARİ VERGİ DAİRESİ" => "" . $cari_vergi_da . "",
            "ADRES CADDE"        => "" . $adres_cadde . "",
            "ADRES SOKAK"        => "" . $adres_sokak . "",
            "ADRES İL"           => "" . $il . "",
            "ADRES İLÇE"         => "" . $ilce . "",
            "FATURA SENARYOSU"   => "TEMEL",

        );

        $n                                               = 0;if ($fat_items): foreach ($fat_items as $dizi3):


$pr       = $this->admin_model->fat_items_product($dizi3["hizmet_urun_id"]);

                $satir                                         = $n + 1;
                $FATURA_DATA["SATIR " . $satir . " KOD"]       = "" . $fat_items_product[$n] . "";
                $FATURA_DATA["SATIR " . $satir . " AÇIKLAMA"] = "" . $pr . "";
                $FATURA_DATA["SATIR " . $satir . " MİKTAR"]   = "" . $dizi3["adet"] . "";
                $FATURA_DATA["SATIR " . $satir . " BİRİM"]   = "ADET";

                //   $sonfiyatoran=100-23.337;
                $sonfiyatoran = 100 - $dizi3["indirim"];
                $sonfiyatoran = $sonfiyatoran / 100;

                $FATURA_DATA["SATIR " . $satir . " BİRİM FİYAT"] = round($dizi3["birim_fiyat"] * $sonfiyatoran, 2);
                $FATURA_DATA["SATIR " . $satir . " KDV ORANI"]      = $dizi3["vergi"];

                $n = $n + 1;endforeach;endif;

/*

$FATURA_DATA = array(
"FATURA NO"=>"OTOMATİK",
"FATURA TARİHİ"=>date("Y-m-d"),
"CARİ ADI"=>"TEST A.Ş.",
"CARİ VERGİNO"=>"65401211066",
"CARİ VERGİ DAİRESİ"=>"Mutlu Vergi Dairesi",
"ADRES CADDE"=>"Olmayan Mahalle",
"ADRES SOKAK"=>"Çıkmaz Sokak No:5",
"ADRES İL"=>"Ankara",
"ADRES İLÇE"=>"Çankaya",
"SATIR 1 KOD"=>"KOD1",
"SATIR 1 AÇIKLAMA"=>"ACIKLAMA 1",
"SATIR 1 MİKTAR"=>"3",
"SATIR 1 BİRİM"=>"ADET",
"SATIR 1 BİRİM FİYAT"=>5,
"SATIR 1 KDV ORANI"=>8,
"FATURA SENARYOSU"=>"TİCARİ",
);
return $FATURA_DATA;

 */

        return $FATURA_DATA;
    }

    public function efatura_listele($edit = null, $id = null)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud       = new grocery_CRUD();
            $state      = $crud->getState();
            $state_info = $crud->getStateInfo();

            if ($state == 'read') {
                $crud->set_relation('cari_id', 'cari', 'adi_soyadi_unvan', ['kullanici_id = ' => $this->session->userdata('kullanici_id')]);
            }

            $crud->set_theme('flexigrid');
            $crud->set_table('fatura');
            $crud->where('fatura_turu', "Satış");

            $crud->set_subject('Faturalar');
            $crud->columns('fatura_turu', 'fatura_no', 'cari_id', 'toplam', 'vade_tarihi', 'efatura', 'iptal et', 'sil', 'görüntüle', 'personel');
            $crud->display_as('cari_id', 'Cari Adı');
            $crud->where('kullanici_id', $this->session->userdata('kullanici_id'));
            $crud->field_type('kullanici_id', 'hidden', $this->session->userdata('kullanici_id'));

            $crud->callback_column('cari_id', array($this, 'callback_cari_getir'));
            $crud->callback_after_delete(array($this, 'fatura_delete'));
            $crud->callback_column('efatura', array($this, 'efatura_durum_sorgu'));
            $crud->callback_column('iptal et', array($this, 'efatura_iptal'));
            $crud->callback_column('sil', array($this, 'efatura_sil'));

            $crud->callback_column('görüntüle', array($this, 'efatura_goruntule_link'));
            $crud->callback_column('personel', array($this, 'callback_personel_getir'));

            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_edit();
            $crud->unset_delete();
            $crud->unset_clone();
            $crud->unset_back_to_list();
            $this->log_grocery($crud, "Fatura", "fatura");

            $this->crud_status($crud, 0, 0, 0, 0); // add edit read delete

            $data['side_menu'] = "E-Fatura Ayarları";
            $data['kilavuz']   = "  <b>E-Fatura Ayarları</b>";
            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;
            //  $this->_example_output($output);
            (!empty($_POST["token"])) ? $this->new_page($_POST["token"], $output) :
            $this->load->view('index', (array) $output);

        }
    }

    public function efatura_durum_sorgu($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $efat_durum = $this->admin_model->efat_durum($row->id);
            if ($efat_durum == 1) {
                return "E-Fatura Gönderildi";
            }

            return "Gönderilmedi <a class='btn btn-default' href='" . site_url('yonetim/efatura_gonder/' . $row->id) . "'>Gönder</a>";

        }

    }

    public function efatura_iptal($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $efat_durum = $this->admin_model->efat_durum($row->id);
            if ($efat_durum == 1) {
                return " <a class='btn btn-default' href='" . site_url('yonetim/efatura_iptalet/' . $row->id . '/' . $row->efatura_kayit_no) . "'>İptal Et</a>";
            }

            return "";

        }

    }

    public function efatura_sil($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $this->load->model('admin_model');
            $efat_durum = $this->admin_model->efat_durum($row->id);
            if ($efat_durum == 1) {
                return " <a class='btn btn-default' href='" . site_url('yonetim/efatura_sill/' . $row->id . '/' . $row->efatura_kayit_no) . "'>Sil</a>";
            }

            return "";

        }

    }

    public function efatura_goruntule_link($value, $row)
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            return "<a class='btn btn-default' href='" . site_url('yonetim/efatura_goruntule/' . $row->id) . "'>Görüntüle</a>";

        }

    }

    public function efatura_goruntule($fat_id = null)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();

            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            $faturaData = $this->getOrnekFaturaArray($fat_id);

            if ($faturaData == false) {
                $this->load->library('messages');
                $this->messages->config2('yonetim/efatura_listele');
                return false;

            }

            $sonuc = $efaturacim->faturaYukleArrayData($faturaData, true);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>' . $sonuc["data"]["html"];

            $this->log("Fatura", "fatura", "E-Fatura Görüntüleme", $fat_id);

            /*
            $efaturacim->showVariablesAsHtml(array("faturaData"=>$faturaData,"sonuc"=>$sonuc,"htmlString"=>$htmlString),"FATURA ÖNİZLEME");
             */
            $efaturacim->logout();

        }

    }

    public function efatura_gonder($fat_id = null)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

/* Görüntüle
$faturaData = $this->getOrnekFaturaArray();
$sonuc        = $efaturacim->faturaYukleArrayData($faturaData,true);
$htmlString = $sonuc["data"]["html"];
$efaturacim->showVariablesAsHtml(array("faturaData"=>$faturaData,"sonuc"=>$sonuc,"htmlString"=>$htmlString),"FATURA ÖNİZLEME");

 */
            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            $faturaData = $this->getOrnekFaturaArray($fat_id);

            if ($faturaData == false) {
                $this->load->library('messages');
                $this->messages->config2('yonetim/efatura_listele');
                return false;

            }

            $sonuc = $efaturacim->faturaYukleArrayData($faturaData);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>';
            echo "<h2>" . $sonuc["data"]["tip"] . "</h2>";
            echo "<h2>" . $sonuc["isok"] . "</h2>";
            echo "<h2>" . $sonuc["msg"] . "</h2>";
            print_r($sonuc["data"]["html"]);
            $tip = $sonuc["data"]["tip"];

            $giden_faturalar = $efaturacim->sonGonderilenFaturalar(1);
            $adet            = count($giden_faturalar["data"][$tip]);
            $arr             = $adet - 1;
            $kayitno         = $giden_faturalar["data"][$tip][$arr]["kayitno"];

            $this->load->model('admin_model');
            $this->admin_model->efatura_db_guncelle($fat_id, $kayitno);
            $eposta = $this->admin_model->musteri_eposta($fat_id);

            echo $ep_sonuc = $this->efaturaposta($kayitno, $tip, $eposta, $tip . " Gönderim");

            $efaturacim->logout();

/*
$efaturacim->showVariablesAsHtml(array("faturaData"=>$faturaData,"sonuc"=>$sonuc),"FATURA GÖNDER ( ARRAY )");
 */

            $this->log("Fatura", "fatura", "E-Fatura Gönderildi", $fat_id);

        }

    }

    public function efatura_sorgu_gun_gonderilen()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            //     $gunSayisi       = 60;
            //    $giden_faturalar = $efaturacim->sonGonderilenFaturalar($gunSayisi);
            $giden_faturalar = $efaturacim->gonderilenFaturalar();

            /*
            $efaturacim->showVariablesAsHtml(array("giden_faturalar"=>$giden_faturalar),"E-FATURACIM FATURA SORGULAMA SONUÇLARI");
             */

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>' . $giden_faturalar["msg"] . "<br>";

            // print_r($giden_faturalar["data"]["efatura"]);
            //    print_r($giden_faturalar["data"]["earsiv"]);
            //   print_r($giden_faturalar["data"]);

            $n = 1;if ($giden_faturalar["data"]["earsiv"]): foreach ($giden_faturalar["data"]["earsiv"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $n = 1;if ($giden_faturalar["data"]["efatura"]): foreach ($giden_faturalar["data"]["efatura"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $efaturacim->logout();

        }

    }

    public function efatura_sorgu_gun_gelen()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            //    $gunSayisi       = 60;
            //   $gelen_faturalar = $efaturacim->sonAlinanFaturalar($gunSayisi);

            $gelen_faturalar = $efaturacim->gelenFaturalar();

/*
$efaturacim->showVariablesAsHtml(array("gelen_faturalar" => $gelen_faturalar), "E-FATURACIM FATURA SORGULAMA SONUÇLARI");
 */

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>' . $gelen_faturalar["msg"] . "<br>";

            // print_r($gelen_faturalar["data"]["efatura"]);
            //    print_r($gelen_faturalar["data"]["earsiv"]);
            //   print_r($gelen_faturalar["data"]);

            $n = 1;if ($gelen_faturalar["data"]["earsiv"]): foreach ($gelen_faturalar["data"]["earsiv"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $n = 1;if ($gelen_faturalar["data"]["efatura"]): foreach ($gelen_faturalar["data"]["efatura"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $efaturacim->logout();

        }

    }

    public function efatura_sorgu_tum()
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            $fatura_sorgusu = $efaturacim->faturaSorgula();
            $basilacak      = array();
            if ($fatura_sorgusu["isok"] && count($fatura_sorgusu["data"]) > 0 && count(@$fatura_sorgusu["data"]["efatura"]) > 0) {
                $basilacak["efatura_ornegi"] = @$fatura_sorgusu["data"]["efatura"][0];
            }
            if ($fatura_sorgusu["isok"] && count($fatura_sorgusu["data"]) > 0 && count(@$fatura_sorgusu["data"]["earsiv"]) > 0) {
                $basilacak["earsiv_ornegi"] = @$fatura_sorgusu["data"]["earsiv"][0];
            }
            $basilacak["fatura_sorgusu"] = $fatura_sorgusu;

            /*
            $efaturacim->showVariablesAsHtml($basilacak, "E-FATURACIM FATURA SORGULAMA SONUÇLARI");
             */

            //     print_r($basilacak["fatura_sorgusu"]["data"]["efatura"]);
            //      print_r($basilacak["fatura_sorgusu"]["data"]["earsiv"]);
            //      print_r($basilacak["fatura_sorgusu"]["data"]);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>';

            $n = 1;if ($basilacak["fatura_sorgusu"]["data"]["earsiv"]): foreach ($basilacak["fatura_sorgusu"]["data"]["earsiv"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $n = 1;if ($basilacak["fatura_sorgusu"]["data"]["efatura"]): foreach ($basilacak["fatura_sorgusu"]["data"]["efatura"] as $dizi):

                    echo $n . ": " . $dizi["kayitno"] . "-" . $dizi["tarih"] . "-" . $dizi["tutar"] . "-" . $dizi["musteri"] . "-" . $dizi["satici"] . "-" . $dizi["tarih"] . "-" . $dizi["fatura_turu"] . "<br>";

                    $n = $n + 1;endforeach;endif;

            $efaturacim->logout();

        }

    }

    public function efatura_iptalet($fat_id, $kayitno)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }

            $iptalsonuc = $efaturacim->earsivFaturaIptali($kayitno);

            $this->load->model('admin_model');
            $this->admin_model->efatura_db_guncelle_2($fat_id, $kayitno);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>';
            print_r($iptalsonuc);

            $efaturacim->logout();

        }

    }

    public function efatura_sill($fat_id, $kayitno)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            $sonuc = $efaturacim->login();
            if ($sonuc != 1) {
                echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
lütfen bilgilerinizi düzenleyin.';
                return false;

            }
            $silsonuc = $efaturacim->earsivFaturasiniSil($kayitno);

            $this->load->model('admin_model');
            $this->admin_model->efatura_db_guncelle_2($fat_id, $kayitno);

            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>';
            print_r($silsonuc);

            $efaturacim->logout();

        }

    }

    public function efaturaposta($kayitNoVeyaFaturaNo, $tur, $posta, $baslik)
    {
        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            require_once APPPATH . 'libraries/orkestra/efaturacim_service.php';
            $conf       = $this->ef_config();
            $efaturacim = new EFATURACIM_ISTEMCI($conf);

            if (($posta == "") or ($kayitNoVeyaFaturaNo == "")) {

                return "<br><b>Müşteri eposta adresi ya da gönderilen fatura bilgisi elde edilemediğinden eposta gönderilemedi.</b>";

            }

            $sonuc = $efaturacim->login();

            // Ornek Efatura no : EFA2016000000023
            // Ornek earsiv fatura no : EAR2016000000058
            //epostaGonder($kayitNoVeyaFaturaNo,$tip="earsiv",$gonderilecekAdresler=null,$konu=null){

            $sonuc = $efaturacim->epostaGonder($kayitNoVeyaFaturaNo, $tur, $posta, $baslik);
            //  $efaturacim->showVariablesAsHtml(array("sonuc"=>$sonuc),"E-FATURA GÖNDERİMİ");

            $efaturacim->logout();
            return "<br><b>E-Posta Gönderim işlemi başarılı.</b>";

        }

    }

 

    /***E FATURA İŞLEMLERİ ****/

       public function sozlesme()
    {
        $online = $this->session->userdata('adminonline');
    

            $data['sayfa'] = 'Sözleşme';

            $this->load->view('sozlesme.php', $data);

        
    }

        public function gizlilik()
    {
        $online = $this->session->userdata('adminonline');
    

            $data['sayfa'] = 'Sözleşme';

            $this->load->view('gizlilik.php', $data);

        
    }
    
    
       public function hata()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            $crud = new grocery_CRUD();

            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Hata Ayarları";
            $data['kilavuz']   = "  <b>Hata Ayarları</b>";
            $this->load->model('admin_model');


            try { $output = $crud->render();} catch (Exception $e) {}
            $output->data = $data;

            //  $this->_example_output($output);
            $this->load->view('hata', (array) $output);

        }

    }
    
    
         public function hataal()
    {

        $online = $this->session->userdata('adminonline');
        if ($this->login_kontrol($online) == true) {

            
        $hd    = $this->input->post('hd', true);
        $hd     = trim($hd);
        $hd     = strip_tags($hd);         
            
        $ac    = $this->input->post('ac', true);
        $ac     = trim($ac);
        $ac     = strip_tags($ac);            
            
        $this->load->library('mail/eposta');
        $this->eposta->hata($this->session->userdata('adminonline'),$hd,$ac);      
                    
        $this->load->library('messages');
        $this->messages->config2('yonetim/hata');
        return false;
                

        }

    }
    
    

}
