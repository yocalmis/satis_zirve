<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Odeme extends CI_Controller
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

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');

if(($this->session->userdata('uye_turu')!=0)and($this->session->userdata('uye_turu')!=1)){

                $this->load->library('messages');
                $this->messages->config('yonetim/cikis');
                return false;    
}




    }

    public function index()
    {

        $this->load->library('messages');
        $this->messages->config('Odeme/odeme');
        return false;
    }

    public function odeme()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {

                $this->messages->config('');
            } else {

                $this->messages->config('');

            }

        } else {
/*
            if ($this->session->userdata('odeme') != 1) {

                $this->load->library('messages');
                $this->messages->config('');
                return false;
            }
*/
            $this->load->library('messages');
            $this->messages->config('Odeme/odeme_2');
            return false;

        }

    }

    public function odeme_2()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {

                $this->messages->config('');
            } else {

                $this->messages->config('');

            }

        } else {
/*
            if ($this->session->userdata('odeme') != 1) {
                $this->load->library('messages');
                $this->messages->config('');
                return false;
            }
*/
            $this->load->model('admin_model');



            $this->session->set_userdata('fiyat', 499);
            $this->session->set_userdata('vergi', 18);
            $this->session->set_userdata('odeme_miktar', round($this->session->userdata('fiyat') * 1.18, 2));

            $data["odeme_miktar"] = $this->session->userdata('odeme_miktar');
            $data["uye_id"]       = $this->session->userdata('kullanici_id');
            $this->load->model('admin_model');
            $sql   = "SELECT * FROM uyeler Where id=" . $this->session->userdata('kullanici_id');
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row) {
                $username = $row['username'];
                $mid      = $row['id'];
                $nm       = $row['name'];
                $sm       = $row['surname'];
                $tel      = $row['tel'];
                $em       = $row['email'];
                $adr      = $row['adres'];
                $il       = $row['il'];
                $ul       = $row['ulke'];
                $pk       = $row['posta_kod'];

            }


            $this->load->model('admin_model');
            $sql   = "SELECT * FROM uyeler Where id=" . $this->session->userdata('kullanici_id');
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row) {
                $bit_tar = $row['bit_tar'];
                $n=0;
            }
            
            $bugun = date("Y-m-d");
            if($bit_tar<=$bugun){$bit_tar=$bugun; $n=1;}
 if($n==0){echo"<center><br><br><button onclick='history.go(-1)'>Vazgeç</button><br><br>";} 
            ?>

<h2><br><br><center>Değerli üyemiz <?php echo $username; ?> 
<?php if($n==0){echo"üyeliğinizi uzatmak istediniz.<br>İsteğinizi gerçekleştirmek için<br>";} 
else{echo "kullanım süreniz sona ermiştir.<br>Sistemi kullanmaya devam edebilmek için <br>";}
?> 

<?php echo $data["odeme_miktar"]; ?> TL ödeme Yapınız.<br>
Ödemeyi aşağıdaki buton aracalığı ile yapabilirsiniz. </center>

        <?php

            if ($data["uye_id"] == "") {

                $this->load->library('messages');
                $this->messages->config('Odeme/odeme');
                return false;

            }

            if (!is_numeric($data["uye_id"])) {

                $this->load->library('messages');
                $this->messages->config('Odeme/odeme');
                return false;

            }

            if ($data["odeme_miktar"] == "") {

                $this->load->library('messages');
                $this->messages->config('Odeme/odeme');
                return false;

            }

            if (!is_numeric($data["odeme_miktar"])) {

                $this->load->library('messages');
                $this->messages->config('Odeme/odeme');
                return false;

            }

            echo "<center>";
            $rakam = $data["odeme_miktar"];
            $bid   = "TicariYenileme";
            $this->load->library('funcs');
            $ip     = $this->funcs->GetIP('');
            $sip    = rand(100000000, 999999999);
            $sip    = $sip . "" . date("Y-m-d h:i:s");
            $sip    = md5($sip);
            $bugun  = date("Y-m-d h:i:s");
            $buyil  = date("Y");
            $seneye = $buyil + 1;
            $bitis  = $seneye . "" . date("-m-d h:i:s");

            require_once form;
            echo "</center>";
        }
    }

    public function odeme_3()
    {
        $this->load->library('messages');
        $this->messages->config('');
        return false;

        require_once odeme;

# create request class
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $token = $_POST["token"];
        $request->setToken($token);

# make request
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

# print result
        //print_r($checkoutForm);

//print_r($checkoutForm->getStatus());
        print_r($checkoutForm->getPaymentStatus());
//print_r($checkoutForm->getErrorMessage());

    }

    public function odeme_al()
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {

                $this->messages->config('');
            } else {

                $this->messages->config('');

            }

        }
/*
        if ($this->session->userdata('odeme') != 1) {
            $this->load->library('messages');
            $this->messages->config('');
            return false;
        }
*/
        require_once odeme;

# create request class
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $token = $_POST["token"];
        $request->setToken($token);

# make request
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

        $checkoutForm->getPaymentStatus();

# print result

//print_r($checkoutForm->getStatus());
       // print_r($checkoutForm->getPaymentStatus());
        //print_r($checkoutForm->getErrorMessage());

        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {

            //db Tarih güncelle , session odeme durum güncelle    , yönlendir
            echo "İşlem Başarılı";

            $this->load->model('admin_model');
            $sql   = "SELECT * FROM uyeler Where id=" . $this->session->userdata('kullanici_id');
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row) {
                $bit_tar = $row['bit_tar'];
            }

            $bugun = date("Y-m-d");
            if($bit_tar<=$bugun){$bit_tar=$bugun;}


            $tr    = explode("-", $bit_tar);
            $yil   = $tr[0] + 1;
            $trson = $yil . "-" . $tr[1] . "-" . $tr[2];

            $insert = array(
                'bit_tar' => $trson,
            );
            $this->db->where('id', $this->session->userdata('kullanici_id'));
            $this->db->update('uyeler', $insert);

            $this->session->set_userdata('ps', rand(0, 999999999));
            $this->posta_gonder($this->session->userdata('ps'));

  

            $this->session->set_userdata('odeme', 2);

            $this->load->library('messages');
            $this->messages->config('Odeme/odeme');
            return false;

        } else {
            echo "İşlem Başarısız";

            $this->load->library('messages');
            $this->messages->config('Odeme/odeme');
            return false;

        }

        return false;

    }

    public function posta_gonder($ps = null)
    {

        if ($this->session->userdata('ps') == "") {

            $this->load->library('messages');
            $this->messages->config('Odeme/odeme');
            return false;

        }
        if ($ps == "") {

            $this->load->library('messages');
            $this->messages->config('Odeme/odeme');
            return false;

        }

        if ($this->session->userdata('ps') != $ps) {

            $this->load->library('messages');
            $this->messages->config('Odeme/odeme');
            return false;

        }

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {

                $this->messages->config('');
            } else {

                $this->messages->config('');

            }

        }
/*
        if ($this->session->userdata('odeme') != 1) {
            $this->load->library('messages');
            $this->messages->config('');
            return false;
        }
*/

              $this->load->model('admin_model');
              $data = $this->admin_model->uye_bilgi_getir($this->session->userdata('kullanici_id'));

     

        $faturaData = array(
            "FATURA NO"           => "OTOMATİK",
            "FATURA TARİHİ"       => date("Y-m-d"),
            "CARİ ADI"            => "'".$data["resmi"]."'",
            "CARİ VERGİNO"        => "'".$data["vn"]."'",
            "CARİ VERGİ DAİRESİ"  => "'".$data["vd"]."'",
            "ADRES CADDE"         => "'".$data["ad"]."'",
            "ADRES SOKAK"         => "",
            "ADRES İL"            => "'".$data["il"]."'",
            "ADRES İLÇE"          => "'".$data["ilce"]."'",
            "SATIR 1 KOD"         => "KOD1",
            "SATIR 1 AÇIKLAMA"    => PROGRAM_NAME . "YILLIK YENİLEME",
            "SATIR 1 MİKTAR"      => "1",
            "SATIR 1 BİRİM"       => "ADET",
            "SATIR 1 BİRİM FİYAT" => $this->session->userdata('fiyat'),
            "SATIR 1 KDV ORANI"   => $this->session->userdata('vergi'),
            "FATURA SENARYOSU"    => "TEMEL",
        );

        require_once APPPATH . 'libraries\orkestra\efaturacim_service.php';
        $conf       = array("musteri" => ork_musteri_no, "kullanici" => ork_kullanici, "sifre" => ork_sifre, "url" => ork_portal, "apikey" => ork_api);
        $efaturacim = new EFATURACIM_ISTEMCI($conf);
        $sonuc      = $efaturacim->login();
        if ($sonuc != 1) {
            echo '<br><br><button onclick="history.go(-1)">Geri Dön</button><br><br>Kullanıcı giriş bilgileri yanlış,
        lütfen bilgilerinizi düzenleyin.';
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

        //$eposta = "yocalmis@gmail.com";
        $eposta = $this->session->userdata('email');
        $ep = $efaturacim->epostaGonder($kayitno, $tip, $eposta, $tip . " Gönderim");
        $efaturacim->logout();

        print_r($ep);

    }

}
