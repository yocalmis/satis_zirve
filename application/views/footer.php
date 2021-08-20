<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

?>

<!--
<a href="javascript:printDiv('.pageInner');" class="sidenav__link">
				<span class="sidenav__icon ico-settings"></span>
				Görünümü Yazdır
			</a>
-->
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
<?php foreach ($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach;?>


<script type="text/javascript" src="<?php echo site_url('assets') ?>/fetch.umd.js" async></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/waves.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/simplebar.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/jquery.sumoselect.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/polyfills.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets') ?>/function.js"></script>


</body>
</html>
