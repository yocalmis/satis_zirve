<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapor_model extends CI_Model
{
	 function __construct()
     {
         parent::__construct();
         $this->load->database();
     }
	 
	 //Admin Varm� Yokmu Kontrol Et , Varsa Login'e Yoksa Kay�t sayfas�na y�nlendir
	 
	 
     
      function cari_getir()
     {
   
        $sql = "SELECT adi_soyadi,bas_boal_durum   FROM cari";
        $query = $this->db->query($sql);
        
        if( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
   
   
   
     }









}
?>