<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapor extends CI_Controller
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

    public function index($report = "")
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

            if (is_numeric($report)) {

                $this->load->library('messages');
                $this->messages->config('');
                return false;

            }

            $reports = array("cari", "kasa", "stok", "satis", "nakit");
            $sonuc   = array_search($report, $reports);

            if (!is_numeric($sonuc)) {

                $this->load->library('messages');
                $this->messages->config('');
                return false;

            }

            if ($report == "cari") {

                $data['sonuc'] = $this->cari_getir();
                $data['sayfa'] = 'Cari';

            }

            if ($report == "kasa") {

                $data['sonuc'] = $this->kasa_getir();
                $data['sayfa'] = 'Kasa';

            }

            if ($report == "stok") {

                $data['sonuc'] = $this->stok_getir();
                $data['sayfa'] = 'Stok';

            }

            if ($report == "satis") {

                $data['sonuc'] = $this->satis_getir();
                $data['sayfa'] = 'Satis';

            }

            if ($report == "nakit") {

                $data['sonuc'] = $this->nakit_getir();
                $data['sayfa'] = 'Nakit';

            }

            $this->load->view('rapor.php', $data);
        }

    }

    public function cari_getir()
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

            $this->load->model('rapor_model');
            $sonuc = $this->rapor_model->cari_getir();
            $say   = count($sonuc);
            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $sonuc[$i]["bas_boal_durum"] = intval($sonuc[$i]["bas_boal_durum"]);
            }

        }
        return $sonuc;

    }

    public function kasa_getir()
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

            $this->load->model('rapor_model');
            $sonuc = $this->rapor_model->cari_getir();
            $say   = count($sonuc);
            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $sonuc[$i]["bas_boal_durum"] = intval($sonuc[$i]["bas_boal_durum"]);
            }

        }
        return $sonuc;

    }

    public function stok_getir()
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

            $this->load->model('rapor_model');
            $sonuc = $this->rapor_model->cari_getir();
            $say   = count($sonuc);
            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $sonuc[$i]["bas_boal_durum"] = intval($sonuc[$i]["bas_boal_durum"]);
            }

        }
        return $sonuc;

    }

    public function satis_getir()
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

            $this->load->model('rapor_model');
            $sonuc = $this->rapor_model->cari_getir();
            $say   = count($sonuc);
            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $sonuc[$i]["bas_boal_durum"] = intval($sonuc[$i]["bas_boal_durum"]);
            }

        }
        return $sonuc;

    }

    public function nakit_getir()
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

            $this->load->model('rapor_model');
            $sonuc = $this->rapor_model->cari_getir();
            $say   = count($sonuc);
            $dongu = $say - 1;
            for ($i = 0; $i <= $dongu; $i++) {

                $sonuc[$i]["bas_boal_durum"] = intval($sonuc[$i]["bas_boal_durum"]);
            }

        }
        return $sonuc;

    }

}
