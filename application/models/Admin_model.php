<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Admin Varm� Yokmu Kontrol Et , Varsa Login'e Yoksa Kay�t sayfas�na y�nlendir

    public function admin_query()
    {

        $sql   = "SELECT * FROM uyeler";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function admin_register_before($username, $email)
    {

        $sql   = "SELECT * FROM uyeler Where username='$username' or email='$email'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function admin_info()
    {
        $sql   = "SELECT * FROM ayar";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    //Admin kaydet

    public function admin_register($data)
    {
        $name     = $this->db->escape_str($data[0]);
        $email    = $this->db->escape_str($data[1]);
        $username = $this->db->escape_str($data[2]);
        $pass     = $this->db->escape_str($data[3]);
        $bina_adi = $this->db->escape_str($data[4]);

        $bugun  = date("Y-m-d");

      // $ondort = date("d.m.Y", strtotime('+14 days'));
       $ondort = date("d.m.Y", strtotime('+365 days'));
      
        $ondort = explode(".", $ondort);
        $ondort = $ondort[2] . "-" . $ondort[1] . "-" . $ondort[0];

        $insert = array(
            'name'     => $name,
            'username' => $username,
            'pass'     => $pass,
            'email'    => $email,
            'status'   => 1,
            'bas_tar'  => $bugun,
            'bit_tar'  => $ondort,        
            'uye_turu' => 1,
            'uye_sayisi'  =>5,
        );

        $into = $this->db->insert('uyeler', $insert);
        if ($into) {

            $insertId = $this->db->insert_id();
            $insert2  = array(
                'kullanici_id' => $insertId,

            );
            $this->db->where('id', $insertId);
            $into2 = $this->db->update('uyeler', $insert2);

            $insert3 = array(
                'adi'          => $bina_adi,
                'kullanici_id' => $insertId,

            );

            $binakayit     = $this->db->insert('bina', $insert3);
            $bina_insertId = $this->db->insert_id();

            if ($into2) {return $pass;} else {return 0;}

        } else {return 0;}

    }

    public function kontrol($email)
    {

        $query = $this->db->query("select * from uyeler Where email='$email'");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function pass_getir($email)
    {

        $query = $this->db->query("select * from uyeler Where email='$email'");
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['pass'];

            }

        } else {
            return false;
        }

    }



    public function uye_Varmi($kull)
    {

        $query = $this->db->query("select * from uyeler Where username='$kull'");
        if ($query->num_rows() > 0) {
            return 1;

           

        } else {
            return 0;
        }

    }





    public function sifre_guncelle($sf, $pass)
    {

        $insert = array(
            'pass' => $sf,

        );
        $this->db->where('pass', $pass);
        $into = $this->db->update('uyeler', $insert);
        if ($into) {return 1;} else {return 0;}

    }

    //Admin login kontrol

    public function admin_return($data)
    {

        $username = $this->db->escape_str($data[0]);
        $pass     = $this->db->escape_str($data[1]);
        $bugun    = date("Y-m-d");

        $query = $this->db->query("select * from uyeler Where username='$username' and pass='$pass' and kullanici_id='$data[2]' and status=1");
        if ($query->num_rows() > 0) {

            $query2 = $this->db->query("select * from uyeler Where username='$username' and pass='$pass' and status=1 and bas_tar<='" . $bugun . "' and bit_tar >='" . $bugun . "' ");
            if ($query2->num_rows() > 0) {

                foreach ($query2->result_array() as $row2) {
                    $uye_turu     = $row2['uye_turu'];
                    $kullanici_id = $row2['kullanici_id'];
                }

                if ($uye_turu != 2) {
                    return 1;
                }

                if ($uye_turu == 2) {
                    $kullanici_id_tarih_kontrol = $this->kullanici_id_tarih_kontrol($kullanici_id);
                    if ($kullanici_id_tarih_kontrol != 1) {

                        return 0;

                    }
                    return 1;

                }

            } else {

                foreach ($query->result_array() as $row) {
                    $uye_turu     = $row['uye_turu'];
                    $kullanici_id = $row['kullanici_id'];
                }

                if ($uye_turu == 2) {
                    return 0;
                } else {

                    return 2;

                }

            }

        } else {

            return 0;
        }

        $query = $this->db->query("select * from uyeler Where username='$username' and pass='$pass' and status=1 and bas_tar<='" . $bugun . "' and bit_tar >='" . $bugun . "' ");
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $uye_turu     = $row['uye_turu'];
                $kullanici_id = $row['kullanici_id'];
            }

            $kullanici_id_tarih_kontrol = $this->kullanici_id_tarih_kontrol($kullanici_id);

            if ($uye_turu == 2) {
                if ($kullanici_id_tarih_kontrol != 1) {

                    return 0;

                }
                return 1;

            } else {
                if ($kullanici_id_tarih_kontrol != 1) {

                    return 2;

                }
                return 1;

            }

        } else {

            return 0;

        }

    }

    public function kullanici_id_tarih_kontrol($kul)
    {

        $bugun = date("Y-m-d");

        $query = $this->db->query("select * from uyeler Where id=" . $kul . " and status=1 and bas_tar<='" . $bugun . "' and bit_tar >='" . $bugun . "' ");
        if ($query->num_rows() > 0) {return 1;} else {return 0;}

    }

    public function admin_bilgi($data)
    {
        $username = $this->db->escape_str($data[0]);
        $pass     = $this->db->escape_str($data[1]);

        $query = $this->db->query("select * from uyeler Where username='$username' and pass='$pass' ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }
	
	
	
    public function uye_carisi_getir($id,$kullanici_id)
    {
       
        $query = $this->db->query("select * from uye_cari Where uye=".$id." and kullanici=".$kullanici_id);
        foreach ($query->result_array() as $row) {
            return $row['cari'];
        }
		

    }


    public function para_birimi($kullanici_id)
    {

        $query = $this->db->query("select * from bina Where kullanici_id=" . $kullanici_id . "");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function mail_cikis($ep1, $ep2)
    {

        $ep = $ep1 . "@" . $ep2;

        $query = $this->db->query("update cari set eposta_durum=0 Where eposta='$ep'");
        if ($query) {return 1;} else {return 0;}

    }

    public function mail_getir($kul_id)
    {

        $sql   = "SELECT eposta FROM cari Where kullanici_id=" . $kul_id . " and eposta_durum=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function uye_onay($pass)
    {

        $insert = array(
            'status' => 1,

        );
        $this->db->where('pass', $pass);
        $into = $this->db->update('uyeler', $insert);
        if ($into) {

            return 1;

        } else {return 0;}

    }

    public function mails($pass)
    {

        $query = $this->db->query("select * from uyeler Where pass='$pass'");
        foreach ($query->result_array() as $row) {
            return $row['email'];
        }

    }

    public function uye_turu_getir($online)
    {
        $query = $this->db->query("select * from uyeler Where username='$online'");
        foreach ($query->result_array() as $row) {
            return $row['uye_turu'];
        }

    }

    public function uye_id_getir($online)
    {
        $query = $this->db->query("select * from uyeler Where username='$online'");
        foreach ($query->result_array() as $row) {
            return $row['id'];
        }

    }

    public function yetki_kontrol_bina($kul_id, $id)
    {
        $query = $this->db->query("select * from bina Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_mesaj($kul_id, $id)
    {
        $query = $this->db->query("select * from uyeler Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_gorusme($kul_id, $id)
    {
        $query = $this->db->query("select * from gorusme Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_blok($kul_id, $id)
    {
        $query = $this->db->query("select * from blok Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_arac($kul_id, $id)
    {
        $query = $this->db->query("select * from arac Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function blok_bilgi_getir($kul_id, $id)
    {
        $query = $this->db->query("select * from blok Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function daire_say($kul_id, $id)
    {
        $query = $this->db->query("select * from daire Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        return $query->num_rows();

    }

    public function yetki_kontrol_daire($kul_id, $id)
    {
        $query = $this->db->query("select * from daire Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_cek_senet($kul_id, $id)
    {
        $query = $this->db->query("select * from cek_senet Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_cari($kul_id, $id)
    {
        $query = $this->db->query("select * from cari Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_zimmet($kul_id, $id)
    {
        $query = $this->db->query("select * from zimmet Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_izin($kul_id, $id)
    {
        $query = $this->db->query("select * from izin Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_hiz($kul_id, $id)
    {
        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_gider($kul_id, $id)
    {
        $query = $this->db->query("select * from gider_kategori Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_kasa($kul_id, $id)
    {
        $query = $this->db->query("select * from kasa Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_komite($kul_id, $id)
    {
        $query = $this->db->query("select * from komite Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function blok_ad($id)
    {
        $query = $this->db->query("select * from blok Where id='" . $id . "'");
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function cari_ad($id)
    {
        $query = $this->db->query("select * from cari Where id='" . $id . "'");
        foreach ($query->result_array() as $row) {
            return $row['adi_soyadi_unvan'];
        }

    }

    public function arac_ad($id)
    {
        $query = $this->db->query("select * from arac Where id='" . $id . "'");
        foreach ($query->result_array() as $row) {
            return $row['arac_adi'];
        }

    }

    public function uye_ad($id)
    {
        $query = $this->db->query("select * from uyeler Where id=" . $id);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                return $row['name'];
            }
        }

        return "Olmayan Üye";

    }

    public function demirbas_ad($id)
    {
        $query = $this->db->query("select * from hizmet_urun Where id='" . $id . "'");
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function kasa_ad($id)
    {
        $query = $this->db->query("select * from kasa Where id='" . $id . "'");
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function yetki_kontrol_uye($kul_id, $id)
    {
        $query = $this->db->query("select * from uyeler Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_dosya($kul_id, $id)
    {
        $query = $this->db->query("select * from dosyalar Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_kategori($kul_id, $id)
    {
        $query = $this->db->query("select * from kategori Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }


    public function yetki_kontrol_urun_kategori($kul_id, $id)
    {
        $query = $this->db->query("select * from urun_kategori Where id=" . $id . " and kullanici=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
	
	    public function yetki_kontrol_urun_eslestir($kul_id, $id)
    {
        $query = $this->db->query("select * from uruneslestir Where uruneslestir_id=" . $id . " and uruneslestir_kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
	
		    public function yetki_kontrol_hedef($kul_id, $id)
    {
        $query = $this->db->query("select * from hedefler Where hedef_id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
	

    public function yetki_kontrol_gelir_gider($kul_id, $id)
    {
        $query = $this->db->query("select * from islem Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_virman($kul_id, $id)
    {
        $query = $this->db->query("select * from virman Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_borc($kul_id, $id)
    {
        $query = $this->db->query("select * from borc_alacak Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function virman_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM virman Where kullanici_id=" . $kul_id . " and id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function islem_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM islem Where kullanici_id=" . $kul_id . " and relation_id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function islem_kayit($data)
    {

        $insert = array(
            'islem_turu'    => 1,
            'relation_type' => "Banka",
            'relation_id'   => $data[0],
            'giris_cikis'   => 0,
            'tutar'         => $data[3],
            'tarih'         => $data[4],
            'aciklama'      => $data[5],
            'kasa_id'       => $data[1],
            'kullanici_id'  => $data[6],
            'cari_id'       => 0,
            'kategori'      => "",
        );

        $into = $this->db->insert('islem', $insert);

        if ($into) {

            $insert2 = array(
                'islem_turu'    => 1,
                'relation_type' => "Banka",
                'relation_id'   => $data[0],
                'giris_cikis'   => 1,
                'tutar'         => $data[3],
                'tarih'         => $data[4],
                'aciklama'      => $data[5],
                'kasa_id'       => $data[2],
                'kullanici_id'  => $data[6],
                'cari_id'       => 0,
                'kategori'      => "",
            );

            $into2 = $this->db->insert('islem', $insert2);

            if ($into2) {return true;}
            return false;
        }
        return false;

    }

    public function boal_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM borc_alacak Where kullanici_id=" . $kul_id . " and id=" . $id . "";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function islem_kayit_boal($data)
    {
//1 cari borçlandır
        //2 cari alacaklandır

        $insert = array(
            'islem_turu'    => 2,
            'relation_type' => "Borç_Alacak",
            'relation_id'   => $data[0],
            'giris_cikis'   => $data[1],
            'tutar'         => $data[2],
            'tarih'         => $data[5],
            'aciklama'      => $data[7],
            'kasa_id'       => 0,
            'kullanici_id'  => $data[4],
            'cari_id'       => $data[3],
            'kategori'      => "",
        );

        $into = $this->db->insert('islem', $insert);

        if ($into) {

            return true;
        }
        return false;

    }

    public function toplu_boalkayit($data)
    {
//1 cari borçlandır
        //2 cari alacaklandır

        $insert = array(
            'fatura_turu'  => $data[0],
            'toplam'       => $data[1],
            'cari_id'      => $data[2],
            'kullanici_id' => $data[3],
            'tarih'        => $data[4],
            'aciklama'     => $data[6],
            'vade_tarihi'  => $data[5],
        );

        $into = $this->db->insert('borc_alacak', $insert);

        if ($into) {

            return true;
        }
        return false;

    }

    public function sahip_bos_varmi($kul)
    {
        $query = $this->db->query("select * from daire Where kullanici_id=" . $kul . " and sahip_id=0");
        return $query->num_rows();

    }

    public function cari_baslangic($id, $kul_id)
    {

        $query = $this->db->query("select * from cari Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['bas_borc_alacak'];
        }

    }

    public function cari_baslangic_durum($id, $kul_id)
    {

        $query = $this->db->query("select * from cari Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['bas_boal_durum'];
        }

    }

    public function cari_toplam_getir($id, $kul_id)
    {
        $query = $this->db->query("select * from islem Where cari_id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }



 public function cari_toplam_getir_sondurum($id, $kul_id,$satir)
    {
        $query = $this->db->query("select * from islem Where cari_id=" . $id . " and kullanici_id=" . $kul_id." and id<=".$satir);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }


    public function vade_tarihi_getir($id, $kul_id)
    {

        $query = $this->db->query("select * from borc_alacak Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['vade_tarihi'];
        }

    }

    public function vade_tarihi_getir_fatura($id, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['vade_tarihi'];
        }

    }

    public function yetki_kontrol_cari_detay($kul_id, $id)
    {
        $query = $this->db->query("select * from cari Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_islem($kul_id, $id)
    {
        $query = $this->db->query("select * from islem Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function cari_adi($id, $kul_id)
    {

        $query = $this->db->query("select * from cari Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['adi_soyadi_unvan'];
        }

    }

    public function kasa_adi($id, $kul_id)
    {

        $query = $this->db->query("select * from kasa Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function iade_edilen_fatura_miktari($if, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $if . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['toplam'];
        }

    }

    public function kasa_baslangic($id, $kul_id)
    {

        $query = $this->db->query("select * from kasa Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['bas_kasa'];
        }

    }

    public function kasa_toplam_getir($id, $kul_id)
    {
        $query = $this->db->query("select * from islem Where kasa_id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function yetki_kontrol_kasa_detay($kul_id, $id)
    {
        $query = $this->db->query("select * from kasa Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function list_getir($id)
    {

        $sql   = "SELECT * FROM task Where kim=" . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function log_getir($kid)
    {

        $sql   = "SELECT * FROM log Where kullanici_id=" . $kid . " order by tarih desc limit 0,1000";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function sss_getir()
    {

        $sql   = "SELECT * FROM sss";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function yetki_kontrol_not($kul_id, $id)
    {
        $query = $this->db->query("select * from notlar Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_tartisma($kul_id, $kim, $id)
    {
        $query = $this->db->query("select * from tartisma Where id=" . $id . " and kim=" . $kim . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_tartisma_detay($kul_id, $id)
    {
        $query = $this->db->query("select * from tartisma Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function toplam_tahsilat($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 1);
        $this->db->where('islem_turu', 3);
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {return 0;}
        return $query->row()->tutar;

    }

    public function toplam_odeme($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 0);
        $this->db->where('islem_turu', 3);
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {return 0;}
        return $query->row()->tutar;

    }

    public function toplam_gelir($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 1);
        $this->db->where('islem_turu', 0);
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {return 0;}
        return $query->row()->tutar;

    }

    public function toplam_gider($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 0);
        $this->db->where('islem_turu', 0);
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {return 0;}
        return $query->row()->tutar;

    }

    public function toplam_alis($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 0);
        //$this->db->where('islem_turu', 2);
        $this->db->group_start();
        $this->db->where("islem_turu = 2");
        $this->db->group_end();
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {$borclanilan = 0;}
        $borclanilan = $query->row()->tutar;

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 1);
        //$this->db->where('islem_turu', 2);
        $this->db->group_start();
        $this->db->where("islem_turu = 4");
        $this->db->group_end();
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {$alis = 0;}
        $alis = $query->row()->tutar;

        return $borclanilan + $alis;

    }

    public function toplam_satis($buyil, $bugun_bit)
    {

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 1);
        //$this->db->where('islem_turu', 2);
        $this->db->group_start();
        $this->db->where("islem_turu = 2");
        $this->db->group_end();
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {$borclanilan = 0;}
        $borclanilan = $query->row()->tutar;

        $this->db->select_sum('tutar');
        $this->db->from('islem');
        $this->db->where('giris_cikis', 0);
        //$this->db->where('islem_turu', 2);
        $this->db->group_start();
        $this->db->where("islem_turu = 4");
        $this->db->group_end();
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->tutar) {$alis = 0;}
        $alis = $query->row()->tutar;

        return $borclanilan + $alis;

    }

    public function genel_durum_cari($buyil, $bugun_bit)
    {

        $toplam = 0;
        $query  = $this->db->query("select * from cari Where kullanici_id=" . $this->session->userdata('kullanici_id'));
        foreach ($query->result_array() as $row) {
            $bas_boal_durum  = $row['bas_boal_durum'];
            $bas_borc_alacak = (int)$row['bas_borc_alacak'];
            if ($bas_boal_durum != 0) {} else { $bas_borc_alacak = 0 - $bas_borc_alacak;}

            $toplam = $toplam + $bas_borc_alacak;

        }

        return $toplam;

    }

    public function toplam_durum($buyil, $bugun_bit)
    {

        $top = 0;
        $top = $top + $this->genel_durum_cari($buyil, $bugun_bit);

        $query = $this->db->query("select * from islem where kullanici_id=" . $this->session->userdata('kullanici_id') . " and tarih>='" . $buyil . "' and tarih<='" . $bugun_bit . "'");
        foreach ($query->result_array() as $row) {

            if (($row['islem_turu'] == 0) or ($row['islem_turu'] == 1) or ($row['islem_turu'] == 5)) {continue;}

            if ($row['islem_turu'] == 2) {
                if ($row['giris_cikis'] == 0) {$top = $top - $row['tutar'];}
                if ($row['giris_cikis'] == 1) {$top = $top + $row['tutar'];}
            }

            if ($row['islem_turu'] == 4) {
                if ($row['giris_cikis'] == 0) {$top = $top + $row['tutar'];}
                if ($row['giris_cikis'] == 1) {$top = $top - $row['tutar'];}

            }

            if ($row['islem_turu'] == 3) {
                if ($row['giris_cikis'] == 0) {$top = $top + $row['tutar'];}
                if ($row['giris_cikis'] == 1) {$top = $top - $row['tutar'];}

            }

        }

        return $top;

    }

    public function genel_durum_kasa($buyil, $bugun_bit)
    {

        $this->db->select_sum('bas_kasa');
        $this->db->from('kasa');
        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $query = $this->db->get();
        if (!$query->row()->bas_kasa) {return 0;}
        return $query->row()->bas_kasa;

    }

    public function toplam_durum_kasa($buyil, $bugun_bit)
    {

        //$this->genel_durum_kasa($buyil,$bugun_bit);;

        $top = 0;
        $top = $top + $this->genel_durum_kasa($buyil, $bugun_bit);

        $query = $this->db->query("select * from islem where kullanici_id=" . $this->session->userdata('kullanici_id') . " and tarih>='" . $buyil . "' and tarih<='" . $bugun_bit . "'");
        foreach ($query->result_array() as $row) {

            if (($row['islem_turu'] == 2) or ($row['islem_turu'] == 4) or ($row['islem_turu'] == 1) or ($row['islem_turu'] == 5)) {continue;}

            if ($row['islem_turu'] == 0) {
                if ($row['giris_cikis'] == 0) {$top = $top - $row['tutar'];}
                if ($row['giris_cikis'] == 1) {$top = $top + $row['tutar'];}
            }

            if ($row['islem_turu'] == 3) {
                if ($row['giris_cikis'] == 0) {$top = $top - $row['tutar'];}
                if ($row['giris_cikis'] == 1) {$top = $top + $row['tutar'];}

            }

        }

        return $top;

    }

    /*

    function tarih_durum_giris( $t1,$t2 ) {

    $this->db->select_sum('tutar');
    $this->db->from('islem');
    $this->db->where('giris_cikis',1);
    $this->db->where('tarih>=', $t1);
    $this->db->where('tarih<=', $t2);
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->tutar){return 0;}
    return $query->row()->tutar;

    }

    function tarih_durum_cikis($t1,$t2 ) {

    $this->db->select_sum('tutar');
    $this->db->from('islem');
    $this->db->where('giris_cikis',0);
    $this->db->where('tarih>=', $t1);
    $this->db->where('tarih<=', $t2);
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->tutar){return 0;}
    return $query->row()->tutar;

    }

    function tarih_durum_cari( $t1,$t2 ) {

    $this->db->select_sum('bas_borc_alacak');
    $this->db->from('cari');
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->bas_borc_alacak){return 0;}
    return $query->row()->bas_borc_alacak;

    }

    function durum( $t1,$t2 ) {

    return $this->tarih_durum_giris($t1,$t2)-$this->tarih_durum_cikis($t1,$t2);
    //+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);

    }

    function tarih_kasa_durum_giris( $t1,$t2 ) {

    $this->db->select_sum('tutar');
    $this->db->from('islem');
    $this->db->where('giris_cikis',1);
    $this->db->where('tarih>=', $t1);
    $this->db->where('tarih<=', $t2);
    $this->db->where("(islem_turu = 0 OR islem_turu = 3)");
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->tutar){return 0;}
    return $query->row()->tutar;

    }

    function tarih_kasa_durum_cikis( $t1,$t2 ) {

    $this->db->select_sum('tutar');
    $this->db->from('islem');
    $this->db->where('giris_cikis',0);
    $this->db->where('tarih>=', $t1);
    $this->db->where('tarih<=', $t2);
    $this->db->where("(islem_turu = 0 OR islem_turu = 3)");
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->tutar){return 0;}
    return $query->row()->tutar;

    }

    function tarih_genel_durum_kasa( $t1,$t2 ) {

    $this->db->select_sum('bas_kasa');
    $this->db->from('kasa');
    $this->db->where('kullanici_id',$this->session->userdata('kullanici_id'));
    $query = $this->db->get();
    if(!$query->row()->bas_kasa){return 0;}
    return $query->row()->bas_kasa;

    }

    function kasa( $t1,$t2 ) {

    return $this->tarih_kasa_durum_giris($t1,$t2)-$this->tarih_kasa_durum_cikis($t1,$t2);
    //+$this->genel_durum_giris($buyil,$bugun_bit)-$this->genel_durum_cikis($buyil,$bugun_bit);

    }

     */

    public function tum_urun_getir($kul_id)
    {

        $sql   = "SELECT * FROM hizmet_urun Where kullanici_id=" . $kul_id . " and durum=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function tum_gider_urun_getir($kul_id)
    {

        $sql   = "SELECT * FROM gider_kategori Where kullanici_id=" . $kul_id . " and durum=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function kasa_getir($kul_id)
    {

        $sql   = "SELECT * FROM kasa Where kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function tum_cari_getir($kul_id)
    {
	
        $sql   = "SELECT * FROM cari Where kullanici_id=" . $kul_id . "  and durum=1";			
	

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }
    public function tum_cari_getir2($kul_id,$cid,$utur)
    {
	if(($utur==0)or($utur==1)){
        $sql   = "SELECT * FROM cari Where kullanici_id=" . $kul_id . "  and durum=1";	
   		
	}
	else{
  		
		$sql   = "SELECT * FROM cari Where kullanici_id=" . $kul_id . "  and durum=1 and personel =".$cid;	
	}	
	

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }
    public function personel_getir($kul_id)
    {
        $sql   = "SELECT * FROM cari Where kullanici_id=" . $kul_id . " and kisi_turu=1 and durum=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function tum_uye_getir($kul_id, $id)
    {
        $sql   = "SELECT * FROM uyeler Where kullanici_id=" . $kul_id . " and status=1 and id!=" . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function uye_adi_getir($kul_id, $id)
    {
        $sql   = "SELECT * FROM uyeler Where kullanici_id=" . $kul_id . "  and id=" . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['username'];
            }

        } else {
            return false;
        }

    }
	
	
    public function mus_kayit($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad ,$mn )
    {


        $insert = array(
            'adi_soyadi_unvan'     => $ad,
            'yetkili_kullanici'           => $yet,
            'vergi_dairesi'           => $vd,			
            'vergi'           => $vn,
            'tc'         => $tc,
            'eposta'          => $ep,
            'cep_tel'    => $cp,
            'tel'         => $tl,
            'fax'           => $fx,
            'ilce'     => $ilc,
            'il'         => $il,
            'adres'       => $adr,
            'faaliyet_kodu'        => $fkd,
            'faaliyet_adi'  => $fad,
            'kisi_turu' => 0,
            'durum'        => 1,
	            'bas_boal_durum' => 0,
            'bas_borc_alacak'        => 0,	
            'kullanici_id'        => $this->session->userdata('kullanici_id'),	
            'musteri_no'        => $mn				
			
        );

        $this->db->insert('cari', $insert);
        return $this->db->insert_id();

    }
	
	
	
    public function mus_guncelle($ad, $yet, $vd, $vn, $tc, $ep, $cp, $tl, $fx, $ilc, $il, $adr, $fkd, $fad,$mn , $mid)
    {


        $insert = array(
            'adi_soyadi_unvan'     => $ad,
            'yetkili_kullanici'           => $yet,
            'vergi_dairesi'           => $vd,			
            'vergi'           => $vn,
            'tc'         => $tc,
            'eposta'          => $ep,
            'cep_tel'    => $cp,
            'tel'         => $tl,
            'fax'           => $fx,
            'ilce'     => $ilc,
            'il'         => $il,
            'adres'       => $adr,
            'faaliyet_kodu'        => $fkd,
            'faaliyet_adi'  => $fad,
            'kisi_turu' => 0,
            'durum'        => 1,
	            'bas_boal_durum' => 0,
            'bas_borc_alacak'        => 0,	
            'kullanici_id'        => $this->session->userdata('kullanici_id'),	
            'musteri_no'        => $mn				
			
        );
        $this->db->where('id', $mid);
        $this->db->update('cari', $insert);
        return $this->db->insert_id();

    }

    public function fat_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $kul_id, $per)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}


 if($per==""){$per=0;}
 $insert = array(
            'fatura_turu'     => $fat_turu,
            'tutar'           => $ara_toplam,
            'vergi'           => $vergi,
            'indirim'         => $indirim,
            'toplam'          => $toplam,
            'kullanici_id'    => $kul_id,
            'cari_id'         => $mus,
            'tarih'           => $duz_ta,
            'vade_tarihi'     => $va_ta,
            'seri_no'         => $seri,
            'fatura_no'       => $no,
            'aciklama'        => $ack,
            'irsaliye_durum'  => $irs_durum,
            'gelir_gider_fat' => $gel_gid,
            'personel'        => 11
        );


        $this->db->insert('fatura', $insert);
        return $this->db->insert_id();

    }

    public function iade_fat_kayit($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $kul_id)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}

        $insert = array(
            'fatura_turu'     => $fat_turu,
            'tutar'           => $ara_toplam,
            'vergi'           => $vergi,
            'indirim'         => $indirim,
            'toplam'          => $toplam,
            'kullanici_id'    => $kul_id,
            'cari_id'         => $mus,
            'tarih'           => $duz_ta,
            'vade_tarihi'     => $va_ta,
            'seri_no'         => $seri,
            'fatura_no'       => $no,
            'aciklama'        => $ack,
            'irsaliye_durum'  => $irs_durum,
            'gelir_gider_fat' => $gel_gid,
            'iade_fat'        => $fat_id,
        );

        $this->db->insert('fatura', $insert);
        return $this->db->insert_id();

    }

    public function fat_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,$adm, $kul_id)
    {

if($adm==1){
	
	        $insert = array(
            'fatura_turu'    => $fat_turu,
            'tutar'          => $ara_toplam,
            'vergi'          => $vergi,
            'indirim'        => $indirim,
            'toplam'         => $toplam,
            'kullanici_id'   => $kul_id,
            'cari_id'        => $mus,
            'tarih'          => $duz_ta,
            'vade_tarihi'    => $va_ta,
            'seri_no'        => $seri,
            'fatura_no'      => $no,
            'aciklama'       => $ack,
            'irsaliye_durum' => $irs_durum,
            'personel' => 0,
			

        );
	
}

else{
	
	        $insert = array(
            'fatura_turu'    => $fat_turu,
            'tutar'          => $ara_toplam,
            'vergi'          => $vergi,
            'indirim'        => $indirim,
            'toplam'         => $toplam,
            'kullanici_id'   => $kul_id,
            'cari_id'        => $mus,
            'tarih'          => $duz_ta,
            'vade_tarihi'    => $va_ta,
            'seri_no'        => $seri,
            'fatura_no'      => $no,
            'aciklama'       => $ack,
            'irsaliye_durum' => $irs_durum,
			

        );
	
}


        $this->db->where('id', $fat_id);
        $this->db->update('fatura', $insert);
        //return $this->db->insert_id();

        $this->db->where('fatura_id', $fat_id);
        $this->db->delete('fatura_item');
		
        $this->db->where('fat_id', $fat_id);
        $this->db->delete('ek_kullanici_takip');		

        return true;

    }

    public function islem_kayit_fat($is_t, $rel_t, $fat_id, $gir_cik, $toplam, $duz_ta, $ack, $mus, $fat_turu, $kul_id)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}

        $insert = array(
            'islem_turu'      => $is_t,
            'relation_type'   => $rel_t,
            'relation_id'     => $fat_id,
            'giris_cikis'     => $gir_cik,
            'tutar'           => $toplam,
            'tarih'           => $duz_ta,
            'aciklama'        => $ack,
            'cari_id'         => $mus,
            'kullanici_id'    => $kul_id,
            'gelir_gider_fat' => $gel_gid,
        );

        $this->db->insert('islem', $insert);
        return $this->db->insert_id();

    }

    public function islem_gunc_fat($fat_id, $is_t, $rel_t,  $gir_cik, $toplam, $duz_ta, $ack, $mus, $kul_id)
    {

        $insert = array(
            'islem_turu'    => $is_t,
            'relation_type' => $rel_t,
            'relation_id'   => $fat_id,
            'giris_cikis'   => $gir_cik,
            'tutar'         => $toplam,
            'tarih'         => $duz_ta,
            'aciklama'      => $ack,
            'cari_id'       => $mus,
            'kullanici_id'  => $kul_id,

        );

        $this->db->where('relation_id', $fat_id);
        $this->db->where('islem_turu', 4);
        $this->db->update('islem', $insert);
//    return $this->db->insert_id();

        return true;

    }

    public function irs_getir($mus, $fat_turu, $kul_id)
    {
        $sql   = "SELECT * FROM irsaliye Where kullanici_id=" . $kul_id . " and fatura_turu='$fat_turu' and cari_id=" . $mus;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function islem_kayit_tahsilat_odeme($is_t, $rel_t, $fat_id, $gir_cik, $toplam, $duz_ta, $ack, $mus, $kasa, $fat_turu, $kul_id)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}

        $insert = array(
            'islem_turu'      => $is_t,
            'relation_type'   => $rel_t,
            'relation_id'     => $fat_id,
            'giris_cikis'     => $gir_cik,
            'tutar'           => $toplam,
            'tarih'           => $duz_ta,
            'aciklama'        => $ack,
            'cari_id'         => $mus,
            'kasa_id'         => $kasa,
            'kullanici_id'    => $kul_id,
            'gelir_gider_fat' => $gel_gid,

        );

        $this->db->insert('islem', $insert);
        return $this->db->insert_id();

    }

    public function fat_item_kayit($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,
		

        );

        $this->db->insert('fatura_item', $insert);
        return $this->db->insert_id();

    }
	
	    public function fat_item_kayit_tarihli($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu,$duz_ta, $kul_id)
    {
		
		$p = explode("-",$duz_ta); $yil = $p[0]+1;		

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,
            'baslangic'   => $duz_ta,			
            'gecerlilik'   => $yil."-".$p[1]."-".$p[2],			

        );

        $this->db->insert('fatura_item', $insert);
        return $this->db->insert_id();

    }
	
	
	
	
	  public function ekvkn_kayit($fat_id,$mus,$fat_item_kayit,$item, $ekvkn)
    {
		
		$p = explode("-",$duz_ta); $yil = $p[0]+1;		

        $insert = array(
            'fat_id'      => $fat_id,
            'cari_id'    => $mus,
            'item_id' => $fat_item_kayit,
            'urun_id'           => $item,
            'ek_vkn'    => $ekvkn	

        );

        $this->db->insert('ek_kullanici_takip', $insert);
        return $this->db->insert_id();

    }
	

    public function irs_kayit($fat_turu, $mus, $no, $duz_ta, $va_ta, $il, $adr, $ack, $kul_id)
    {

        $insert = array(
            'fatura_turu'  => $fat_turu,
            'kullanici_id' => $kul_id,
            'cari_id'      => $mus,
            'tarih'        => $duz_ta,
            'vade_tarihi'  => $va_ta,
            'il'           => $il,
            'adres'        => $adr,
            'irsaliye_no'  => $no,
            'aciklama'     => $ack,

        );

        $this->db->insert('irsaliye', $insert);
        return $this->db->insert_id();

    }

    public function irs_guncelle($fat_id, $fat_turu, $mus, $no, $duz_ta, $va_ta, $il, $adr, $ack, $kul_id)
    {

        $insert = array(
            'fatura_turu'  => $fat_turu,
            'kullanici_id' => $kul_id,
            'cari_id'      => $mus,
            'tarih'        => $duz_ta,
            'vade_tarihi'  => $va_ta,
            'il'           => $il,
            'adres'        => $adr,
            'irsaliye_no'  => $no,
            'aciklama'     => $ack,

        );
        $this->db->where('id', $fat_id);
        $this->db->update('irsaliye', $insert);
//    return $this->db->insert_id();

        $this->db->where('fatura_id', $fat_id);
        $this->db->delete('irsaliye_item');

        return true;
    }

    public function irs_item_kayit($fat_id, $item, $qty, $des, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'aciklama'       => $des,
            'kullanici_id'   => $kul_id,

        );

        $this->db->insert('irsaliye_item', $insert);
        return $this->db->insert_id();

    }

    public function urun_hizmet_adi_getir($id, $kul_id)
    {

        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function satis_fiyat($id, $kul_id)
    {

        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['satis_fiyat'];
        }

    }

    public function alis_fiyat($id, $kul_id)
    {

        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['alis_fiyat'];
        }

    }

    public function stok_baslangic($id, $kul_id)
    {

        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['bas_stok'];
        }

    }

    public function stok_toplam_getir($id, $kul_id)
    {
        $query = $this->db->query("select * from fatura_item Where hizmet_urun_id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irs_toplam_getir($id, $kul_id)
    {
        $query = $this->db->query("select * from irsaliye_item Where hizmet_urun_id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fatura_turu_getir($f_id, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['fatura_turu'];
        }

    }

    public function fatura_cari_id_getir($f_id, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['cari_id'];
        }

    }

    public function cek_bilgi_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM cek_senet Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fatura_turu_getir_irs($f_id, $kul_id)
    {

        $query = $this->db->query("select * from irsaliye Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['fatura_turu'];
        }

    }

    public function fatura_tar_getir_irs($f_id, $kul_id)
    {

        $query = $this->db->query("select * from irsaliye Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['tarih'];
        }

    }

    public function fatura_tar_getir_fat($f_id, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['tarih'];
        }

    }

    public function fatura_irs_durum_getir_fat($f_id, $kul_id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $f_id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['irsaliye_durum'];
        }

    }

    public function yetki_kontrol_stok_detay($kul_id, $id)
    {
        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id . "");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function stok_adi($id, $kul_id)
    {

        $query = $this->db->query("select * from hizmet_urun Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }
	
	
    public function ekvkn_getir($id)
    {

        $query = $this->db->query("select * from ek_kullanici_takip Where item_id=" . $id);
        foreach ($query->result_array() as $row) {
            return $row['ek_vkn'];
        }

    }	
	
	

    public function gider_kat_adi($id, $kul_id)
    {

        $query = $this->db->query("select * from gider_kategori Where id=" . $id . " and kullanici_id=" . $kul_id);
        foreach ($query->result_array() as $row) {
            return $row['adi'];
        }

    }

    public function fatura_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM fatura Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function siparis_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM siparis Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function teklif_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM teklif Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irsaliye_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM irsaliye Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function iliski_irs_getir($kul_id)
    {

        $sql   = "SELECT irs_id FROM fat_irs_iliski Where kullanici_id=" . $kul_id . " GROUP BY irs_id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function iliskili_fat_getir($irs_id, $kul_id)
    {

        $sql   = "SELECT fat_id FROM fat_irs_iliski Where irs_id=" . $irs_id . " and kullanici_id=" . $kul_id . " GROUP BY fat_id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function iliski_ft_getir($kul_id)
    {

        $sql   = "SELECT fat_id FROM fat_irs_iliski Where kullanici_id=" . $kul_id . " GROUP BY fat_id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function urunler_irs_item_adet($ur_id, $fat_id, $kul_id)
    {

        $this->db->select_sum('adet');
        $this->db->from('irsaliye_item');
        $this->db->where('hizmet_urun_id', $ur_id);
        $this->db->where('fatura_id', $fat_id);
        $this->db->where('kullanici_id', $kul_id);
        $query = $this->db->get();
        if (!$query->row()->adet) {return 0;}
        return $irs_top = $query->row()->adet;

    }

    public function urunler_irs_fat_item_adet($ur_id, $fat_id, $kul_id)
    {

        $sql   = "SELECT fat_id FROM fat_irs_iliski Where irs_id=" . $fat_id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $iliskili_faturalar = $query->result_array();
        } else {
            $iliskili_faturalar = false;
        }

        $adet = 0;
        $n    = 0;if ($iliskili_faturalar): foreach ($iliskili_faturalar as $dizi2):

                $this->db->select_sum('adet');
                $this->db->from('fatura_item');
                $this->db->where('hizmet_urun_id', $ur_id);
                $this->db->where('fatura_id', $dizi2["fat_id"]);
                $this->db->where('kullanici_id', $kul_id);

                $query = $this->db->get();
                if (!$query->row()->adet) {}
                $adet = $adet + $query->row()->adet;

                $n = $n + 1;endforeach;endif;

        return $adet;

    }

    public function urunler_ft_item_adet($ur_id, $fat_id, $kul_id)
    {

        $this->db->select_sum('adet');
        $this->db->from('fatura_item');
        $this->db->where('hizmet_urun_id', $ur_id);
        $this->db->where('fatura_id', $fat_id);
        $this->db->where('kullanici_id', $kul_id);
        $query = $this->db->get();
        if (!$query->row()->adet) {return 0;}
        return $irs_top = $query->row()->adet;

    }

    public function urunler_fat_irs_item_adet($ur_id, $fat_id, $kul_id)
    {

        $sql   = "SELECT irs_id FROM fat_irs_iliski Where fat_id=" . $fat_id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $iliskili_irsaliyeler = $query->result_array();
        } else {
            $iliskili_irsaliyeler = false;
        }

        $adet = 0;
        $n    = 0;if ($iliskili_irsaliyeler): foreach ($iliskili_irsaliyeler as $dizi2):

                $this->db->select_sum('adet');
                $this->db->from('irsaliye_item');
                $this->db->where('hizmet_urun_id', $ur_id);
                $this->db->where('fatura_id', $dizi2["irs_id"]);
                $this->db->where('kullanici_id', $kul_id);

                $query = $this->db->get();
                if (!$query->row()->adet) {}
                $adet = $adet + $query->row()->adet;

                $n = $n + 1;endforeach;endif;

        return $adet;

    }

    public function fatura_item_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM fatura_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }
	
	  public function fat_kayitygd($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $kul_id, $per)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}


 if($per==""){$per=0;}
 $insert = array(
            'fatura_turu'     => $fat_turu,
            'tutar'           => $ara_toplam,
            'vergi'           => $vergi,
            'indirim'         => $indirim,
            'toplam'          => $toplam,
            'kullanici_id'    => $kul_id,
            'cari_id'         => $mus,
            'tarih'           => $duz_ta,
            'vade_tarihi'     => $va_ta,
            'seri_no'         => $seri,
            'fatura_no'       => $no,
            'aciklama'        => $ack,
            'irsaliye_durum'  => $irs_durum,
            'gelir_gider_fat' => $gel_gid,
            'personel'        => $per,
            'is_ygd'        => 1,			
        );


        $this->db->insert('fatura', $insert);
        return $this->db->insert_id();

    }
	
	    public function fat_item_kayit_tarihliygd($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu,$duz_ta,$ygditemid, $kul_id)
    {
	
		$p = explode("-",$duz_ta); $yil = $p[0]+1;		

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,
            'baslangic'   => $duz_ta,			
            'gecerlilik'   => $yil."-".$p[1]."-".$p[2],			
            'is_ygd'        => 1,
            'is_ygd_item_id'          => $ygditemid,
        );

        $this->db->insert('fatura_item', $insert);
        return $this->db->insert_id();

    }
	
	
	    public function fatura_item_getir_duzenleygd($id, $kul_id)
    {

        $sql   = "SELECT * FROM fatura_item Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function siparis_item_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM siparis_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function teklif_item_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM teklif_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irsaliye_item_getir_duzenle($id, $kul_id)
    {

        $sql   = "SELECT * FROM irsaliye_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function secili_irs_item_say($id, $kul_id)
    {

        $sql   = "SELECT * FROM irsaliye_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        return $query->num_rows();

    }

    public function fatura_odeme_getir($id, $kul_id)
    {

        $sql   = "SELECT * FROM islem Where islem_turu=3 and relation_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fatura_cek_getir($id, $kul_id)
    {

        $sql   = "SELECT * FROM islem Where islem_turu=5 and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fatura_iade_getir($id, $kul_id)
    {

        $sql   = "SELECT * FROM islem Where islem_turu=4 and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fatura_not_getir($tur, $id, $kul_id)
    {

//Where fat_turu='".$tur."' and id=".$id." and kullanici_id=".$kul_id

        $sql   = "SELECT * FROM fatura_not Where fat_turu='" . $tur . "' and fat_id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function iade_kontrol($r_id, $id, $kul_id)
    {

        $sql   = "SELECT * FROM fatura Where id=" . $id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        foreach ($query->result_array() as $row) {
            $iade_fat = $row['iade_fat'];
        }

        if ($iade_fat == $id) {
            return true;
        } else {
            return false;
        }

    }

    public function fatura_irsaliye_getir($id, $kul_id)
    {

        $sql   = "SELECT irs_id FROM fat_irs_iliski Where fat_id=" . $id . " and kullanici_id=" . $kul_id . " GROUP BY irs_id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irsaliye_fatura_getir($id, $kul_id)
    {

        $sql   = "SELECT fat_id FROM fat_irs_iliski Where irs_id=" . $id . " and kullanici_id=" . $kul_id . " GROUP BY fat_id";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irs_durum_getir($id, $fat_id, $kul_id)
    {

        $sql   = "SELECT * FROM fat_irs_iliski Where irs_id=" . $id . " and fat_id=" . $fat_id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return "Kapalı";
        } else {
            return "Açık";
        }

    }

    public function irs_detay_getir($irs_id, $kul_id)
    {

        $sql   = "SELECT * FROM irsaliye Where id=" . $irs_id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function fat_detay_getir($fat_id, $kul_id)
    {

        $sql   = "SELECT * FROM fatura Where id=" . $fat_id . " and kullanici_id=" . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function yetki_kontrol_fatura($id, $kul_id)
    {
        $query = $this->db->query("select * from fatura Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_siparis($id, $kul_id)
    {
        $query = $this->db->query("select * from siparis Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_teklif($id, $kul_id)
    {
        $query = $this->db->query("select * from teklif Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function yetki_kontrol_irsaliye($id, $kul_id)
    {
        $query = $this->db->query("select * from irsaliye Where id=" . $id . " and kullanici_id=" . $kul_id);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function fat_sil($f_id)
    {

        $this->db->where('id', $f_id);
        $this->db->delete('fatura');

        $this->db->where('fatura_id', $f_id);
        $this->db->delete('fatura_item');

        $this->db->where('relation_id', $f_id);
        $this->db->where('islem_turu', 4);
        $this->db->delete('islem');

        return true;

        $sql1 = "DELETE FROM fatura Where id=" . $f_id;
        $sql2 = "DELETE FROM fatura_item Where fatura_id=" . $f_id;
        $sql3 = "DELETE FROM islem Where islem_turu=4 and relation_id=" . $f_id;

        return true;

    }

    public function irs_sil($f_id)
    {

        $this->db->where('id', $f_id);
        $this->db->delete('irsaliye');

        $this->db->where('fatura_id', $f_id);
        $this->db->delete('irsaliye_item');

        return true;

        $sql1 = "DELETE FROM fatura Where id=" . $f_id;
        $sql2 = "DELETE FROM fatura_item Where fatura_id=" . $f_id;
        $sql3 = "DELETE FROM islem Where islem_turu=4 and relation_id=" . $f_id;

        return true;

    }

    public function fat_irs_iliski_kaydet($fat_id, $irs_id, $kul_id)
    {

        $insert = array(
            'fat_id'       => $fat_id,
            'irs_id'       => $irs_id,
            'kullanici_id' => $kul_id,

        );

        $into = $this->db->insert('fat_irs_iliski', $insert);
        if ($into) {
            return true;

        }
        return false;

    }

    public function irs_fat_durum($id, $kul_id)
    {
//   "select * from fat_irs_iliski Where irs_id=".$id." and kullanici_id=".."

        $query = $this->db->query("select * from fat_irs_iliski Where irs_id=" . $id . "  and kullanici_id=" . $kul_id . "");

        if ($query->num_rows() > 0) {
            return 0;
        } else {
            return 1;
        }

    }

    public function irs_item_bilgi($id, $kul_id)
    {

        $query = $this->db->query("select fat_id,irs_id from fat_irs_iliski Where irs_id=" . $id . " and kullanici_id=" . $kul_id);

        //    return $query->num_rows();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irs_urun_getir($id, $kul_id)
    {

        $query = $this->db->query("select hizmet_urun_id from irsaliye_item Where fatura_id=" . $id . " and kullanici_id=" . $kul_id . " GROUP BY hizmet_urun_id");

        //    return $query->num_rows();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function irs_urun_top($id, $ur_id, $kul_id)
    {

        //, $fat_id
        $this->db->select('hizmet_urun_id');
        $this->db->select_sum('adet');
        $this->db->from('irsaliye_item');
        $this->db->where('fatura_id', $id);
        $this->db->where('hizmet_urun_id', $ur_id);
        $this->db->where('kullanici_id', $kul_id);

        $query = $this->db->get();
        if (!$query->row()->adet) {return 0;}
        return $query->row()->adet;

    }

/*

function irs_item_urun_adet_getir($id,$kul_id)
{

$query =$this->db->query("select fatura_id,hizmet_urun_id,adet from irsaliye_item Where id=".$id." and kullanici_id=".$kul_id);

//    return $query->num_rows();

if( $query->num_rows() > 0 )
{
return $query->result_array();
}
else
{
return FALSE;
}

}

 */

    public function irs_item_top($irs_item_id)
    {

        //, $fat_id
        $this->db->select_sum('adet');
        $this->db->from('fat_irs_iliski');
        $this->db->where('irs_item_id', $irs_item_id);
        $query = $this->db->get();
        if (!$query->row()->adet) {return 0;}
        $irs_ils_top = $query->row()->adet;

        $this->db->select_sum('adet');
        $this->db->from('irsaliye_item');
        $this->db->where('id', $irs_item_id);
        $query = $this->db->get();
        if (!$query->row()->adet) {return 0;}
        $irs_top = $query->row()->adet;

        $sonuc = $irs_top - $irs_ils_top;

        if ($sonuc == $irs_top) {
            return "Açık";
        }
        if ($sonuc <= 0) {
            return "Kapalı";
        }

        if ($sonuc < $irs_top) {
            return "Kısmı";
        }

    }

    public function cek_fat_id_getir($id, $kul_id)
    {

        $query = $this->db->query("select * from cek_senet Where id=" . $id);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['fat_id'];

            }

        } else {
            return false;
        }

    }

    public function etkinlik_kayit($title, $start, $end, $allDay, $k_id, $id)
    {

        if ($allDay == "true") {$day = 1;}
        if ($allDay == "false") {$day = 0;}

        $insert = array(
            'title'        => $title,
            'start'        => $start,
            'end'          => $end,
            'allday'       => $day,
            'kim'          => $id,
            'kullanici_id' => $k_id,
        );

        $into = $this->db->insert('etkinlik', $insert);

        if ($into != 1) {return 0;} else {return 1;}

    }

    public function etkinlik_sil($et_id, $k_id, $id)
    {

        $this->db->where('kim', $id);
        $this->db->where('kullanici_id', $k_id);
        $this->db->where('id', $et_id);
        return $into = $this->db->delete('etkinlik');

        if ($into) {return 1;} else {return 0;}

    }

    public function et_getir($id, $kid)
    {

        $query = $this->db->query("select id,title,start,end from etkinlik Where kim=" . $id . " and kullanici_id=" . $kid);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function sip_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $kul_id)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}

        $insert = array(
            'fatura_turu'     => $fat_turu,
            'tutar'           => $ara_toplam,
            'vergi'           => $vergi,
            'indirim'         => $indirim,
            'toplam'          => $toplam,
            'kullanici_id'    => $kul_id,
            'cari_id'         => $mus,
            'tarih'           => $duz_ta,
            'vade_tarihi'     => $va_ta,
            'seri_no'         => $seri,
            'fatura_no'       => $no,
            'aciklama'        => $ack,
            'irsaliye_durum'  => $irs_durum,
            'gelir_gider_fat' => $gel_gid,
        );

        $this->db->insert('siparis', $insert);
        return $this->db->insert_id();

    }

    public function sip_item_kayit($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,

        );

        $this->db->insert('siparis_item', $insert);
        return $this->db->insert_id();

    }

    public function sip_item_kayit2($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,

        );

        $this->db->insert('siparis_item', $insert);
        return $this->db->insert_id();

    }

    public function tek_item_kayit2($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,

        );

        $this->db->insert('teklif_item', $insert);
        return $this->db->insert_id();

    }

    public function sip_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $kul_id)
    {

        $insert = array(
            'fatura_turu'    => $fat_turu,
            'tutar'          => $ara_toplam,
            'vergi'          => $vergi,
            'indirim'        => $indirim,
            'toplam'         => $toplam,
            'kullanici_id'   => $kul_id,
            'cari_id'        => $mus,
            'tarih'          => $duz_ta,
            'vade_tarihi'    => $va_ta,
            'seri_no'        => $seri,
            'fatura_no'      => $no,
            'aciklama'       => $ack,
            'irsaliye_durum' => $irs_durum,

        );

        $this->db->where('id', $fat_id);
        $this->db->update('siparis', $insert);
        //return $this->db->insert_id();

        $this->db->where('fatura_id', $fat_id);
        $this->db->delete('siparis_item');

        return true;

    }

    public function tek_guncelle($fat_id, $fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum, $kul_id)
    {

        $insert = array(
            'fatura_turu'    => $fat_turu,
            'tutar'          => $ara_toplam,
            'vergi'          => $vergi,
            'indirim'        => $indirim,
            'toplam'         => $toplam,
            'kullanici_id'   => $kul_id,
            'cari_id'        => $mus,
            'tarih'          => $duz_ta,
            'vade_tarihi'    => $va_ta,
            'seri_no'        => $seri,
            'fatura_no'      => $no,
            'aciklama'       => $ack,
            'irsaliye_durum' => $irs_durum,

        );

        $this->db->where('id', $fat_id);
        $this->db->update('teklif', $insert);
        //return $this->db->insert_id();

        $this->db->where('fatura_id', $fat_id);
        $this->db->delete('teklif_item');

        return true;

    }

    public function tek_kayit($fat_turu, $ara_toplam, $indirim, $vergi, $toplam, $mus, $seri, $no, $duz_ta, $va_ta, $ack, $irs_durum,  $kul_id)
    {

        if ($fat_turu == "Gider") {$gel_gid = "1";} else { $gel_gid = "0";}

        $insert = array(
            'fatura_turu'     => $fat_turu,
            'tutar'           => $ara_toplam,
            'vergi'           => $vergi,
            'indirim'         => $indirim,
            'toplam'          => $toplam,
            'kullanici_id'    => $kul_id,
            'cari_id'         => $mus,
            'tarih'           => $duz_ta,
            'vade_tarihi'     => $va_ta,
            'seri_no'         => $seri,
            'fatura_no'       => $no,
            'aciklama'        => $ack,
            'irsaliye_durum'  => $irs_durum,
            'gelir_gider_fat' => $gel_gid,
        );

        $this->db->insert('teklif', $insert);
        return $this->db->insert_id();

    }

    public function tek_item_kayit($fat_id, $item, $qty, $prc, $total, $des, $discount, $tax, $fat_turu, $kul_id)
    {

        $insert = array(
            'fatura_id'      => $fat_id,
            'fatura_turu'    => $fat_turu,
            'hizmet_urun_id' => $item,
            'adet'           => $qty,
            'birim_fiyat'    => $prc,
            'tutar'          => $total,
            'aciklama'       => $des,
            'indirim'        => $discount,
            'vergi'          => $tax,
            'kullanici_id'   => $kul_id,

        );

        $this->db->insert('teklif_item', $insert);
        return $this->db->insert_id();

    }

    public function tek_item_gunc($id, $aktar, $kl)
    {

        $query = $this->db->query("select * from teklif_item Where id=" . $id . " and kullanici_id=" . $kl);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $aktarim = $row['aktarim'];
                $adet    = $row['adet'];
            }

        }

        $guncelle = $aktarim + $aktar;

        if ($guncelle >= $adet) {

            $son = $adet;

        } else {

            $son = $guncelle;

        }

        $insert = array(
            'aktarim' => $son,

        );

        $this->db->where('kullanici_id', $kl);
        $this->db->where('id', $id);
        $this->db->update('teklif_item', $insert);

    }

    public function sip_item_gunc($id, $aktar, $kl)
    {

        $query = $this->db->query("select * from siparis_item Where id=" . $id . " and kullanici_id=" . $kl);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $aktarim = $row['aktarim'];
                $adet    = $row['adet'];
            }

        }

        $guncelle = $aktarim + $aktar;

        if ($guncelle >= $adet) {

            $son = $adet;

        } else {

            $son = $guncelle;

        }

        $insert = array(
            'aktarim' => $son,

        );

        $this->db->where('kullanici_id', $kl);
        $this->db->where('id', $id);
        $this->db->update('siparis_item', $insert);

    }

    public function irs_item_gunc($id, $aktar, $kl)
    {

        $query = $this->db->query("select * from irsaliye_item Where id=" . $id . " and kullanici_id=" . $kl);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $aktarim = $row['aktarim'];
                $adet    = $row['adet'];
            }

        }

        $guncelle = $aktarim + $aktar;

        if ($guncelle >= $adet) {

            $son = $adet;

        } else {

            $son = $guncelle;

        }

        $insert = array(
            'aktarim' => $son,

        );

        $this->db->where('kullanici_id', $kl);
        $this->db->where('id', $id);
        $this->db->update('irsaliye_item', $insert);

    }

    public function mesaj_kaydet($uye, $ice, $id, $kul_id)
    {

        $insert = array(

            'gonderici'    => $id,
            'alici'        => $uye,
            'mesaj'        => $ice,
            'kullanici_id' => $kul_id,
            'durum'        => 0,

        );

        $into = $this->db->insert('mesaj', $insert);
        if ($into) {
            return true;

        }
        return false;

    }

    public function tum_mesaj_getir($kul_id, $id)
    {
        $sql   = "SELECT id,gonderici,alici,tarih FROM mesaj Where gonderici=" . $id . " or alici=" . $id . " ORDER BY id desc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return $query->result_array();
        }

    }
	

	


    public function uye_mesaj_getir($kul_id, $id, $uye)
    {

        $msjlar_1[] = "";
        $msjlar_2[] = "";

        $sql   = "SELECT * FROM mesaj Where gonderici=" . $id . " and alici=" . $uye . " and kullanici_id=" . $kul_id . "  ORDER BY id desc";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $msjlar_1 = $query->result_array();
        }

        $sql2   = "SELECT * FROM mesaj Where gonderici=" . $uye . " and alici=" . $id . " and kullanici_id=" . $kul_id . "  ORDER BY id desc";
        $query2 = $this->db->query($sql2);

        if ($query2->num_rows() > 0) {
            $msjlar_2 = $query2->result_array();
        }

        $insert = array(
            'durum' => 1,
        );

        $this->db->where('alici', $id);
        $into2 = $this->db->update('mesaj', $insert);

        return array_merge($msjlar_1, $msjlar_2);

    }

    public function okunmamis_getir($kul_id, $id, $name)
    {
        $sql   = "SELECT * FROM mesaj Where kullanici_id=" . $kul_id . "  and alici=" . $id . " and gonderici=" . $name . " and durum=0";
        $query = $this->db->query($sql);
        return $query->num_rows();

    }

    public function okunmamis_toplam_getir($kul_id, $id)
    {
        $sql   = "SELECT * FROM mesaj Where kullanici_id=" . $kul_id . "  and alici=" . $id . " and durum=0";
        $query = $this->db->query($sql);
        return $query->num_rows();

    }

    public function ticari_mail_kontrol($id, $em1, $em2)
    {
        $email = $em1 . "@" . $em2;
        $sql   = "SELECT * FROM uyeler Where id=" . $id . "  and email='" . $email . "' and status=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function drive_mail_kontrol($id, $em1, $em2)
    {
        $email = $em1 . "@" . $em2;
        $sql   = "SELECT * FROM users Where username='" . $em1 . "' and email='" . $email . "'";
        $query = $this->db2->query($sql);

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function drive_kayit($id, $em1, $em2)
    {

        $email = $em1 . "@" . $em2;

        $insert = array(
            'username'        => $em1,
            'email'           => $email,
            'password'        => '$2y$10$xsMUi7OA7qNTsMHQTKo8luVMCunwfco1K7JrlWU6Gy.BjcFBsBE36',
            'remember_token'  => rand(1000000, 9999999),
            'confirmed'       => 1,
            'language'        => "english",
            'avatar'          => "https://www.gravatar.com/avatar/16884c1050f5ba448d894eda0bccf5e6?s=65",
            'available_space' => "1073741824",
            'permissions'     => "[]",

        );

        $into = $this->db2->insert('users', $insert);

        $insertId = $this->db2->insert_id();
        $insert2  = array(
            'user_id' => $insertId,
            'role_id' => 2,
        );
        $into2 = $this->db2->insert('user_role', $insert2);

    }

    public function tartisma_msj_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM tartisma_msj Where kullanici_id=" . $kul_id . " and tartisma_id=" . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function tartisma_bilgi_getir($kul_id, $id)
    {

        $sql   = "SELECT * FROM tartisma Where kullanici_id=" . $kul_id . " and id=" . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function tartisma_kaydet($tartisma, $ice, $id, $kul_id)
    {

        $insert = array(

            'tartisma_id'  => $tartisma,
            'kim'          => $id,
            'mesaj'        => $ice,
            'kullanici_id' => $kul_id,
        );

        $into = $this->db->insert('tartisma_msj', $insert);
        if ($into) {
            return 1;

        }
        return 0;

    }

    public function akis_teklifler($kul_id)
    {

        $sql   = "SELECT id,fatura_turu,vade_tarihi FROM teklif Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function akis_siparisler($kul_id)
    {

        $sql   = "SELECT id,fatura_turu,vade_tarihi FROM siparis Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function akis_faturalar($kul_id)
    {

        $sql   = "SELECT id,fatura_turu,vade_tarihi FROM fatura Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function akis_irsaliyeler($kul_id)
    {

        $sql   = "SELECT id,fatura_turu,vade_tarihi FROM irsaliye Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function akis_boal($kul_id)
    {

        $sql   = "SELECT id,fatura_turu,vade_tarihi FROM borc_alacak Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function akis_cek($kul_id)
    {

        $sql   = "SELECT id,tur,vade_tarihi FROM cek_senet Where kullanici_id = " . $kul_id . " and durum=0 ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function etk_cek($kul_id)
    {

        $sql   = "SELECT id,start FROM etkinlik Where kullanici_id = " . $kul_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }



    public function efat_durum($id)
    {

        $query = $this->db->query("select * from fatura Where id=" . $id);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['efatura_durum'];

            }

        } else {
            return false;
        }

    }



    public function efat_getir($id)
    {

        $sql   = "SELECT * FROM fatura Where id = " . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }


    public function cari_getir($id)
    {

        $sql   = "SELECT * FROM cari Where id = " . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }



    public function fat_items($fat_id)
    {

        $sql   = "SELECT * FROM fatura_item Where fatura_id = " . $fat_id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }





    public function fat_items_product($id)
    {

        $sql   = "SELECT * FROM hizmet_urun Where id = " . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['adi'];

            }

        } else {
            return false;
        }
    }

    public function fat_items_product_birim($id)
    {

        $sql   = "SELECT * FROM hizmet_urun Where id = " . $id;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                return $row['birim'];

            }

        } else {
            return false;
        }
    }

    public function efatura_db_guncelle($fat_id,$kayitno)
    {

        $insert = array(
            'efatura_durum'  => 1,
            'efatura_kayit_no'  =>$kayitno
        );

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('id', $fat_id);
        $this->db->update('fatura', $insert);

        return true;
    }

    public function efatura_db_guncelle_2($fat_id,$kayitno)
    {

        $insert = array(
            'efatura_durum'  => 0,
            'efatura_kayit_no'  =>""
        );

        $this->db->where('kullanici_id', $this->session->userdata('kullanici_id'));
        $this->db->where('id', $fat_id);
         $this->db->where('efatura_kayit_no', $kayitno);       
        $this->db->update('fatura', $insert);

        return true;
    }


    public function fat_kontrol($seri,$no)
    {

        $query = $this->db->query("select * from fatura Where seri_no='".$seri."' and fatura_no='".$no."'");
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            return 1;
        }

    }


    public function irs_kontrol($no)
    {

        $query = $this->db->query("select * from irsaliye Where irsaliye_no='".$no);
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            return 1;
        }

    }



   public function kayit_kontrol($db,$seri,$no)
    {

        $query = $this->db->query("select * from ".$db." Where seri_no='".$seri."' and fatura_no='".$no."'");
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            return 1;
        }

    }



   public function fat_silme_kontrol($pr,$k_id)
    {

             

        $query = $this->db->query("select * from fatura Where id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
              foreach ($query->result_array() as $row) {
        
     if ($row['efatura_durum']== 1) {
            return 0;
        } 

            }
        } 



        $query = $this->db->query("select * from islem Where islem_turu = 3 and relation_id=".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 

       $query = $this->db->query("select * from fat_irs_iliski Where fat_id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 

        $query = $this->db->query("select * from cek_senet Where fat_id=".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 


return 1;


    }



   public function urun_silme_kontrol($pr,$k_id)
    {

        $query = $this->db->query("select * from fatura_item Where hizmet_urun_id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 

        $query = $this->db->query("select * from irsaliye_item Where hizmet_urun_id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 

        $query = $this->db->query("select * from siparis_item Where hizmet_urun_id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 


        $query = $this->db->query("select * from teklif_item Where hizmet_urun_id = ".$pr." and kullanici_id=".$k_id);
        if ($query->num_rows() > 0) {
            return 0;
        } 




return 1;


    }







    public function musteri_eposta($fat_id)
    {

        $query = $this->db->query("select * from fatura Where id=".$fat_id);
            foreach ($query->result_array() as $row) {
                $cari_id=$row['cari_id'];
            }


        $query = $this->db->query("select * from cari Where id=".$cari_id);
            foreach ($query->result_array() as $row) {
                return $row['eposta'];
            }



    }



    public function uye_sayisi_kontrol($kid,$id)
    {

        $query = $this->db->query("select * from uyeler Where id=".$id." and kullanici_id=".$id);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $uye_sayisi=$row['uye_sayisi'];

            }

        } 


 $query = $this->db->query("select * from uyeler Where kullanici_id=".$id);
        $adet=$query->num_rows();

        if($adet<$uye_sayisi){
        return 1;
        }
        return 0;


    }




      public function uye_vkn_getir($kid)
    {

        $query = $this->db->query("select * from bina Where kullanici_id=".$kid);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
               return $row['vergi_no'];

            }

        } 




    }




      public function uye_bilgi_getir($kid)
    {

        $query = $this->db->query("select * from bina Where kullanici_id=".$kid);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
               $data["vn"]=$row['vergi_no'];
               $data["vd"]=$row['vergi_dairesi'];
                $data["resmi"]=$row['resmi_adi'];

            }

        } 

        $query = $this->db->query("select * from uyeler Where id=".$kid." and kullanici_id=".$kid);
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
               $data["ad"]=$row['adres'];
               $data["ilce"]=$row['ilce'];
                $data["il"]=$row['il'];

            }

        } 

return $data;


    }









}
