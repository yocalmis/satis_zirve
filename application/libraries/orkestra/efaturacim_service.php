<?php
/**
 * ORKESTRA EFATURACIM PHP API
 * @author Volkan  GUNAYDIN
 * 
 * GUNCEL KUTUPHANE : https://efaturacim.orkestra.com.tr/servis.php?action=download
 * DEMO SCRIPT : https://efaturacim.orkestra.com.tr/servis.php?action=demo
 * 
 */
class EFATURACIM_ISTEMCI{
	public $_musteri  = "";
	public $_kullanici = "";
	public $_sifre        = "";
	public $_baseUrl = "https://efaturacim.orkestra.com.tr/servis.php";
	public $__sessionKey = "";
	public $__secretKey = "";
	public $__apiKey     = "";
	public $_ea_params = array();
	public $_lastErrorMsg = "";
	public $_lastMsg = "";
	public $_version = "1.4";
	public $_lastUpdateTime = "2019-05-19 22:14:00";
	public $_debug = false;
	public $_extra_vars = array();
	public function __construct($musteriKodu,$kullaniciAdi="",$sifre="",$url=null,$apiKey=null,$createApikeyOnNull=false){
	    $this->initMe($musteriKodu,$kullaniciAdi,$sifre,$url,$apiKey,$createApikeyOnNull);
	}
	
	public function gelenFaturalar($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi="",$ekSecenekler=null){
	    return $this->faturaSorgula($baslangic,$bitis,"gelen",$vkn,$belgeNo,$tarih,$tutar,$musteriVkn,$musteriAdi,"","",$ekSecenekler);
	}
	public function gidenFaturaListesi($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi=""){
		$r = $this->gonderilenFaturalar($baslangic,$bitis,$vkn,$belgeNo,$tarih,$tutar,$musteriVkn,$musteriAdi);
		if($r["isok"]){
			$efaturaList = @$r["data"]["efatura"];
			if(count($efaturaList)>0){ return $efaturaList; }
		}
		return array();
	}
	public function gelenFaturaListesi($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi=""){
		$r = $this->gelenFaturalar($baslangic,$bitis,$vkn,$belgeNo,$tarih,$tutar,$musteriVkn,$musteriAdi);
		if($r["isok"]){
			$efaturaList = @$r["data"]["efatura"];
			if(count($efaturaList)>0){ return $efaturaList; }
		}
		return array();
	}
	public function sonAlinanFaturalar($gunSayisi=7){
		return $this->faturaSorgula(date("Y-m-d H:i:s",time()-(86400*abs($gunSayisi))  ),date("Y-m-d H:i:s"),"gonderilen","","","","","","","","gelis");
	}
	public function sonGonderilenFaturalar($gunSayisi=7){
		return $this->faturaSorgula(date("Y-m-d H:i:s",time()-(86400*abs($gunSayisi))  ),date("Y-m-d H:i:s"),"gonderilen","","","","","","","","gelis");
	}
	public function gonderilenFaturalar($baslangic=null,$bitis=null,$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi="",$ekSecenekler=null){
		return $this->faturaSorgula($baslangic,$bitis,"gonderilen",$vkn,$belgeNo,$tarih,$tutar,$musteriVkn,$musteriAdi,"","",$ekSecenekler);
	}
	public function faturalariOkunduOlarakIsaretle($belgeNolar){
	    return $this->faturalariIsaretle($belgeNolar,"islendi");
	}
	public function faturalariOkunmamisOlarakIsaretle($belgeNolar){
	    return $this->faturalariIsaretle($belgeNolar,"islenmedi");
	}
	public function faturalariIsaretle($belgeNolar="",$isaret=""){
	    if(trim($belgeNolar)==""){ $belgeNolar = "--"; }
	    return $this->faturaSorgula(null,null,"hepsi","",$belgeNolar,"","","","","","",array("isaretle"=>$isaret,"skip_html"=>"true"));
	}
	public function iptalEdilenEarsivFaturalar($baslangic=null,$bitis=null){
	    return $this->faturaSorgula($baslangic,$bitis,"earsiv","","","","","","","","",array("iptal_durumu"=>"evet","skip_html"=>"true"));
	}
	public function gonderilenEarsivFaturalar($baslangic=null,$bitis=null,$belgeNolar=""){
	    return $this->faturaSorgula($baslangic,$bitis,"earsiv","",$belgeNolar,"","","","","","",array("iptal_durumu"=>"hayir","skip_html"=>"true"));
	}	
	public function okunmamisFaturaListesi($tip="",$baslangic=null,$bitis=null){
	    return $this->faturaSorgula($baslangic,$bitis,$tip,"","","","","","","","",array("okunma_durumu"=>"okunmammis"));
	}	
	public function faturaAl($kayitNoVeyaBelgeNo,$tip="efatura"){
		$tmp = preg_replace("/[^0-9]/", "",$kayitNoVeyaBelgeNo);
		if(strlen($tmp)==16){
		    return $this->faturaSorgula(null,null,$tip,"",$kayitNoVeyaBelgeNo,"","","","","");
		}else if(strlen($kayitNoVeyaBelgeNo)>strlen($tmp)){
			return $this->faturaSorgula(null,null,$tip,"",$kayitNoVeyaBelgeNo,"","","","","");
		}else{
			return $this->faturaSorgula(null,null,$tip,"","","","","","",$kayitNoVeyaBelgeNo);
		}		
	}	
	public function faturayiPdfAl($kayitNo,$tip="efatura"){
		return $this->__std_call("pdf", array("kayitno"=>$kayitNo,"tip"=>$tip));
	}
	public function faturaSorgula($baslangic=null,$bitis=null,$tip="hepsi",$vkn="",$belgeNo="",$tarih="",$tutar="",$musteriVkn="",$musteriAdi="",$kayitNo="",$zamanTipi="",$ekSecenekler=null,$ekSecenekler2=null){
		if(is_array($baslangic)){
			$arr          = $baslangic;
			$baslangic    = @$arr["baslangic"];
			$bitis        = @$arr["bitis"];
			$tip          = @$arr["tip"];
			$vkn          = @$arr["vkn"];
			$belgeNo      = @$arr["belgeno"];
			$tarih        = @$arr["tarih"];
			$tutar        = @$arr["tutar"];
			$musteriVkn   = @$arr["musteriVkn"];
			$musteriAdi   = @$arr["musteriAdi"];
			$zamanTipi    = @$arr["zamantipi"];
		}		
		$p = array("baslangic"=>$baslangic,"bitis"=>$bitis,"tip"=>$tip,"vkn"=>$vkn,"belgeno"=>$belgeNo,"tarih"=>$tarih,"tutar"=>$tutar,"musteri_vkn"=>$musteriVkn,"musteri_adi"=>$musteriAdi,"kayitno"=>$kayitNo,"zamantipi"=>$zamanTipi);
		if(!is_null($ekSecenekler) && is_array($ekSecenekler)){ foreach ($ekSecenekler as $kk=>$vv){ $p[$kk] = $vv; } }
		if(!is_null($ekSecenekler2) && is_array($ekSecenekler2)){ foreach ($ekSecenekler2 as $kk=>$vv){ $p[$kk] = $vv; } }
		return $this->__std_call("faturaara", $p);
	}
	public function createCsvFromArray($data){
		$csv2 = "";
		$csv   = "";
		$index = 0;
		foreach ($data as $k=>$v){
			$index++;
			$csv .= ($index>1?";":"").'"'.$k.'"';
			$csv2 .= ($index>1?";":"").'"'.$v.'"';
		}
		$csv .= "\r\n".$csv2;
		return $csv;
	}
	public function faturaYukleCsvData($csvString,$previewOnly=false,$emailList=null,$sendImzaliPdf=false){
		return $this->__std_call("csv", array("csv"=>$csvString,"preview"=>$previewOnly));
	}
	public function bildirimGonder($faturaNo,$epostaListesi="",$cepTelefonListesi,$tip="auto"){
	    return $this->__std_call("bildirim", array("faturano"=>$faturaNo,"eposta"=>$epostaListesi,"cepler"=>$cepTelefonListesi,"tip"=>$tip));
	}
	public function faturaYukleArrayData($faturaData,$previewOnly=false,$emailList=null,$sendImzaliPdf=false,$smsList=null){
		if(is_array($faturaData)){
			$csv = "";
			$l1 = "";
			$l2 = "";
			$i = 0;
			foreach ($faturaData as $k=>$v){
			    $v = str_replace(array("\r","\n","\t"), array("","",""), $v);
				$i++;
				$l1 .= ($i>1?";":"").'"'.str_replace('\"', "", $k).'"';
				$l2 .= ($i>1?";":"").'"'.str_replace('\"', "", $v).'"';
			}
			$csv = $l1."\r\n".$l2;
			//GAPP::dumpVar($csv);
			$res = $this->__std_call("csv", array("csv"=>$csv,"preview"=>$previewOnly,"email"=>$emailList,"imzali"=>$sendImzaliPdf,"smslist"=>$smsList));
			if(key_exists("SHOW_AS", $faturaData) && @$faturaData["SHOW_AS"]==="HTML" && $previewOnly==true){			   
			    echo @$res["data"]["html"];die("");
			}else if(key_exists("SHOW_AS", $faturaData) && @$faturaData["SHOW_AS"]==="XML" && $previewOnly==true){
			    echo '<pre>'.htmlentities(@$res["data"]["xml"]).'</pre>';die("");
			}
			return $res;
		}else{
			$r = $this->__stdResult();
			$r["msg"] = "Lütfen fatura içeriğini belirtiniz.";
			return $r;			
		}
	}
	public function  faturaYukleXmlString($xmlAsString="",$postaKutusu=null,$earsivParmetreleri=null,$previewOnly=false,$emailList=null,$sendImzaliPdf=false){
		$this->set_earsiv_parametreleri($earsivParmetreleri);
		if(strlen($xmlAsString)>0){
			$params = array("pk"=>$postaKutusu,"xml"=>$xmlAsString,"preview"=>$previewOnly,"email"=>$emailList,"imzali"=>$sendImzaliPdf);
			$this->__addEarsivOptions($params);
			return $this->__std_call("fatura_yukle", $params,null);				
		}else{
			$r = $this->__stdResult();
			$r["msg"] = "Lütfen XML içeriğini belirtiniz.";
			return $r;			
		}
	}
	public function  faturaYukleDosyadan($dosyaYolu,$postaKutusu=null,$earsivParmetreleri=null,$previewOnly=false,$emailList=null,$sendImzaliPdf=false){
		$this->set_earsiv_parametreleri($earsivParmetreleri);
		if(file_exists($dosyaYolu)){
			$params = array("pk"=>$postaKutusu,"xml"=>file_get_contents($dosyaYolu),"preview"=>$previewOnly,"email"=>$emailList,"imzali"=>$sendImzaliPdf);
			$this->__addEarsivOptions($params);
			$r = $this->__std_call("fatura_yukle", $params,null);
			return $r;
		}else{
			$r = $this->__stdResult();
			$r["msg"] = "Dosya bulunamadı.";
			return $r;
		}
	}
	public function __addEarsivOptions(&$arr){
		$keys = array("earsiv_odeme_metodu","earsiv_odeme_aciklama","earsiv_odeme_zamani","earsiv_satis","earsiv_eposta","earsiv_webshop","earsiv_kargo_adi","earsiv_kargo_vkn");
		foreach ($keys as $v){
			if(key_exists($v, $this->_ea_params)){
				$arr[$v] = @$this->_ea_params[$v];
			}
		}
	}
	public function set_earsiv_parametreleri($earsivParmetreleri=null){
		if(is_array($earsivParmetreleri)){
			foreach ($earsivParmetreleri as $k=>$v){
				$this->_ea_params[$k] = $v;
			}
		}
	}
	public function __destruct(){
		$this->logout();
	}
	public function __std_call($action,$paramsData,$valueField=null,$debugThis=false,$realLoginReq=true){
	    $r = $this->__stdResultWithLoginCheck($realLoginReq);
		if(strlen($r["error"])>0){ return $r; }
		$this->log("__std_call POST => ".$action);
		//var_dump($paramsData);die("=>".$this->__sessionKey);
		//GAPP::dumpVar($paramsData);
		$s = $this->__post($action,$paramsData,$debugThis);		
		//var_dump(array("s"=>$s));die("");
		$this->log("__std_call returned => ".@$s["isok"]);
		if($s["isok"]){
			$r["isok"] = true;
			$r["msg"]   = @$s["msg"];
			$r["data"]   = $s["data"];
			if(!is_null($valueField) && is_string($valueField)){
				$r["value"] = @$s["data"][$valueField];
			}
		}else{
			$r["msg"] = @$s["msg"];
		}
		if(isset($s["mylog"]) && strlen(@$s["mylog"])>0){
			$r["mylog"] = @$s["mylog"];
		}		
		return $r;
	}

	public function setApiKey($apiKey){
		$this->__apiKey = $apiKey;
	}
	public function __stdResultWithLoginCheck($realLoginReq=true){
		$arr = array("isok"=>false,"value"=>"","msg"=>"","error"=>"","data"=>array());
		if($realLoginReq===false){
		    $this->__sessionKey = "12345678901";
		    $arr = array("isok"=>true,"value"=>$this->__sessionKey,"msg"=>"","error"=>"","data"=>array());
		    return $arr;
		}
		if(strlen($this->__sessionKey)>10){
		    $arr = array("isok"=>true,"value"=>$this->__sessionKey,"msg"=>"","error"=>"","data"=>array());
		    return $arr;
		}
		if(strlen($this->__sessionKey)<3){ $this->login(); }
		if(strlen($this->__sessionKey)<3){
			if(strlen($this->_lastErrorMsg)>0){
				$arr["error"] = $this->_lastErrorMsg;
			}else{
				$arr["error"] = "Kullanıcı adı ve şifre ile giriş yapılamadı.";
			}			
			$arr["msg"] = $arr["error"];
		}
		return $arr;
	}	
	public function __stdResult(){
		$arr = array("isok"=>false,"value"=>"","msg"=>"","error"=>"","data"=>array());
		return $arr;
	}
	public function login($try=0){	
		if($this->_musteri=="" || $this->_kullanici  =="" || $this->_sifre==""){ return false;  }	
		$r = $this->__post("login", array("musteri"=>$this->_musteri,"kullanici"=>$this->_kullanici,"sifre"=>$this->_sifre));
		$this->log("LOGIN ATTEMPT FOR ".$this->_musteri."|".$this->_kullanici." @ ".$this->_baseUrl);
		if($r["isok"] && strlen(@$r["data"]["session"])>0){			
			$this->__sessionKey  = @$r["data"]["session"];
			$this->__secretKey    = @$r["data"]["secret"];
			$this->log("LOGIN OK => ".$this->__sessionKey);
			$this->_lastMsg = "Giriş başarılı.";
			return true;
		}else{
			if($try==0){ return $this->login($try+1); }
			$this->_lastErrorMsg =$this->_lastMsg = @$r["msg"];
			$this->log("LOGIN FAILED !");
			$this->log($this->_lastErrorMsg);
		}
		return false;
	}
	public function logout(){
		if(strlen($this->__sessionKey)>3){
			$r = $this->__post("logout", array());
			$this->__sessionKey = "";
		}else{ }
	}
	public function __post($action="none",$data=null,$debugThis=false){
		$res = array("isok"=>false,"data"=>array(),"response"=>null);
		$nl = "\r\n";
		$postVars = array();
		$postVars["action"]        = $action;
		$postVars["sessionkey"] = $this->__sessionKey;
		$postVars["secret"]         = $this->__secretKey;
		$postVars["apikey"]         = $this->__apiKey;
		if(is_array($this->_ea_params)){
			foreach ($this->_ea_params as $kk=>$vv){
				$postVars[$kk] = $vv;
			}
		}
		if(!is_null($data) && is_array($data)){
			foreach ($data as $kk=>$vv){			
				$postVars[$kk] = $vv; 
			}
		}		
		if(is_array($this->_extra_vars)){
			foreach ($this->_extra_vars as $kk=>$vv){
				$postVars[$kk] = $vv;
			}
		}
		$this->log("POST TO : ".$this->_baseUrl."?action=".$action);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->_baseUrl."?action=".$action);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postVars);			
		curl_setopt($ch, CURLOPT_USERAGENT, "EFATURACIM CLIENT");
		$this->log("POST VARS : ".print_r($postVars,true));
		//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		//var_dump($postVars);
		$result=curl_exec ($ch);
		$res["response"] = $result;		
		$this->log("RESPONSE : ".print_r($result,true));
		curl_close ($ch);				
		if($this->_debug && $this->checkLogEnabled()){
			$this->log( print_r("<pre>".htmlentities($result)."</pre>",true) );
		}
		if($debugThis){
			die($result);
			die("");
		}
		if(strpos($result, "<"."?"."xml")!==false){		    
			try {
				$xmlResponse = new SimpleXMLElement($result);
				if($xmlResponse->isok){
					$isok = @$xmlResponse->isok."";
					if($isok=="true"){ $res["isok"] = true; }
					$res["msg"] = @$xmlResponse->msg."";
					$dataStr = @$xmlResponse->mydata."";
					$logStr  = @$xmlResponse->mylog."";
					if(strlen($logStr)>0){
						$res["mylog"] = $logStr;
					}					
					if(strlen($dataStr)>0){
						try {
							$mydata = @unserialize(base64_decode($dataStr));
							if(is_array($mydata) && count($mydata)>0){
								foreach ($mydata as $kk=>$vv){ $res["data"][$kk] =  $vv; }
							}
						} catch (Exception $e) {
						}
					}
				}
			} catch (Exception $e) { 
			    //die('<textarea style="width:100%;height:500px;" >'.htmlentities($result).'</textarea>');
			}				
		}		
		return $res;
	}
	public function sonucuGoster($var){
		header('Content-Type: text/html; charset=utf-8');
		echo "<html>";
		echo "<body>";
		echo "<textarea style=\"min-width:600px;width:100%;min-height:900px;height100%;\">";
		print_r($var);
		echo "</textarea>";
		echo "</body>";
		echo "</html>";
		die("");
	}
	public function updateLibraryFile($targetPath=null){
		if(is_null($targetPath) || $targetPath==""){ $targetPath = __FILE__; }
		$res = array("isok"=>false,"target_file"=>$targetPath,"msg"=>"","phpstr"=>$php);
		if(strlen($targetPath)>0){
			if (file_exists($targetPath) && !is_writable($targetPath)){
				$res["msg"] = "Hedef dosya yazılabilir değil. Lütfen gerekli dosya izinlerini sağlayınız.";
			}else{
				$s=  $this->__post("download");
				if(strlen(@$s["response"])>100 && substr(@$s["response"], 0,5)===("<"."?"."php")){
					$res["phpstr"] = $s["response"];
					$res["isok"] = true;
					$res["msg"] = "Dosya içeriği alındı.";
					if($targetPath!="none" && substr($targetPath,-1*strlen("efaturacim_service.php"))=="efaturacim_service.php"){
						$fp = @fopen($targetPath, "w+");
						if($fp){
							$res["msg"] = "Dosya içeriği yazıldı.";
							fwrite($fp, $res["phpstr"]);
							fclose($fp);
						}						
					}
				}				
			}
		}else{
			$res["msg"] = "Hedef dosya bulunamdı.";
		}
		return $res;
	}
	public function firmaListele(){
		return $this->__std_call("firma_listele", array());
	}
	public function etiketListele(){
		return $this->__std_call("etiket_listele", array());
	}
	public function vknSorgula($vknVeyaTckn){
		return $this->__std_call("vkn", array("vkn"=>$vknVeyaTckn),"tip",false,false);
	}	
	public function kalanKontorSayisi(){
		return $this->__std_call("kontor", array());
	}
	public function kontorDetayi(){
		return $this->__std_call("kontor_detay", array());
	}	
	public function tek_kullanimlik_giris(){
		return $this->__std_call("login_otp", array());
	}
	public function faturaRed($aciklama="",$faturaNo="",$faturaKayitNo=null,$guid=null){
		return $this->__std_call("fatura_red", array("aciklama"=>$aciklama, "no"=>$faturaNo,"ref"=>$faturaKayitNo,"guid"=>$guid));
	}
	public function faturaKabul($aciklama="",$faturaNo="",$faturaKayitNo=null,$guid=null){
		return $this->__std_call("fatura_kabul", array( "aciklama"=>$aciklama,"no"=>$faturaNo,"ref"=>$faturaKayitNo,"guid"=>$guid));
	}	
	function __dump_myvar($var,$showFull=false){
		ob_start();
		if($showFull){
		    var_dump($var);
		}else{
		    var_dump($var);
		}		
		return ob_get_clean();
	}
	public function showVariablesAsHtml($vars,$title="",$htmlPre=null,$htmlPost=null){
		$str = "<div class=\"container\" ><h2>".$title."</h2></div>".@$htmlPre.'<div class="container">';
		if(is_array($vars)){
			foreach ($vars as $k=>$v){
				$str .= '<div class="well" style="margin-bottom:10px;" >';
				$str .= "<b>Değişken : ".$k.'</b>';
				$str .= $this->__dump_myvar($v,true);
				$str .= '</div>';
			}
		}
		$str .= '</div>'.$htmlPost;
		$this->showAsHtml($str,$title);
	}
	public function showAsHtml($htmlStr,$title="",$alert=null){
		header('Content-Type: text/html; charset=utf-8');
		if(!is_null($alert) && strlen($alert)>0){
			$htmlStr = '<div class="well"><div class="container"><div class="alert alert-'.$alert.'" role="alert">'.$htmlStr.'</div></div></div>';
		}
		$nl = "\r\n";
		$str = '<!DOCTYPE html>';
		$str .= $nl.'<html lang="en">';
		$str .= $nl.'<head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1">';
		$str .= $nl.'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
		$str .= $nl.'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">';
		$str .= $nl.'<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
		$str .= $nl.' <title>'.$title.'</title>';
		$str .= $nl.'</head><body>';
		if(is_scalar($htmlStr)){
		    $str .= $nl.$htmlStr;
		}else{
		    $str .= $this->showVariablesAsHtml($htmlStr);
		}		
		$str .= $nl.'</body></html>';
		echo $str;
		die("");
	}
	//array("KREDIKARTI/BANKAKARTI","EFT/HAVALE","KAPIDAODEME","ODEMEARACISI","DIGER");
	public function earsiv_set_odeme($odemeMetodu,$odemeTarihi=null,$aciklama=""){
		if(is_null($odemeTarihi) || $odemeTarihi==""){ $odemeTarihi = date("Y-m-d H:i:s"); }		
		$this->_extra_vars["earsiv_odeme_metodu"]  = $odemeMetodu;
		$this->_extra_vars["earsiv_odeme_aciklama"] = $aciklama;
		$this->_extra_vars["earsiv_odeme_zamani"] = date("Y-m-d H:i:s",strtotime($odemeTarihi));
	}
	public function earsiv_set_odeme_as_eft($odemeTarihi=null,$aciklama=""){
		$this->earsiv_set_odeme("eft",$odemeTarihi,$aciklama);
	}
	public function earsiv_set_odeme_as_kredikarti($odemeTarihi=null,$aciklama=""){
		$this->earsiv_set_odeme("kk",$odemeTarihi,$aciklama);
	}	
	public function earsiv_set_odeme_as_kapida($odemeTarihi=null,$aciklama=""){
		$this->earsiv_set_odeme("kapi",$odemeTarihi,$aciklama);
	}	
	public function earsiv_set_odeme_as_diger($odemeTarihi=null,$aciklama=""){
		$this->earsiv_set_odeme("diger",$odemeTarihi,$aciklama);
	}		
	public function earsiv_set_odeme_as_araci($odemeTarihi=null,$aciklama=""){
		$this->earsiv_set_odeme("araci",$odemeTarihi,$aciklama);
	}
	public function earsiv_set_gonderim_as_kagit($tarih=null){
		$this->_extra_vars["earsiv_eposta"] = "";
		$this->_extra_vars["earsiv_dagitim"] = "KAGIT";
	}
	public function earsiv_set_gonderim_as_elektronik($eposta,$tarih=null){
		if($tarih==null || $tarih==""){ $tarih = date("Y-m-d H:i:s"); }
		$this->_extra_vars["earsiv_eposta"] = $eposta;
		$this->_extra_vars["earsiv_dagitim"] = "ELEKTRONIK";	
		$this->_extra_vars["earsiv_gonderim_zamani"] = date("Y-m-d H:i:s",strtotime($tarih));
	}
	public function earsiv_set_gonderim_zamani($tarih=null){
		if($tarih==null || $tarih==""){ $tarih = date("Y-m-d H:i:s"); }
		$this->_extra_vars["earsiv_gonderim_zamani"] = date("Y-m-d H:i:s",strtotime($tarih));
	}
	public function earsiv_set_satisyeri_as_magaza(){
		$this->_extra_vars["earsiv_satis"] = "MAGAZA";		
	}
	public function earsiv_set_satisyeri_as_web($webshopUrl){
		$this->_extra_vars["earsiv_satis"] = "INTERNET";
		$this->_extra_vars["earsiv_webshop"] = $webshopUrl;		
	}	
	public function earsiv_set_kargo($kargocuAdi,$kargocuVkn){
		$this->_extra_vars["earsiv_kargo_adi"] = $kargocuAdi;
		$this->_extra_vars["earsiv_kargo_vkn"] = $kargocuVkn;						
	}	
	public function callTestFunction(){
		return $this->__std_call("testfunction",array());
	}
	public function faturayiGoster($sonuc){
		if(is_array($sonuc) && key_exists("isok", $sonuc)){
			$htmlStr=  @$sonuc["data"]["html"];			
			if(strlen($htmlStr)>0){
				header('Content-Type: text/html; charset=utf-8');
				echo $htmlStr;
				die("");
			}
		}
		die("SONUC UYGUN DEGIL !");
	}
	public function __setFaturaKayitNoOrFaturaNo($kayitNoVeyaFaturaNo,&$p){
		$tmp = preg_replace("/[^0-9]/", "",$kayitNoVeyaFaturaNo);
		if(strlen($kayitNoVeyaFaturaNo)>strlen($tmp)){
			$p["no"] = $kayitNoVeyaFaturaNo;
		}else{
			$p["ref"] = $kayitNoVeyaFaturaNo;
		}		
	}
	public function epostaGonder($kayitNoVeyaFaturaNo,$tip="earsiv",$gonderilecekAdresler=null,$konu=null,$sablon=null){		
		$p = array("tip"=>$tip,"adresler"=>$gonderilecekAdresler,"konu"=>$konu,"sablon"=>$sablon);
		$this->__setFaturaKayitNoOrFaturaNo($kayitNoVeyaFaturaNo, $p);
		return $this->__std_call("eposta_gonder", $p);
	}
	public function earsivFaturaIptali($kayitNoVeyaFaturaNo){
		$p = array("tip"=>"earsiv");
		$this->__setFaturaKayitNoOrFaturaNo($kayitNoVeyaFaturaNo, $p);
		return $this->__std_call("earsiv_iptal", $p);
	}
	public function earsivFaturasiniSil($kayitNoVeyaFaturaNo){
		$p = array("tip"=>"earsiv");
		$this->__setFaturaKayitNoOrFaturaNo($kayitNoVeyaFaturaNo, $p);
		return $this->__std_call("earsiv_sil", $p);
	}	
	public function sendSms($text,$cepNo,$label="",$kayitOrFaturaNo=null,$tip=null){
		return $this->__std_call("send_sms", array("text"=>$text, "cep"=>$cepNo,"label"=>$label,"faturano"=>$kayitOrFaturaNo,"tip"=>$tip));
	}
	public function getOrnekFaturaArray(){
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
				"SATIR 2 KOD"=>"KOD2",
				"SATIR 2 AÇIKLAMA"=>"ACIKLAMA 2",
				"SATIR 2 MİKTAR"=>"7",
				"SATIR 2 BİRİM"=>"ADET",
				"SATIR 2 BİRİM FİYAT"=>10,
				"SATIR 2 KDV ORANI"=>18,
				"FATURA SENARYOSU"=>"TİCARİ",
		);
		return $FATURA_DATA;
	}	
	public function postData($action,$postDataExtra=null,$extraPostParams2=null){
		$postData = array();
		$postData["musteri"] = $this->_musteri;
		$postData["kullanici"] = $this->_kullanici;
		$postData["sifre"] = $this->_sifre;
		if(!is_null($postDataExtra) && is_array($postDataExtra)){
		    foreach ($postDataExtra as $k=>$v){ $postData[$k]  = $v; }
		}
		if(!is_null($extraPostParams2) && is_array($extraPostParams2)){
		    foreach ($extraPostParams2 as $k=>$v){ $postData[$k]  = $v; }
		}
		$actionUrl = $this->_baseUrl."?action=".$action;
		//GAPP::dumpVar(array($postData,$actionUrl));
		$res = $this->postDataToUrl($actionUrl,$postData);		
		return $res;
	}
	public function postDataToUrl($url,$postData=null){
		$curlObject = curl_init();
		curl_setopt($curlObject, CURLOPT_URL, $url);
		curl_setopt($curlObject, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curlObject, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObject, CURLOPT_POST, 1);
		curl_setopt($curlObject,CURLOPT_TIMEOUT,10);
		curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);
		if(is_array($postData) && count($postData)>0){
			$postVarsAsString = http_build_query($postData);
			curl_setopt($curlObject, CURLOPT_POSTFIELDS, $postVarsAsString);
		}else{
			
		}
		$data = @curl_exec($curlObject);
		@curl_close ($curlObject);
		return $data;
	}
	public function pdf($faturaNo,$tip="auto",$dosyaFormati="pdf",$vkn="",$extraParams=null){
	    return $this->postData("faturapreview",array("faturano"=>$faturaNo,"tip"=>$tip,"output"=>$dosyaFormati,"vkn"=>$vkn),$extraParams);
	}
	public function faturaKaydet($klasor,&$msg,$faturaNo,$tip="auto",$dosyaFormati="pdf",$vkn=""){
		$arr = array("isok"=>false,"errors"=>array(),"msg"=>array());
		$msg    = "";
		$uzanti = "pdf";
		if($dosyaFormati=="html"){ $uzanti = "html"; }
		$dosya = $klasor.$faturaNo.".".$uzanti;
		$msg   = ""; 
		if(strlen($klasor)==0 || substr($klasor, -1)!=="/"){
			$arr["errors"][] = "Lütfen Klasör yolu belirtirken sonunda / işareti olduğundan emin olunuz.";
			return $arr;
		}
		if(file_exists($dosya)){
			$msg = "".$dosya." dosyası olduğu için tekrar indirilmedi.";
		}else{
			$data = $this->pdf($faturaNo,$tip,$dosyaFormati,$vkn);	
			if(strlen(@$data)>0){
				file_put_contents($dosya, $data);
				$msg = "OK : ".$dosya." kayıt edildi.";
			}elsE{
				$msg = "İçerik boş geldi.";
			}
		}
		return $arr;
	}
	public function sonGonderilenFaturalariKaydet($gunSayisi,$dosyaFormati="pdf",$klasor="",$vkn="",$timeoutZamani=30){
		$arr = array("isok"=>false,"errors"=>array(),"msg"=>array(),"efatura"=>0,"earsiv"=>0,"zaman_asimi"=>false,"efatura_list"=>array(),"earsiv_list"=>array());
		if(strlen($klasor)==0 || substr($klasor, -1)!=="/"){
			$arr["errors"][] = "Lütfen Klasör yolu belirtirken sonunda / işareti olduğundan emin olunuz.";
			return $arr;
		}
		$devamEdilsin = true;
		$starttime = microtime(true);
		
		$uzanti = "pdf";
		if(file_exists($klasor) && is_dir($klasor)){
			$sonFaturalar = $this->sonGonderilenFaturalar($gunSayisi);
			$arr["msg"][] = @$sonFaturalar["msg"];
			if($sonFaturalar["isok"]){
				$arr["efatura"] = @count($sonFaturalar["data"]["efatura"]);
				$arr["earsiv"]  = @count($sonFaturalar["data"]["earsiv"]);
				if($arr["efatura"]>0){
					foreach ($sonFaturalar["data"]["efatura"] as $k=>$v){
						$endtime = microtime(true);
						$timediff = $endtime - $starttime;
						if($timediff>$timeoutZamani){ $devamEdilsin = false; }
						if($devamEdilsin){
							$this->faturaKaydet($klasor, $msg, @$v["belgeno"],"efatura",$dosyaFormati,$vkn);
						}else{ $msg = "İşlem zaman aşımı sebebi ile kesildi."; }						
						$arr["efatura_list"][] = array_merge($v,array("islem"=>$msg));						
					}
				}
				if($arr["earsiv"]>0){
					foreach ($sonFaturalar["data"]["earsiv"] as $k=>$v){
						$endtime = microtime(true);
						$timediff = $endtime - $starttime;
						if($timediff>$timeoutZamani){ $devamEdilsin = false; }						
						if($devamEdilsin){
							$this->faturaKaydet($klasor, $msg, @$v["belgeno"],"earsiv",$dosyaFormati,$vkn);
						}else{ $msg = "İşlem zaman aşımı sebebi ile kesildi."; }
						$arr["efatura_list"][] = array_merge($v,array("islem"=>$msg));						
					}
				}
				if(!$devamEdilsin){ $arr["zaman_asimi"] = true; }
			}else{
				$arr["errors"][] = @$sonFaturalar["error"];
				
			} 
		}else{
			$arr["errors"][] = "Klasör bulunamadı.";
			$arr["errors"][] = "Aranan klasor : ".$klasor;
			return $arr;
		}
		return $arr;
	}
	public function initMe($musteriKodu,$kullaniciAdi="",$sifre="",$url=null,$apiKey=null,$createApikeyOnNull=false){
	    if(!function_exists('curl_version')){
	        die("LUTFEN SUNUCUYA PHP ICIN CURL KUTUPHANESINI YUKLEYINIZ ...");
	    }
	    if(is_array($musteriKodu) ){
	        $this->_musteri = @$musteriKodu["musteri"];
	        $this->_kullanici = @$musteriKodu["kullanici"];
	        $this->_sifre = @$musteriKodu["sifre"];
	        if(strlen(@$musteriKodu["url"])>0){ $this->_baseUrl= @$musteriKodu["url"];  }
	        if(strlen(@$musteriKodu["apikey"])>0){ $this->setApiKey(@$musteriKodu["apikey"]); }
	    }else{
	        $this->_musteri = $musteriKodu;
	        $this->_kullanici = $kullaniciAdi;
	        $this->_sifre = $sifre;
	        if(!is_null($url) && strlen($url)>0){ $this->_baseUrl= $url;  }
	        if(!is_null($apiKey)){ $this->setApiKey($apiKey); }
	    }
	    if($createApikeyOnNull && @$this->__apiKey==""){
	        GAPP::import("projects/efaturacim/export/apikey.php");
	        $apiKey = EFATURACIM_APIKEY_UTIL::createApiKey("",$this->_musteri,$this->_kullanici,false);
	        if(strlen($apiKey)>0){ $this->setApiKey($apiKey); }
	    }
	    $this->log("CREATING EFATURACIM_ISTEMCI => ".$this->_musteri."|".$this->_kullanici." => ".$this->_baseUrl,10);
	    if(defined("EFATURACIM__BASEURL")){
	        if(strlen(EFATURACIM__BASEURL)>0){
	            $this->_baseUrl = EFATURACIM__BASEURL;
	        }
	    }
	    if(strlen($url)>0){
	        if(strtolower($url)=="canli"){
	            $this->_baseUrl = "https://efaturacim.orkestra.com.tr/servis.php";
	        }else if(strtolower($url)=="test"){
	            $this->_baseUrl = "https://b2.orkestra.com.tr/efaturacim/servis.php";
	        }else{
	            $this->_baseUrl = $url;
	        }	       
	    }
	}
	public function checkLogEnabled(){
	    if($this->_debug && class_exists("GAPP")){ return true; }else{ return false; }
	}
	public function log($str,$severity=0){
	    if($this->checkLogEnabled()){
	        GAPP::getApp()->log($str,null,$severity);
	    }
	}
	
}
?>