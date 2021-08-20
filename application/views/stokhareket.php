<link rel="stylesheet" href="<?php echo site_url('assets/grocery_crud/themes/flexigrid/css/') ?>flexigrid.css">
<?php $this->load->view('header_ozel.php');?>
<body>


	<div class="">


		<div class="flexigrid">
			<div class="mDiv">
				<div class="ftitle">
					<input id="ftitle__header" type="button" value="<?php echo $stok_adi; ?>">
				</div>
			</div>
			<div class="bDiv">
				<table cellspacing="0" cellpadding="0" border="0">
					<thead>
						<tr class="hDiv">
							<th width="20%">
								<div class="text-left">Tarih</div>
							</th>
							<th width="20%">
								<div class="text-left">Alış/Satış</div>
							</th>
							<th width="20%">
								<div class="text-left">İşlem Türü</div>
							</th>
							<th width="10%">
								<div class="text-left">Miktar</div>
							</th>
							<th width="10%">
								<div class="text-left">Son</div>
							</th>
							<th width="20%">
								<div class="text-left">Link</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php

$n = 0;
if ($stokhareket): foreach ($stokhareket as $dizi):
        if ($dizi["fatura_turu"] == "Gider") {
            continue;
        }
        if (($dizi["islem_turu"] == "fatura") && ($dizi["irsaliye_durum"] == 1)) {
            $n = $n + 1;
            continue;
        }

        if ($dizi["fatura_turu"] == "Satış") {
            $stok_baslangic = $stok_baslangic - $dizi["adet"];
        }
        if ($dizi["fatura_turu"] == "Alış") {
            $stok_baslangic = $stok_baslangic + $dizi["adet"];
        }

        ?>
									<tr>
										<td width="20%">
											<div class="text-left">
												<?php echo $dizi["fatura_tarihi"]; ?>
											</div>
										</td>
										<td width="20%">
											<div class="text-left">
												<?php echo $dizi["fatura_turu"]; ?>
											</div>
										</td>
										<td width="20%">
											<div class="text-left">
												<?php echo $dizi["islem_turu"]; ?>
											</div>
										</td>
										<td width="10%">
											<div class="text-left">
												<?php echo $dizi["adet"] ?>
											</div>
										</td>
										<td width="10%">
											<div class="text-left">
												<?php echo $stok_baslangic; ?>
											</div>
										</td>
										<td width="20%">
											<div class="text-left">
												<?php
        $fatura_tipi_link = '';
        if ($dizi["islem_turu"] == "irsaliye") {
            $fatura_tipi_link = 'irsaliye_goruntule';
        }
        if ($dizi["islem_turu"] == "fatura") {
            $fatura_tipi_link = 'fatura_goruntule';
        }
        ?>
												<a class="btn btn-default"
												href="<?php echo base_url() . "yonetim/" . $fatura_tipi_link . "/" . $dizi["fatura_id"]; ?>"
												>Görüntüle</a>
											</div>
										</td>
									</tr>
									<?php $n = $n + 1;endforeach;endif;?>
						</tbody>

					</table>
				</div>
				<h3 class="material-container__heading table-sonuc-title">
					Güncel Stok Miktarı:
					<span class="table-sonuc-title__number">
						<?php echo $stok_baslangic; ?>
					</span>
				</h3>
			</div>
		</div>
	</div>
</body>

<?php $this->load->view('footer_ozel.php');?>