<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Giriş || <?php echo PROGRAM_NAME; ?></title>
	<meta charset="UTF-8">
	<meta charset="utf-8" />
	<link href="<?php echo site_url('assets') ?>/fonts/roboto/roboto.css" type="text/css" rel="stylesheet" defer>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/userops.css">
	<meta name="author" content="Back end: Yusuf Öcalmış, Front end: Muhammed Teuvajukov">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ffffff">
	<meta name="msapplication-navbutton-color" content="#ffffff">
	<meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url('assets/favicon') ?>/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url('assets/favicon') ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/favicon') ?>/favicon-16x16.png">
	<link rel="manifest" href="<?php echo site_url('assets/favicon') ?>/site.webmanifest">
	<link rel="mask-icon" href="<?php echo site_url('assets/favicon') ?>/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">



</head>

<body>




	<div class="input-inner">
		<div class="input-inner__header">
			<img class="input-inner__logo" src="<?php echo site_url('assets/favicon') ?>/android-chrome-192x192.png" alt="Bina Yönetimi Logo">
			<h3 class="input-inner__title"><?php echo PROGRAM_NAME; ?></h3>
			<p class="input-inner__description">Giriş bilgileriniz ile giriş yapınız.</p>
		</div>

		<form method='post' class="input-inner__form" id="theForm" action="yonetim/kontrol">
			<div class="input-field">
				<input class="input-field__input" type="text" id="code" name="code" required>
				<label class="input-field__placeholder" for="code">Kullanıcı Kodu</label>
				<div class="input-field__error">
					<svg class="input-field__error--image" xmlns="https://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
					Lütfen kullanıcı kodunu doğru giriniz.
				</div>
			</div>

			<div class="input-field">
				<input class="input-field__input" type="text" id="username" name="kullanici" required>
				<label class="input-field__placeholder" for="username">Kullanıcı Adı</label>
				<div class="input-field__error">
					<svg class="input-field__error--image" xmlns="https://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
					Lütfen kullanıcı adını doğru giriniz.
				</div>
			</div>

			<div class="input-field">
				<input class="input-field__input" type="password" id="password" name="sifre" required>
				<label class="input-field__placeholder" for="password">Şifre</label>
				<div class="input-field__error">
					<svg class="input-field__error--image" xmlns="https://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
					Lütfen şifrenizi doğru giriniz.
				</div>
			</div>

			<a href="<?php echo base_url(); ?>yonetim/pass_remember" class="forgotPass">
				Şifrenizi mi unuttunuz? 
				
			</a>
<?php  if($this->session->userdata($this->session->userdata("deneme_username")."giris_deneme_hatasi"))
				{
echo"<br><center><p style='color:red;'>Üstüste 3 hatalı giriş denemesi nedeniyle ".$this->session->userdata("deneme_username")."<br> hesabı 15 dakikalığına bloke edilmiştir.</p></center>";
             $this->session->set_userdata( "xxx", date('Y-m-d h:i:s'));
             $bitis=strtotime($this->session->userdata("xxx"));           
             $bas=strtotime($this->session->userdata("baslangic"));
             $dk=round(abs($bitis - $bas) / 60,0);

  
            if($dk>=1){
             $this->session->set_userdata( $this->session->userdata("deneme_username")."giris_deneme_hatasi", "");
             $this->session->unset_userdata($this->session->userdata("deneme_username").'_giris_adedi');
             $this->session->unset_userdata('baslangic');
             $this->session->unset_userdata('bitis');

            }

				} ?>
			<div class='login'>
				<a class="newAccount" href="<?php echo base_url(); ?>yonetim/adminkayit">Hesap oluşturun</a>
				<input type='submit' class="login__button" value='GİRİŞ'>
			</div>



		</form>



	</div>

	<script src="<?php echo base_url(); ?>assets/validate.min.js"></script>
	<script>
		var
		userNameRegex	=/^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z]{8,}$/,
		passRegex		= /^(?=.*\d)(?=.*[a-z])[0-9a-zA-Z]{8,}$/,
		login 			= {
			username: {
			//	format: userNameRegex,
				length: {
					minimum: 4,
					maximum: 24
				}
			},
			password: {
		//		format: passRegex
			}
			code: {
		//		format: passRegex
			}
		};

		document.querySelector('.login__button').onclick = function (event) {
			var
			userName	= document.getElementById('username'),
			pass		= document.getElementById('password'),
			code		= document.getElementById('code'),			
			result		= validate({
				username: userName.value,
				password: pass.value,
				code:code.value

			}, login);

			if (result === undefined) {
				userName.parentNode.querySelector('.input-field__error').classList.remove('input-field__error--active');
				userName.parentNode.querySelector('.input-field__error').style.maxHeight = '0';
				pass.parentNode.querySelector('.input-field__error').classList.remove('input-field__error--active');
				pass.parentNode.querySelector('.input-field__error').style.maxHeight = '0';
				return true;
			}
			else {
				if (result.username != undefined) {
					userName.parentNode.querySelector('.input-field__error').style.maxHeight = '17px';
					userName.parentNode.querySelector('.input-field__error').classList.add('input-field__error--active');
				}
				else if (result.username === undefined) {
					userName.parentNode.querySelector('.input-field__error').classList.remove('input-field__error--active');
					userName.parentNode.querySelector('.input-field__error').style.maxHeight = '0';
				}
				if (result.password != undefined) {
					pass.parentNode.querySelector('.input-field__error').classList.add('input-field__error--active');
					pass.parentNode.querySelector('.input-field__error').style.maxHeight = '17px';
				}
				else if (result.password === undefined) {
					pass.parentNode.querySelector('.input-field__error').classList.remove('input-field__error--active');
					pass.parentNode.querySelector('.input-field__error').style.maxHeight = '0';
				}
				if (result.code != undefined) {
					code.parentNode.querySelector('.input-field__error').classList.add('input-field__error--active');
					code.parentNode.querySelector('.input-field__error').style.maxHeight = '17px';
				}
				else if (result.code === undefined) {
					code.parentNode.querySelector('.input-field__error').classList.remove('input-field__error--active');
					code.parentNode.querySelector('.input-field__error').style.maxHeight = '0';
				}
				return false
			}


		}

	</script>

</body>
</html>
