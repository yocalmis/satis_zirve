<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

?>
<!--<a href="javascript:printDiv('.pageInner');" class="sidenav__link">
				<span class="sidenav__icon ico-settings"></span>
				Görünümü Yazdır
			</a>-->

 <script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.querySelector(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

</div>
</main>
<div class="s-n_o"></div>
<script>
	"use strict";

	document.body.onload = function () {
		setTimeout(function () {
			var preloader = document.getElementById('preloader');

			if (!preloader.classList.contains('done')) {
				preloader.classList.add('done');
				setTimeout(function () {
					preloader.parentNode.removeChild(preloader);
				}, 300);
			}
		}, 150);
	};
</script>




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



<script type="text/javascript" src="<?php echo site_url('assets') ?>/fetch.umd.js" async></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/waves.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/simplebar.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/jquery.sumoselect.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/polyfills.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/function.js"></script>


</body>
</html>
