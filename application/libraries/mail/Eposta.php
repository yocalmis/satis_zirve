<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eposta {



function kayit($url,$name,$email,$return)
{

include("class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.yandex.ru';
$mail->Port = 465;
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";
$mail->Username = "yusuf@zirvekayseri.com"; // Mail adresimizin kullanicı adi
$mail->Password = "234567y."; // Mail adresimizin sifresi
//$mail->SetFrom("Saray Mefruşat İletişim Formu", "aaaa"); // Mail attigimizda gorulecek ismimiz

$mail->SetFrom("yusuf@zirvekayseri.com");
$mail->addReplyTo("yusuf@zirvekayseri.com");

//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("kayhan@saraymefrusat.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
$mail->AddAddress($email); // Maili gonderecegimiz kisi yani alici
$mail->Subject = "Ticari Yazılım Yeni Üye Kaydı Onay"; // Konu basligi
$mail->Body = "<b><br><br>Hoşgeldiniz ".$name." Ticari Yönetim Sistemi üyeliğinizi aktifleştirmeniz gerekmektedir.<br>
Aktifleştirmek için <a href='".$url."yonetim/success/".$return."'>tıklayınız</a>.</b>" ; // Mailin icerigi
if(!$mail->Send()){
	return FALSE;
} else {
	return TRUE;
}




}




function kayit_onay_bilgi($url,$uye_onay)
{

include("class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.yandex.ru';
$mail->Port = 465;
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";
$mail->Username = "yusuf@zirvekayseri.com"; // Mail adresimizin kullanicı adi
$mail->Password = "234567y."; // Mail adresimizin sifresi
//$mail->SetFrom("Saray Mefruşat İletişim Formu", "aaaa"); // Mail attigimizda gorulecek ismimiz

$mail->SetFrom("yusuf@zirvekayseri.com");
$mail->addReplyTo("yusuf@zirvekayseri.com");

//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("kayhan@saraymefrusat.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
$mail->AddAddress($uye_onay); // Maili gonderecegimiz kisi yani alici
$mail->Subject = "Ticari Yönetimi Yeni Üye Kaydı Onay"; // Konu basligi
$mail->Body = "<b><br><br>Hoşgeldiniz Ticari Yönetim Sistemi üyeliğinizi aktifleştirilmiştir.<br>
 sistemi kullanmaya başlayabilirsiniz." ; // Mailin icerigi
if(!$mail->Send()){
	return FALSE;
} else {
	return TRUE;
}




}







function new_pass($url,$pass,$email)
{


include("class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.yandex.ru';
$mail->Port = 465;
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";
$mail->Username = "yusuf@zirvekayseri.com"; // Mail adresimizin kullanicı adi
$mail->Password = "234567y."; // Mail adresimizin sifresi
//$mail->SetFrom("Saray Mefruşat İletişim Formu", "aaaa"); // Mail attigimizda gorulecek ismimiz

$mail->SetFrom("yusuf@zirvekayseri.com");
$mail->addReplyTo("yusuf@zirvekayseri.com");

//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("kayhan@saraymefrusat.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
$mail->AddAddress($email); // Maili gonderecegimiz kisi yani alici
$mail->Subject = "Ticari Yönetimi Şifre Yenileme"; // Konu basligi
$mail->Body = "<b><br><br>Ticari Yönetimi şifrenizi yenilemek için <br>
<a href='".$url."yonetim/new_pass_success/".$pass."'>tıklayınız</a>.</b>" ; // Mailin icerigi
if(!$mail->Send()){
	return FALSE;
} else {
	return TRUE;
}




}





function hata($ad,$hd,$ac)
{

include("class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.yandex.ru';
$mail->Port = 465;
$mail->IsHTML(true);
$mail->SetLanguage("tr", "phpmailer/language");
$mail->CharSet  ="utf-8";
$mail->Username = "yusuf@zirvekayseri.com"; // Mail adresimizin kullanicı adi
$mail->Password = "234567y."; // Mail adresimizin sifresi
//$mail->SetFrom("Saray Mefruşat İletişim Formu", "aaaa"); // Mail attigimizda gorulecek ismimiz

$mail->SetFrom("yusuf@zirvekayseri.com");
$mail->addReplyTo("yusuf@zirvekayseri.com");

//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("kayhan@saraymefrusat.com"); // Maili gonderecegimiz kisi yani alici
//$mail->AddAddress("yocalmis@gmail.com"); // Maili gonderecegimiz kisi yani alici
$mail->AddAddress("yusuf@zirvekayseri.com"); // Maili gonderecegimiz kisi yani alici
$mail->Subject = "Ticari Hata Bildirimi"; // Konu basligi
$mail->Body = "<b><br><br>
".$ad."<br><br>
".$hd."<br><br>
".$ac."<br><br>
</b>" ; // Mailin icerigi
if(!$mail->Send()){
	return FALSE;
} else {
	return TRUE;
}




}





}


?>