<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Yedek extends CI_Controller
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

    public function index()
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

            if ($this->session->userdata('uye_turu') == 2) {

                if ($this->session->userdata('yetki') != 0) {
                    $this->load->library('messages');
                    $this->messages->config('');
                    return false;

                }
            }



            error_reporting(0);

            $dosyalar = scandir("assets/uploads/yedek");
            $say      = count($dosyalar);
            $n[]      = "";
            $s        = 0;
            for ($i = $say; $i >= 0; $i--) {

                $parca = explode("-", $dosyalar[$i]);
                if ($parca[2] == $this->session->userdata('kullanici_id')) {
                    $n[$s] = $dosyalar[$i];
                    $s     = $s + 1;
                }

            }



            $crud = new grocery_CRUD();
            $crud->set_table('borc_alacak');

            $data['side_menu'] = "Yedekleme Ayarları";
            $data['kilavuz']   = "  <b>Yedekleme Ayarları</b>";
            $data['yedekler']  = $n;
            $this->load->model('admin_model');

            $output       = $crud->render();
            $output->data = $data;

            //  $this->_example_output($output);

               


            $this->load->view('yedek', (array) $output);

        }
    }

    public function backupDatabaseTables($dbHost, $dbUsername, $dbPassword, $dbName, $id = "", $tables = '*')
    {
        //veritabanı bağlantısı

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

            if ($this->session->userdata('uye_turu') == 2) {

                if ($this->session->userdata('yetki') != 0) {
                    $this->load->library('messages');
                    $this->messages->config('');
                    return false;

                }
            }

            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

            //tüm tabloları alalım
            if ($tables == '*') {
                $tables = array();
                $result = $db->query("SHOW TABLES");
                while ($row = $result->fetch_row()) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }
            $return = "";
            //tablolar içerisinde dönelim
            foreach ($tables as $table) {
                if ($id != "") {
                    $result = $db->query("SELECT * FROM " . $table . " WHERE kullanici_id=" . $id);
                } else {
                    $result = $db->query("SELECT * FROM " . $table);
                }
                $numColumns = $result->field_count;

                //  $return .= "DROP TABLE ".$table;
                if ($id != "") {
                    if(($table=="ayar")or($table=="sss")){ }
                        else{$return .= "DELETE FROM " . $table . " WHERE kullanici_id=" . $id.";";}                 
                } else {
                    $return .= "DELETE FROM " . $table.";";
                }
                //    $result2 = $db->query("SHOW CREATE TABLE ".$table);
                //   $row2 = $result2->fetch_row();

                $return .= "\n\n";

                for ($i = 0; $i < $numColumns; $i++) {
                    while ($row = $result->fetch_row()) {
                        $return .= "INSERT INTO " . $table . " VALUES(";
                        for ($j = 0; $j < $numColumns; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                            if (isset($row[$j])) {$return .= '"' . $row[$j] . '"';} else { $return .= '""';}
                            if ($j < ($numColumns - 1)) {$return .= ',';}
                        }
                        $return .= ");\n";
                    }
                }

                $return .= "\n\n\n";
            }
            if ($id == "") {$id = "tum";}
            //dosyayı kaydedelim
            $tr     = date("Y_m_d_H_i_s");
            $handle = fopen('assets/uploads/yedek/zirve-ticari-' . $id . '-' . $tr . '.sql', 'w+');
            fwrite($handle, $return);
            fclose($handle);

        }
    }

    public function yedek_al()
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

            if ($this->session->userdata('uye_turu') == 2) {

                if ($this->session->userdata('yetki') != 0) {
                    $this->load->library('messages');
                    $this->messages->config('');
                    return false;

                }
            }

  






            error_reporting(0);

            $dosyalar = scandir("assets/uploads/yedek");
            $say      = count($dosyalar);
            $n[]      = "";
            $s        = 0;
            for ($i = $say; $i >= 0; $i--) {

                $parca = explode("-", $dosyalar[$i]);
                if ($parca[2] == $this->session->userdata('kullanici_id')) {
                    $n[$s] = $dosyalar[$i];
                    $s     = $s + 1;
                }

            }

            $pr = explode("-", $n[0]);
            $pr = explode(".", $pr[3]);
            $pr = explode("_", $pr[0]);
            $tr = $pr[0] . "-" . $pr[1] . "-" . $pr[2] . " " . $pr[3] . ":" . $pr[4] . ":" . $pr[5];

            $baslangic    = strtotime($tr);
            if($baslangic!=""){
            $bitis        = strtotime(date("Y-m-d H:i:s"));
            $fark         = abs($bitis - $baslangic);

            $toplantiSure = $fark / 60;
            

            if ($toplantiSure < 60) {
                
                $this->load->library('Messages');
                echo $this->messages->False_Add('yedek');
                return false;
            }

}




            $dosyalar = scandir("assets/uploads/yedek");
            $say      = count($dosyalar);
            $n[]      = "";
            $s        = 0;
            for ($i = $say; $i >= 0; $i--) {

                $parca = explode("-", $dosyalar[$i]);
                if ($parca[2] == $this->session->userdata('kullanici_id')) {
                    $n[$s] = $dosyalar[$i];
                    $s     = $s + 1;
                }

            }

            $k = 0;

            foreach ($n as $dosya) {

                if ($k > 3) {
//echo $dosya;
                    unlink("assets/uploads/yedek/" . $dosya);
                }

                $k = $k + 1;
            }

            //    echo $this->backupDatabaseTables('localhost','root','','ticari');
            echo $this->backupDatabaseTables('localhost', 'root', '', 'ticari', $this->session->userdata('kullanici_id'));

            $this->load->library('Messages');
            echo $this->messages->True_Add('yedek');
            return false;

        }
    }

    public function yedek_sil($yedek)
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

            if ($this->session->userdata('uye_turu') == 2) {

                if ($this->session->userdata('yetki') != 0) {
                    $this->load->library('messages');
                    $this->messages->config('');
                    return false;

                }
            }

            $parca = explode("-", $yedek);
            if ($parca[2] != $this->session->userdata('kullanici_id')) {
                $this->load->library('messages');
                $this->messages->config('');
                return false;

            }

            unlink("assets/uploads/yedek/" . $yedek);

            $this->load->library('Messages');
            echo $this->messages->True_Add('yedek');
            return false;

        }
    }

}
