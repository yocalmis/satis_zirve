<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zdrive extends CI_Controller
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

    }

    public function index($id, $em1, $em2)
    {

        $online = $this->session->userdata('adminonline');
        if (empty($online)) {
            $this->load->library('messages');
            $this->load->model('admin_model');
            $sonuc = $this->admin_model->admin_query();

            if ($sonuc) {

                $this->messages->config('');
                return false;
            } else {

                $this->messages->config('');
                return false;
            }

        } else {
            $this->load->library('messages');

            if (($id == "") or ($em1 == "") or ($em2 == "")) {
                $this->messages->config('');
                return false;

            }
            if (!is_numeric($id)) {
                $this->messages->config('');
                return false;

            }


            $this->load->model('admin_model');
            $ticari_mail_kontrol = $this->admin_model->ticari_mail_kontrol($id, $em1, $em2);

            if ($ticari_mail_kontrol == 1) {

//Drive'da var mı konrtol et yoksa kayıt , varsa login ol ve yönlendir

                $CI        = &get_instance();
                $this->db2 = $CI->load->database('db2', true);

                $drive_mail_kontrol = $this->admin_model->drive_mail_kontrol($id, $em1, $em2);

                if ($drive_mail_kontrol == 0) {
//Kayıt
                    $drive_kayit = $this->admin_model->drive_kayit($id, $em1, $em2);

                    echo $this->curl($em1, $em2, "123456");
                    return false;

                } else {

                    echo $this->curl($em1, $em2, "123456");
                    return false;

                }

            } else {
                $this->messages->config('');
                return false;

            }
        }
    }

    public function curl($em1, $em2, $pass)
    {
        $email = $em1 . "@" . $em2;
        ?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<iframe width="100%" height="100%"  frameBorder="0" id="iframe" src="<?php echo base_url(); ?>bedrive/login"></iframe>

<script>

	var scriptContent = `window.addEventListener('DOMContentLoaded', (event) => {
		let emailInput = document.querySelector("input[name='email']");
		let passwordInput = document.querySelector("input[name='password']");
    	emailInput.value = "<?php echo $email; ?>";


		let inputEvt = new Event('input', {
			bubbles: true,
			cancelable: true,
		});
		emailInput.dispatchEvent(inputEvt);

    	passwordInput.value = "<?php echo $pass; ?>";
    	passwordInput.dispatchEvent(inputEvt);
    	document.querySelector("button[type='submit']").click();

    	return false;

	});`;

$("#iframe").contents().find("body").append('<script>' + scriptContent +  '</' + 'script>');
</script>
<?php
}

    public function gib()
    {
        $email = "99806471";
        $pass  = "749530";

        ?>


<iframe id="iframe" style="position:absolute" name="arama" src="https://ivd.gib.gov.tr/tvd_side/main.jsp?token=d1078f5e3dc646b78d5d4e5842f21e97feb48d366bc7617458b6679dec12675154a01fccc42292bb04d926bc259dbc75e39dd8e202535fd70a7098396c74a6f7" width="100%" height="100%" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" >d

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<script>






$(document).ready(function(){

alert(1);
  var myFrame = $("#iframe").contents().find('body');
  myFrame.html("<div>wwww</div>");
                var textareaValue = "'<script>erwrwer";
                myFrame.html(textareaValue);

});



</script>
<?php
}

}
