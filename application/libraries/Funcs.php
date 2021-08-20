<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funcs {

public function index($curr,$lng)
	{

  
	if($curr==""){
		
	$CI =& get_instance();
    $CI->load->library('session');
	$CI->session->set_userdata('currency',1);
	$CI->session->set_userdata('currency_icon',"€");
	$CI->session->set_userdata('currency_birim',"Euro");

		
	}
	
	
	if($lng==""){
		
				$CI =& get_instance();
				$CI->load->library('session');
				$CI->load->library("Language/Eng");
				$data["lang"]=$CI->eng->index(); 
				$CI->session->set_userdata('lng',$data["lang"]);	
				$CI->session->set_userdata('lng_turu',"Eng");						
	}
	
	
	
		
		
	}
	
	
	




function GetIP(){
 if(getenv("HTTP_CLIENT_IP")) {
 $ip = getenv("HTTP_CLIENT_IP");
 } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 $ip = getenv("HTTP_X_FORWARDED_FOR");
 if (strstr($ip, ',')) {
 $tmp = explode (',', $ip);
 $ip = trim($tmp[0]);
 }
 } else {
 $ip = getenv("REMOTE_ADDR");
 }
 return $ip;
}







function efat_sorgu($vn){

	//	session_start();
		$ch = curl_init('https://sorgu.efatura.gov.tr/earsivkullanicilar/yliste.php?ara='.$vn.'&as_sfid=AAAAAAU7Zocn0YiviqfTchzLoKOuUKyOiZJk_RC77daWl8hdhC_tGUkvQEHzvrmZGfz-dbIbBvGoagjnoIiWSPGKDputRdRXnC-r_VegQjrdCqX7pkS4EtSXE6TxRFKg0rz3esY%3D&as_fid=f2c535eb4a5d854be29716d90c3f0283d971579e'); 		
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_HEADER, FALSE); 		
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 			
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
		curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");		
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);	
		$result = curl_exec($ch);
		if(strstr($result, "UNVAN")) { return "1"; }
		return 0;

}









	
	
}