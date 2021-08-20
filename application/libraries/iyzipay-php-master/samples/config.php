<?php

require_once(boot);

$donus=donus;
$donus2=donus2;

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
		
		        $options = new \Iyzipay\Options();
	  $options->setApiKey(odeme_api);
      $options->setSecretKey(odeme_secret);
      $options->setBaseUrl(odeme_base);	

		/*
		if(odeme_reel==0){
			
	  $options->setApiKey("sandbox-Ob4o46YkMlAqenETM75mlZx5EAH0lky9");
      $options->setSecretKey("sandbox-IGJY0Tdh1HhLDAd4VstfsmNjNVqWxSmE");
      $options->setBaseUrl("https://sandbox-api.iyzipay.com");	
			
		}
		else{
			
	     $options->setApiKey("YJS6WaJxQKOGVpoMZryTk68KmNWmhSeS");
         $options->setSecretKey("rU1jUL8qr7oAiTZQrGzKdfsESkeYzzd7");
         $options->setBaseUrl("https://api.iyzipay.com");		
		}
		*/
		


        return $options;
    }
}