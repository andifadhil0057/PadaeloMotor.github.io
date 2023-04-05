<?php 
  include '_header-artibut.php';
?>
<?php  
  $status = $_SESSION['user_status'];
    if ( $status === '0') {
    echo"
          <script>
            alert('Akun Tidak Aktif');
            window.location='./';
          </script>";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nota Cetak POS - Seniman Koding</title>
	<meta charset=utf-8>
	<meta name=description content="">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<!-- Tempusdominus Bootstrap 3 -->
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap-3.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/style.css">

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php  
	// ambil data di URL
	$id = abs((int)$_GET['no']);

	// query data 
	$invoice = query("SELECT * FROM invoice_pembelian WHERE invoice_pembelian_id = $id && invoice_pembelian_cabang = $sessionCabang ")[0];
	$tipeTransaksi = $invoice['invoice_hutang'];
?>

<!-- Nama Kasir -->
<?php  
    $kasir = $invoice['invoice_kasir'];
    $dataKasir = query("SELECT * FROM user WHERE user_id = $kasir");
?>
<?php foreach ( $dataKasir as $ksr ) : ?>
    <?php $ksrDetail = $ksr['user_nama']; ?>
<?php endforeach; ?>

<!-- Nama Customer -->
<?php  
    $supplier = $invoice['invoice_supplier'];
    $dataSupplier = query("SELECT * FROM supplier WHERE supplier_id = $supplier");
?>
<?php foreach ( $dataSupplier as $ctr ) : ?>
    <?php 
        $ctrNama   = $ctr['supplier_nama']; 
        $ctrCmpn   = $ctr['supplier_company']; 
        $ctrAlmt   = $ctr['supplier_alamat']
    ?>
<?php endforeach; ?>

<?php  
    $toko = query("SELECT * FROM toko WHERE toko_cabang = $sessionCabang");
?>
<?php foreach ( $toko as $row ) : ?>
    <?php 
    	$toko_nama 				= $row['toko_nama'];
    	$toko_kota 				= $row['toko_kota'];
    	$toko_tlpn 				= $row['toko_tlpn'];
    	$toko_wa   				= $row['toko_wa']; 
    	$toko_print				= $row['toko_lebar_print_toko']; 
    	$toko_alamat    		= $row['toko_alamat'];
    	$toko_tipe_print_toko   = $row['toko_tipe_print_toko'];
    ?>
<?php endforeach; ?>

<?php  
	$lebarPrint = $toko_print."cm";
?>
	
	<?php if ( $toko_tipe_print_toko > 0 ) : ?>
	<section class="nota" style="width: <?= $lebarPrint; ?>;">
		<div class="nota-box">
			<div class="nota-box-title">
				<div class="nbt-parent">
					<?= $toko_nama; ?>
				</div>
				<div class="nbt-address">
					<?= $toko_kota; ?>
				</div>
				<div class="nbt-contact">
					<ul>
					    <li><b>No.tlpn:</b> <?= $toko_tlpn; ?></li>
					    <li><b>Wa:</b> <?= $toko_wa; ?></li>
					</ul>
				</div>
			</div>

			<div class="nota-box-info">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-padding-nota-kecil">
						<div class="nbi-text">
							<div class="nbi-text-parent">
								<b>Tanggal:</b> <?= $invoice['invoice_tgl']; ?>
							</div>
							<div class="nbi-text-parent">
								<b>Invoice:</b> <?= $invoice['pembelian_invoice']; ?>
							</div>
							<div class="nbi-text-parent">
								<b>Transaksi:</b> 
								<?php  
									if ( $tipeTransaksi < 1 ) {
										echo "Cash";
									} else {
										echo "Hutang";
									}
								?>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-padding-nota-kecil">
						<div class="nbi-text nbi-text-2">
							<div class="nbi-text-parent">
								<b>Kasir:</b> <?= $ksrDetail; ?>
							</div>
							<div class="nbi-text-parent">
								<b>Supplier:</b> <?= $ctrNama; ?> - <?= $ctrCmpn; ?>
							</div>

							<?php if ( $tipeTransaksi == 1 ) { ?>
							<div class="nbi-text-parent">
								<b>Jatuh Tempo:</b> <?= tanggal_indo($invoice['invoice_hutang_jatuh_tempo']); ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<div class="nota-box-table">
				<table class="table">
					<?php 
                      $invoice1 = $invoice['pembelian_invoice_parent'];
	                  $i = 1; 
	                  $queryProduct = $conn->query("SELECT pembelian.pembelian_id, barang.barang_id, barang.barang_nama, pembelian.barang_harga_beli, pembelian.barang_qty, pembelian.pembelian_invoice, pembelian.pembelian_cabang
	                             FROM pembelian 
	                             JOIN barang ON pembelian.barang_id = barang.barang_id
	                             WHERE pembelian_invoice_parent = $invoice1 && pembelian_cabang = '".$sessionCabang."'
	                             ORDER BY pembelian_id DESC
	                             ");
	                  while ($rowProduct = mysqli_fetch_array($queryProduct)) {
	                ?>
					<tr>
						<td><?= $rowProduct['barang_nama']; ?></td>
                      	<td><?= $rowProduct['barang_qty']; ?></td>
                      	<td><?= number_format($rowProduct['barang_harga_beli'], 0, ',', '.'); ?></td>
                      	<td>
                      	<?php  
                      		$subTotal = $rowProduct['barang_qty'] * $rowProduct['barang_harga_beli'];
                      		echo(number_format($subTotal, 0, ',', '.'));
                      	?>
                      	</td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<div class="nota-box-text">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="nbt-text">
							<b>Total :</b> 
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						Rp. <span class="right-nota">
								<?= number_format($invoice['invoice_total'], 0, ',', '.'); ?>
							</span>
					</div>

					<?php if ( $tipeTransaksi == 1 ) { ?>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="nbt-text">
							<b>DP :</b>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						Rp. <span class="right-nota">
								<?= number_format($invoice['invoice_hutang_dp'], 0, ',', '.'); ?>
							</span>
					</div>
					<?php } ?>

					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="nbt-text">
							<b>
								<?php  
									if ( $tipeTransaksi < 1 ) {
										echo "Bayar :";
									} else {
										echo "DP + Cicilan :";
									}
								?>
							</b>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						Rp. <span class="right-nota">
								<?= number_format($invoice['invoice_bayar'], 0, ',', '.'); ?>
							</span>
					</div>

					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="nbt-text">
							<b>
								<?php  
									if ( $tipeTransaksi < 1 ) {
										echo "Kembali :";
									} else {
										echo "Sisa Hutang :";
									}
								?>
							</b>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						Rp. <span class="right-nota">
								<?= number_format($invoice['invoice_kembali'], 0, ',', '.'); ?>
							</span>
					</div>
				</div>
			</div>

			<div class="nota-box-footer">
				<div class="nbf-text">
					Powered By
				</div>
				<div class="nbf-url">
					www.senimankoding.com
				</div>
			</div>
		</div>
	</section>

	<?php else : ?>
	<section class="nota-lebar">
        <div class="">
            <div class="nota-lebar-box">
                <div class="nzb-top">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="nzb-top-text">
                                <p><span><b><?= $toko_nama; ?></b></span></p>
                                <p><?= $toko_alamat; ?></p>
                                <p><?= $toko_kota; ?></p>
                                <p><?= $toko_tlpn; ?> - <?= $toko_wa; ?></p>
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <div class="nzb-top-invoice">
                            	<table class="table">
	                                <tbody>
	                                	<tr>
	                                		<td><b>No. Invoice</b></td>
	                                		<td><b>: <?= $invoice['pembelian_invoice']; ?></b></td>
	                                	</tr>
	                                    <tr>
	                                        <td>Tanggal</td>
	                                        <td>: <?= $invoice['invoice_tgl']; ?>
	                                    </tr>
	                                    <tr>
	                                        <td>Supplier</td>
	                                        <td>: <?= $ctrNama; ?> - <?= $ctrCmpn; ?></td>
	                                    </tr>
	                                </tbody>
	                            </table>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-padding">
                            <div class="nzb-top-invoice">
                                <table class="table">
	                                <tbody>
	                                    <tr>
	                                        <td>Transaksi</td>
	                                        <td>: 
	                                            <?php  
	                                                if ( $tipeTransaksi < 1 ) {
														echo "Cash";
													} else {
														echo "Hutang";
													}
	                                            ?>
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td>Kasir</td>
	                                        <td>: <?= $ksrDetail; ?></td>
	                                    </tr>

	                                    <?php if ( $tipeTransaksi == 1 ) { ?>
	                                    <tr>
	                                        <td>Jatuh Tempo</td>
	                                        <td>: <?= tanggal_indo($invoice['invoice_hutang_jatuh_tempo']); ?>
	                                        </td>
	                                    </tr>
	                                    <?php } ?>
	                                </tbody>
	                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nzb-desc">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center">Qt</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center" style="width: 230px">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
		                      $invoice1 = $invoice['pembelian_invoice_parent'];
			                  $i = 1; 
			                  $queryProduct = $conn->query("SELECT pembelian.pembelian_id, barang.barang_id, barang.barang_nama, pembelian.barang_harga_beli, pembelian.barang_qty, pembelian.pembelian_invoice, pembelian.pembelian_cabang
			                             FROM pembelian 
			                             JOIN barang ON pembelian.barang_id = barang.barang_id
			                             WHERE pembelian_invoice_parent = $invoice1 && pembelian_cabang = '".$sessionCabang."'
			                             ORDER BY pembelian_id DESC
			                             ");
			                  while ($rowProduct = mysqli_fetch_array($queryProduct)) {
			                ?>
                            <tr>
                                <td><?= $rowProduct['barang_nama']; ?></td>
                                <td class="text-center"><?= $rowProduct['barang_qty']; ?></td>
                                <td class="text-right"><?= number_format($rowProduct['barang_harga_beli'], 0, ',', '.'); ?></td>
                                <td class="text-right">
                                <?php  
		                      		$subTotal = $rowProduct['barang_qty'] * $rowProduct['barang_harga_beli'];
		                      		echo(number_format($subTotal, 0, ',', '.'));
		                      	?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="nota-box-text">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="nzb-ttd-box">
                                <div class="nzb-ttd-box-company">
                                    <?= $toko_nama; ?> <?= $toko_kota; ?>
                                </div>
                                <div class="nzb-ttd-box-line">
                                    ____________________________
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>

                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <div class="row nbt-text-price">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="nbt-text">
                                        <b>Total :</b>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                             
                                        <b>
                                            Rp <span class="right-nota">
                                                <?= number_format($invoice['invoice_total'], 0, ',', '.'); ?>
                                            </span>
                                        </b>
                                  
                                </div>


                                <?php if ( $tipeTransaksi == 1 ) { ?>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
									<div class="nbt-text">
										<b>DP :</b>
									</div>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									Rp. <span class="right-nota">
											<?= number_format($invoice['invoice_hutang_dp'], 0, ',', '.'); ?>
										</span>
								</div>
								<?php } ?>

								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
									<div class="nbt-text">
										<b>
											<?php  
												if ( $tipeTransaksi < 1 ) {
													echo "Bayar :";
												} else {
													echo "DP + Cicilan :";
												}
											?>
										</b>
									</div>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									Rp. <span class="right-nota">
											<?= number_format($invoice['invoice_bayar'], 0, ',', '.'); ?>
										</span>
								</div>

								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
									<div class="nbt-text">
										<b>
											<?php  
												if ( $tipeTransaksi < 1 ) {
													echo "Kembali :";
												} else {
													echo "Sisa Hutang :";
												}
											?>
										</b>
									</div>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									Rp. <span class="right-nota">
											<?= number_format($invoice['invoice_kembali'], 0, ',', '.'); ?>
										</span>
								</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nzb-footer">
                    <div class="nzb-footer-box">
                        <div class="nota-box-footer">
                            <div class="nbf-text">
                                Powered By: www.senimankoding.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</body>
</html>
<script>
	window.print();
</script>